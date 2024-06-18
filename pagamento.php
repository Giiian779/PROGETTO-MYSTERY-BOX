<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$connection = new mysqli("localhost", "root", "", "mysterybox");

// Verifica la connessione
if ($connection->connect_error) {
    die("Connessione al database fallita: " . $connection->connect_error);
}

// Funzione per generare un ID unico basato sul timestamp
function generateUniqueID() {
    return time(); // Utilizza il timestamp Unix corrente come ID univoco
}


// Funzione per aggiornare lo stato delle macchine
function aggiornaStatoMacchina($Stato_macchine, $Quantita_disponibile) {
    global $connection;

    // Determina il nuovo stato della macchina
    $Stato_macchine = $Quantita_disponibile > 0 ? 'Operativo' : 'Non Operativo';

    // Aggiorna lo stato della macchina corrispondente
    $sql = "UPDATE macchine SET Stato_macchine = '$Stato_macchine'";
    if ($connection->query($sql) === TRUE) {
        echo "Stato della macchina aggiornato con successo";
    } else {
        echo "Errore durante l'aggiornamento dello stato della macchina: " . $connection->error;
    }
}


// Ottieni la data e l'ora attuali
$Data = date('Y-m-d'); // Formato: YYYY-MM-DD
$Ora = date('H:i:s'); // Formato: HH:MM:SS

// Verifica se è stata inviata una quantità
if (isset($_POST['quantita'])) {
    $Quantita_erogata = $_POST['quantita'];

    // Calcola il prezzo in base alla quantità erogata
    $Prezzo = $Quantita_erogata * 1 . " euro"; // Supponendo che il prezzo sia di 1 euro per unità

    // Verifica se è la prima transazione
    $sqlPrimaTransazione = "SELECT COUNT(*) as count FROM palline";
    $resultPrimaTransazione = $connection->query($sqlPrimaTransazione);
    $rowPrimaTransazione = $resultPrimaTransazione->fetch_assoc();
    $isPrimaTransazione = $rowPrimaTransazione['count'] == 0;

    if ($isPrimaTransazione) {
        // Se è la prima transazione, imposta la quantità disponibile a 6
        $Quantita_disponibile = 6;
    } else {
        // Recupera la quantità disponibile dal record precedente
        $sqlQuantitaPrecedente = "SELECT Quantità_disponibile FROM palline ORDER BY ID_transazione DESC LIMIT 1";
        $resultQuantitaPrecedente = $connection->query($sqlQuantitaPrecedente);
        if ($resultQuantitaPrecedente->num_rows > 0) {
            $rowQuantitaPrecedente = $resultQuantitaPrecedente->fetch_assoc();
            $Quantita_disponibile = $rowQuantitaPrecedente['Quantità_disponibile'];
        } else {
            // Gestisci il caso in cui non ci sono record precedenti (caso improbabile)
            $Quantita_disponibile = 6;
        }
    }

    // Verifica se c'è abbastanza disponibilità
    if ($Quantita_disponibile >= $Quantita_erogata) {
        // Aggiorna la quantità disponibile
        $Quantita_disponibile -= $Quantita_erogata;

        // Genera un ID unico per la transazione
        $ID_transazione = generateUniqueID();

        // Query di inserimento per la transazione
        $sqlErogazione = "INSERT INTO palline (ID_transazione, Prezzo, Quantità_disponibile, Data, Ora, Quantità_erogata) VALUES ('$ID_transazione', '$Prezzo', '$Quantita_disponibile', '$Data', '$Ora', '$Quantita_erogata')";
        $risultatoErogazione = $connection->query($sqlErogazione);

        // Controlla se l'inserimento è stato eseguito con successo
        if ($risultatoErogazione) {
            aggiornaStatoMacchina($Stato_macchine, $Quantita_disponibile);
            echo json_encode(array(
                'success' => true,
                'message' => 'Dati inseriti correttamente.',
                'erogata' => $Quantita_erogata, // Passa la quantità erogata come risposta
                'id' => $ID_transazione
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'Errore durante l\'inserimento dei dati dell\'erogazione: ' . $connection->error
            ));
        }
    } else {
        echo json_encode(array(
            'success' => false,
            'message' => 'Errore: Quantità insufficiente disponibile.'
        ));
    }
} else {
    // Se non c'è POST, ottieni l'ultima quantità erogata e ID
    $sqlAggiornamentoQuantita = "SELECT Quantità_erogata, ID_transazione FROM palline ORDER BY ID_transazione DESC LIMIT 1";
    $resultAggiornamentoQuantita = $connection->query($sqlAggiornamentoQuantita);

    if ($resultAggiornamentoQuantita->num_rows > 0) {
        $row = $resultAggiornamentoQuantita->fetch_assoc();
        $quantita_erogata = $row['Quantità_erogata'];
        $ID_transazione = $row['ID_transazione'];
        echo json_encode(array(   /è una funzione in PHP che converte un valore PHP in una rappresentazione JSON (JavaScript Object Notation)./
            'status' => 'success',
            'message' => 'Quantità erogata aggiornata',
            'erogata' => $quantita_erogata,
            'id' => $ID_transazione
        ));
    } else {
        echo json_encode(array(
            'status' => 'error',
            'message' => 'Nessuna quantità erogata trovata'
        ));
    }
}

// Verifica se sono stati inviati i dati tramite POST dall'ESP32
if (isset($_POST['quantita'])) {
    $Quantita_erogata = $_POST['quantita'];

    // Calcola il prezzo in base alla quantità erogata
    $Prezzo = $Quantita_erogata * 1 . " euro"; // Supponendo che il prezzo sia di 1 euro per unità

    // Verifica se è la prima transazione
    $sqlPrimaTransazione = "SELECT COUNT(*) as count FROM palline";
    $resultPrimaTransazione = $connection->query($sqlPrimaTransazione);
    $rowPrimaTransazione = $resultPrimaTransazione->fetch_assoc();
    $isPrimaTransazione = $rowPrimaTransazione['count'] == 0;

    if ($isPrimaTransazione) {
        // Se è la prima transazione, imposta la quantità disponibile a 6
        $Quantita_disponibile = 6;
    } else {
        // Recupera la quantità disponibile dal record precedente
        $sqlQuantitaPrecedente = "SELECT Quantità_disponibile FROM palline ORDER BY ID_transazione DESC LIMIT 1";
        $resultQuantitaPrecedente = $connection->query($sqlQuantitaPrecedente);
        if ($resultQuantitaPrecedente->num_rows > 0) {
            $rowQuantitaPrecedente = $resultQuantitaPrecedente->fetch_assoc();
            $Quantita_disponibile = $rowQuantitaPrecedente['Quantità_disponibile'];
        } else {
            // Gestisci il caso in cui non ci sono record precedenti (caso improbabile)
            $Quantita_disponibile = 6;
        }
    }

    // Verifica se c'è abbastanza disponibilità
    if ($Quantita_disponibile >= $Quantita_erogata) {
        // Aggiorna la quantità disponibile
        $Quantita_disponibile -= $Quantita_erogata;

        // Genera un ID unico per la transazione
        $ID_transazione = generateUniqueID();

        // Query di inserimento per la transazione
        $sqlErogazione = "INSERT INTO palline (ID_transazione, Prezzo, Quantità_disponibile, Data, Ora, Quantità_erogata) VALUES ('$ID_transazione', '$Prezzo', '$Quantita_disponibile', '$Data', '$Ora', '$Quantita_erogata')";
        $risultatoErogazione = $connection->query($sqlErogazione);

        // Controlla se l'inserimento è stato eseguito con successo
        if ($risultatoErogazione) {
            echo json_encode(array(
                'success' => true,
                'message' => 'Dati inseriti correttamente.',
                'erogata' => $Quantita_erogata,
                'id' => $ID_transazione
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'Errore durante l\'inserimento dei dati dell\'erogazione: ' . $connection->error
            ));
        }
    } else {
        echo json_encode(array(
            'success' => false,
            'message' => 'Errore: Quantità insufficiente disponibile.'
        ));
    }
}

// Chiudi la connessione al database
$connection->close();
?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento</title>
    <link rel="stylesheet" type="text/css" href="css/Style.css">
    <style>
        header h1 {
            font-size: 2em;
            color: none;
            font-weight: bold;
            margin: 0;
        }
        .info-bar {
            background-color: #757575;
            color: black;
            font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            text-align: center;
            padding: 0px 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
        } 
        .info-bar h1 {
            font-size: 2em;
            margin: 0;
        }
        .content { /contenuto nella pagina/
            padding-top: 60px; /* Spazio per la barra */
            text-align: center;
        }
        .counter-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }
        .counter-button, .purchase-button {
            font-size: 1.5em;
            padding: 10px 20px;
            margin: 5px;
        }
        .counter-display {
            font-size: 2em;
            margin: 0 20px;
        }
        .purchase-button {
            display: block;
            margin: 20px auto;
        }
        .modifica_bottone a {
            text-decoration: none;
            color: black;
        }
        .modifica_bottone {
            width: 200px;
            background: none;
            border: none;
            font-size: 0.8em;
            cursor: pointer;
        }
        /* Nuovo stile */
        .reviews, .product-details, footer {
            padding: 30px;
            text-align: center;
        }
        .review-item, .product-detail-item {
            margin: 10px 0;
        }
        .footer-links, .social-media, .newsletter {
            margin: 10px 0;
        }
        h2 {
            text-align: center;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <div class="info-bar">
        <h1>DIGITA IL NUMERO DI PALLINE E ACQUISTA!</h1>
    </div>
    <div class="bottone-wrapper">
        <button class="modifica_bottone" type="submit" name="home"><a href="SitoWeb.php"><h1>Torna alla Home</h1></a></button>
    </div>
    <section class="colore-bianco">
        <div class="content">
            <div style="position: absolute; top: 25%; left: 75%;">
                <img src="immagini/Pagamento.png" height="90" width="160" alt="pagamento"> 
            </div>
            <div style="position: absolute; top: 23%; left: 15%;">
                <img src="immagini/BestSeller.png" height="110" width="170" alt="seller"> 
            </div>

            <div class="counter-container">
                <button id="decrement-button" class="counter-button">-</button>
                <div id="counter-display" class="counter-display">1</div>
                <button id="increment-button" class="counter-button">+</button>
            </div>

            <div id="sold-out-message" style="display: none;"><h1>Prodotto esaurito!</h1></div>

            <button id="purchase-button" class="purchase-button">Acquista</button>
        </div>
    </section>
    <section class="colore-grigio">
        <!-- Sezione Recensioni dei Clienti -->
        <div class="reviews">
            <h2>Recensioni dei Clienti</h2>
            <div class="review-item">
                <p>"Sito ben gestito! Sono molto soddisfatto." - Marco</p>
            </div>
            <div class="review-item">
                <p>"Qualità eccellente e consegna rapida." - Laura</p>
            </div>
            <div class="review-item">
                <p>"Ottimo prodotto!" - Antonia</p>
            </div>
            <div class="review-item">
                <p>"Pagamento facile e veloce." - Salvatore</p>
            </div>
            <div class="review-item">
                <p>"Molto divertente!" - Nunzia</p>
            </div>
            <div class="review-item">
                <p>"Ormai faccio la collezione da diversi anni. Consigliato!" - Giovanni</p>
            </div>
        </div>
    </section>
    <section class="colore-bianco">
        <!-- Sezione Dettagli del Prodotto -->
        <div class="product-details">
            <h2>Dettagli del Prodotto</h2>
            <div class="product-detail-item">
                <p><strong>Nome del prodotto:</strong> Mystery Prizes</p>
            </div>
            <div class="product-detail-item">
                <p><strong>Materiale:</strong> Plastica</p>
            </div>
            <div class="product-detail-item">
                <p><strong>Dimensioni:</strong> 40mm</p>
            </div>
            <div class="product-detail-item">
                <p><strong>Colori disponibili:</strong> Nero, Arancione, Rosso, Blu, Verde, Giallo</p>
            </div>
            <div class="product-detail-item">
                <p><strong>Caratteristiche speciali:</strong> Resistente, non tossico, facile da montare</p>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <section class="colore-grigio">
        <footer>
            <div class="footer-links">
                <h2>Altre informazioni</h2>
                <a href="#">Informazioni</a> | 
                <a href="#">Politiche di reso</a> | 
                <a href="#">Contatti</a>
            </div>
            <div class="social-media">
                <p>Seguici su:</p>
                <a href="#">Facebook</a> | 
                <a href="#">Instagram</a> | 
                <a href="#">Twitter</a>
            </div>
            <div class="newsletter">
                <form>
                    <label for="email">Iscriviti alla newsletter:</label>
                    <input type="email" id="email" name="email" placeholder="Inserisci la tua email">
                    <button>Iscriviti</button>
                </form>
            </div>
        </footer>
    </section>
    <script src="js/script.js"></script>
</body>
</html>
