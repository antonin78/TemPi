import sys
import requests
import json
import socket
import logging
import time
from datetime import datetime, timedelta

logging.captureWarnings(True)

def internet_est_disponible():
    try:
        # Essayez de créer une connexion avec un hôte Google, par exemple
        socket.create_connection(("www.google.com", 80))
        return True
    except OSError:
        pass
    return False

def get_current_and_next_day():
    # Get the current date
    current_date = datetime.now().strftime('%Y-%m-%d')
    # Calculate the next day
    next_day = (datetime.now() + timedelta(days=2)).strftime('%Y-%m-%d')
    return current_date, next_day

def get_new_token():
    auth_server_url = "https://digital.iservices.rte-france.com/token/oauth"
    client_id = ''
    client_secret = ''
    
    token_req_payload = {'grant_type': 'client_credentials'}

    token_response = requests.post(auth_server_url, data=token_req_payload, verify=False, allow_redirects=False, auth=(client_id, client_secret))
    
    if token_response.status_code != 200:
        print("Failed to obtain token from the OAuth 2.0 server", file=sys.stderr)
        sys.exit(1)
    
    print("Successfully obtained a new token")
    tokens = json.loads(token_response.text)
    return tokens['access_token']

# Vérifier la connectivité toutes les 5 secondes
while not internet_est_disponible():
    print("En attente de connexion Internet...")
    time.sleep(5)

# Obtain a token before calling the API for the first time
token = get_new_token()

while True:

    current_date, next_day = get_current_and_next_day()

    test_api_url = f"https://digital.iservices.rte-france.com/open_api/tempo_like_supply_contract/v1/tempo_like_calendars?start_date={current_date}T00:00:00+01:00&end_date={next_day}T00:00:00+01:00&fallback_status=true"

    # Call the API with the token
    api_call_headers = {'Authorization': 'Bearer ' + token}
    api_call_response = requests.get(test_api_url, headers=api_call_headers, verify=False)

    if api_call_response.status_code == 401:
        # If status code is 401, get a new token
        token = get_new_token()
    else:
        json_response = api_call_response.json()
        print(api_call_response.text)
        #print("Données stockés dans le fichier output")

        try:
            values = json_response['tempo_like_calendars']['values']

            value1 = values[0]['value']
            value0 = values[1]['value']

            print("Value ajd:", value0)
            print("Value demain:", value1)

            # Écrire les données dans un fichier texte (mode 'w' remet à zéro le fichier à chaque passage)
            with open('output.txt', 'w') as file:
                file.write(f"{value0}\n")
                file.write(f"{value1}\n")
        except:
            print ("No data available yet for tomorrow")
    # Wait for 15min before the next iteration
    time.sleep(900)
