<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="refresh" content="20" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEMPO EDF - J et J+1</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .half {
            width: 50%;
            height: 100%;
            display: inline-block;
            position: relative;
            color: #ffffff; /* Blanc */
        }

        .separator {
            width: 10px;
            height: 100%;
            background-color: #000000; /* Noir */
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .date-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 10px;
            background-color: #000000; /* Noir */
            border-radius: 5px;
            color: #ffffff; /* Blanc */
            font-family: Arial, sans-serif;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
<?php
    // Lire le contenu du fichier
    $filename = 'output.txt';
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Vérifier si le fichier a au moins deux lignes
    if (count($lines) >= 2) {
        $colorLeft = trim($lines[0]);  // Couleur de gauche
        $colorRight = trim($lines[1]); // Couleur de droite
    } else {
        // Valeurs par défaut si le fichier n'a pas assez de lignes
        $colorLeft = '#000000'; 
        $colorRight = '#000000'; 
    }
	

	// Associer une variable en fonction de la ligne
	if ($colorLeft == 'BLUE') {
		$var1 = '#3DA4D5';
	} elseif ($colorLeft == 'WHITE') {
		$var1 = '#FFFFFF';
	} elseif ($colorLeft == 'RED') {
		$var1 = '#CC0000';
	} else {
		$var1 = '#242732';
	}
	
	// Associer une variable en fonction de la ligne
	if ($colorRight == 'BLUE') {
		$var2 = '#3DA4D5';
	} elseif ($colorRight == 'WHITE') {
		$var2 = '#FFFFFF';
	} elseif ($colorRight == 'RED') {
		$var2 = '#CC0000';
	} else {
		$var2 = '#242732';
	}
?>
    <div class="half" style="background-color: <?php echo $var1; ?>;">
        <div class="date-box"><?php echo date('d/m/Y'); ?></div>
    </div>
    <div class="separator"></div>
    <div class="half" style="background-color: <?php echo $var2; ?>;">
        <div class="date-box"><?php echo date('d/m/Y', strtotime('+1 day')); ?></div>
    </div>
</body>
</html>
