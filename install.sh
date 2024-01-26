#!/bin/bash

#Mise à jour initiale des paquets
apt update && apt upgrade 

#Installation des prérequis
apt install python apache2 php git unclutter -y

#Suppression du fichier de base Apache2
rm /var/www/html/index.html

#Téléchargement des ressources
git clone https://github.com/antonin78/TemPi.git 

#Copie du fichier php dans la racine du serveur web
cp TemPi/index.php /var/www/html

#Création d'un emplacement pour les logs de script
mkdir ~/logs

#Mise en place du démarrage du script au lancement du système
crontab -l > gettempodays
echo "@reboot sh /home/pi/TemPi/startscript.sh > /home/pi/logs/log.txt 2>&1" >> gettempodays
crontab gettempodays

#Configuration du mode kiosk
echo -e "@lxpanel --profile LXDE-pi\n@pcmanfm --desktop --profile LXDE-pi\n@xscreensaver -no-splash\n@xset s off\n@xset -dpms\n@xset s noblank\n@chromium-browser --kiosk --incognito -disable-translate --app=http://localhost\n@unclutter -idle 0" > /etc/xdg/lxsession/LXDE-pi/autostart










