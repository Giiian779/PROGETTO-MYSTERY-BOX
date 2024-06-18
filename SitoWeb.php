<?php
// Impostazioni per visualizzare tutti gli errori PHP
ini_set('display_errors', 1);              // Abilita la visualizzazione degli errori
ini_set('display_startup_errors', 1);      // Abilita la visualizzazione degli errori di avvio
error_reporting(E_ALL);                    // Configura PHP per mostrare tutti i tipi di errori

// Connessione al database MySQL
$connection = new mysqli("localhost", "root", "", "mysterybox");
// Controlla la connessione al database
if ($connection->connect_error) {
    // Se la connessione fallisce, interrompe l'esecuzione mostrando un messaggio di errore
    die("Connessione al database fallita: " . $connection->connect_error);
}

// Ottieni il luogo utilizzando l'API di geolocalizzazione di Google Maps
$city = "Non sono riuscito"; // Default a "Non sono riuscito" in caso di errore

// Esegue una richiesta HTTP GET per ottenere i dati JSON dall'API di ip-api.com
$data = file_get_contents("http://ip-api.com/json/");

// Verifica se i dati sono stati ottenuti correttamente
if ($data) {
    // Decodifica i dati JSON in un oggetto PHP
    $json = json_decode($data);

    // Verifica se l'oggetto JSON è stato decodificato correttamente e se contiene il campo "city"
    if ($json && isset($json->city)) {
        // Se la città è disponibile, assegna il valore alla variabile $city
        $city = $json->city;
    }
}
// Stato di operatività delle macchine e ID della macchina
$Stato_macchine = 'Operativo';
$ID_macchine = 1718095570;

// Controlla se l'ID_macchine esiste già nel database
$sqlCheck = "SELECT COUNT(*) as count FROM macchine WHERE ID_macchine = '$ID_macchine'";
$resultCheck = $connection->query($sqlCheck); // Esegue la query per contare le occorrenze dell'ID_macchine
$rowCheck = $resultCheck->fetch_assoc(); // Ottiene il risultato della query come array associativo

if ($rowCheck['count'] == 0) {
    // Se l'ID_macchine non esiste nel database, esegue l'inserimento di un nuovo record
    $sql = "INSERT INTO macchine (ID_macchine, Luogo, Stato_macchine) VALUES ('$ID_macchine', '$city', '$Stato_macchine')";
    if ($connection->query($sql) === TRUE) {
        // Se l'inserimento è riuscito, non fa nulla (nessuna azione specifica richiesta qui)
    } else {
        // Se c'è stato un errore durante l'inserimento, mostra un messaggio di errore
        echo "Errore durante l'inserimento del record: " . $connection->error;
    }
}
// Chiude la connessione al database
$connection->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mystery Box</title>
    <link rel="stylesheet" type="text/css" href="css/Style.css">

    <style>
        /* Stili CSS interni per questa pagina */
        .function, .sorpresa, .codice, .comprare {
            padding: 0px;
            text-align: center;
        }
        .scrittura, .scrittura2, .scrittura3, .scrittura4 {
            margin: 10px auto;
            max-width: 600px;
            text-align: center;
            font-size: 1.2em;
        }

        .content {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        /* Stili per le frecce */
        .freccia, .frecciagif {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0px auto; /* Rimuovi i margini verticali per avvicinare gli elementi */
        }

        /* Imposta altezza minima per sezioni con sfondo bianco e grigio */
        .colore-bianco, .colore-grigio {
            max-height: 300px; /* Altezza minima desiderata */
        }

        /* Nuovo contenitore flessibile per testo e freccia */
        .text-arrow-container {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin: 20px auto;
            margin-right: 5%; /* Sposta ulteriormente a destra */
        }

        /* Nuovo contenitore flessibile per la sezione sorpresa */
        .text-arrow-container-sorpresa {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: -40px; /* Riduce il margine per avvicinare gli elementi */
            margin-right: 25%; /* Sposta ulteriormente a destra */

        }

        .freccia img, .logo1 img {
            vertical-align: middle; /* Allinea verticalmente al centro */
        }
    </style>
</head>

<body>

<header>
    <nav>
        <ul>
            <li><h1><a href="SitoWeb.php">Home</a></h1></li>
            <li><h1><a href="Sorprese.php">Sorprese</a></h1></li>
            <li><h1><a href="https://wa.me/+393663456587">Contattaci</a></h1></li>
            <li class="dropdown">
                <h1><a href="javascript:void(0)">Autori</a></h1>
                <div class="dropdown-content"> 
                    <a class="dropdown-item" href="#">Caiazza Raffaele</a>
                    <a class="dropdown-item" href="#">Iavarone Domenico</a>
                    <a class="dropdown-item" href="#">Fabbri Gianluca</a>
                </div>
            </li>
        </ul>  
    </nav>
</header>

<section class="colore-bianco">
    <div id="content">
        <div style="position: absolute; top: 15%; left: 5%;">
            <img src="immagini/logo.png" height="80" width="230" alt="Logo">
        </div>
        <div style="position: absolute; top: 80px; left: 82%;">
            <img src="immagini/mysteryLogo2.png" height="130" width="210" alt="Mystery Logo 2">
        </div>
        <center>
            <div class="title-container">
                <span class="title-black">Mystery Box</span>
            </div>
        </center>
    </div>
</section>

<section class="colore-grigio">
    <div class="functions">
        <h2>Funzionamento</h2>
        <div class="scrittura">
            <p>La pagina web permetterà di acquistare fino a un numero massimo, dato dalla disponibilità del dispositivo erogatore, di Mystery Prizes. La transazione verrà aggiunta al database insieme al denaro incassato, aggiornando automaticamente il database. E’ possibile anche visualizzare il premio associato al colore di ogni pallina.</p>
        </div>
    </div>
</section>

<section class="colore-bianco">
    <div class="sorpresa">
        <h2>Sorprese</h2>
        <div class="content">
            <div class="scrittura2">
                <p>Clicca sulla box per immergerti nella straordinaria collezione di palline misteriose: scopri i premi nascosti e lasciati sorprendere dalla tua fortuna!</p>
            </div>
            <div class="text-arrow-container-sorpresa">
                <div class="freccia">
                    <img src="immagini/frecciadestraa.png" height="100" width="130" alt="Freccia Foto">
                </div>
                <div class="logo1">
                    <a href="Sorprese.php"><img src="immagini/logo1.png" height="200" width="270" alt="Logo 1"></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="colore-grigio">
    <div class="codice">
        <h2>Quick Response Code</h2>
        <div class="content">
            <div class="logo3" style="position: absolute; top: -27%; left: 10%;">
                <img src="immagini/logo3.png" height="300" width="450" alt="Logo 3">
            </div>
            <div class="text-arrow-container">
                <div class="frecciagif">
                    <img src="immagini/frecciasinistraa.png" height="100" width="130" alt="Freccia GIF">
                </div>
                <div class="scrittura3">
                    <p>Click, Discover, Enjoy Your Digital Ball Haven! Scannerizza il qr-code per scoprirne di più.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="colore-bianco">
    <div class="comprare">
        <h2>Clicca per Acquistare</h2>
        <div class="scrittura4">
            <p>Stai cercando un modo unico e divertente per sorprendere te stesso o qualcuno a cui tieni? Abbiamo qualcosa di speciale che renderà ogni momento emozionante: la nostra Pallina con Sorpresa Random!</p>
        </div>
        <button class="modifica_bottone_pagamento" type="submit" name="pagamento">
            <a href="pagamento.php">Acquista</a>
        </button>
    </div>
</section>

</body>
</html>
