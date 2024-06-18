<!DOCTYPE html> <!-- Dichiarazione del tipo di documento -->
<html lang="it"> <!-- Lingua italiana per il documento -->
<head>
    <meta charset="UTF-8"> <!-- Codifica dei caratteri UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Impostazioni viewport per dispositivi mobili -->
    <title>Sorprese</title> <!-- Titolo della pagina visualizzato nella barra del browser -->
    <link rel="stylesheet" type="text/css" href="css/Style.css"> <!-- Collegamento al foglio di stile CSS esterno -->

    <style>
        /* Stili CSS interni per questa pagina */

        /* Stili specifici per il titolo nel header */
        header h1 {
            font-size: 2em; /* Dimensione del carattere 2em (circa 24pt) */
            color: none; /* Attenzione: 'none' non è un valore valido per il colore. Potrebbe essere un errore. */
            font-weight: bold; /* Grassetto */
            margin: 0; /* Azzeramento margini */
        }

        /* Stili specifici per i bottoni */
        .modifica_bottone, .modifica_bottone_pagamento {
            width: 200px; /* Larghezza del bottone */
            display: inline-block; /* Mostra come blocco inline */
            text-decoration: none; /* Rimuove il sottolineato dai link */
            padding: 0; /* Azzeramento del padding */
            font-size: 0.8em; /* Dimensione del carattere 0.8em (circa 10pt) */
            cursor: pointer; /* Cambia il cursore al passaggio del mouse */
            background: none; /* Nessun sfondo */
            border: none; /* Nessun bordo */
        }

        .modifica_bottone a, .modifica_bottone_pagamento a {
            color: black; /* Colore del testo nero */
            text-decoration: none; /* Rimuove il sottolineato dai link */
            display: block; /* Mostra come blocco */
            height: 100%; /* Altezza del 100% rispetto al contenitore genitore */
            width: 100%; /* Larghezza del 100% rispetto al contenitore genitore */
            text-align: center; /* Allinea il testo al centro */
            line-height: 100%; /* Altezza della riga del 100% */
            vertical-align: middle; /* Allinea verticalmente al centro */
            position: absolute; /* Posizionamento assoluto */
            top: 50%; /* Posizionamento al 50% rispetto al contenitore genitore */
            left: 0%; /* Posizionamento a sinistra del 0% rispetto al contenitore genitore */
            transform: translate(-50%,-50%); /* Traslazione per centrare il bottone */
        }
    </style>
</head>
<body>
    <header>
        <h1>SCOPRI TUTTE LE SORPRESE</h1> <!-- Intestazione principale della pagina -->
        
        <!-- Wrapper per il primo bottone -->
        <div class="bottone-wrapper-a">
            <!-- Bottone per tornare alla Home -->
            <button class="modifica_bottone" type="submit" name="home"><a href="SitoWeb.php"><h1>Torna alla Home</h1></a></button>
        </div>
        
        <!-- Wrapper per il secondo bottone -->
        <div class="bottone-wrapper-b">
            <!-- Bottone per acquistare -->
            <button class="modifica_bottone_pagamento" type="submit" name="compra"><a href="pagamento.php"><h1>Acquista</h1></a></button>
        </div>
    </header>

   <!-- Prima sezione -->
<section class="colore-bianco"> <!-- Sezione con sfondo bianco -->
    <div class="pallina-container"> <!-- Contenitore della pallina -->
        <img src="immagini/pallinaNera.png" height="180" width="225" alt="pallina nera"> <!-- Immagine della pallina nera -->
        <div class="descrizione-pallina">Modellini di auto sportive: Riproduzioni in scala di famose auto sportive o di lusso, come una Ferrari o una Lamborghini, in colorazione nera lucida.</div> <!-- Descrizione della pallina nera -->
    </div>
</section>

<!-- Seconda sezione -->
<section class="colore-grigio"> <!-- Sezione con sfondo grigio -->
    <div class="pallina-container"> <!-- Contenitore della pallina -->
        <img src="immagini/pallinaBlu.png" height="180" width="228" alt="pallina blu"> <!-- Immagine della pallina blu -->
        <div class="descrizione-pallina">Riproduzioni di elementi marini, come conchiglie, stelle marine o piccoli pesci tropicali.</div> <!-- Descrizione della pallina blu -->
    </div>
</section>

<!-- Terza sezione -->
<section class="colore-bianco"> <!-- Sezione con sfondo bianco -->
    <div class="pallina-container"> <!-- Contenitore della pallina -->
        <img src="immagini/pallinaBianca.png" height="180" width="225" alt="pallina bianca"> <!-- Immagine della pallina bianca -->
        <div class="descrizione-pallina">Figure di animali polari come orsi bianchi o pinguini, o oggetti che richiamano la pace e la tranquillità, come piccole statuette di angeli.</div> <!-- Descrizione della pallina bianca -->
    </div>
</section>

<!-- Quarta sezione -->
<section class="colore-grigio"> <!-- Sezione con sfondo grigio -->
    <div class="pallina-container"> <!-- Contenitore della pallina -->
        <img src="immagini/pallinaArancio.png" height="180" width="225" alt="pallina arancio"> <!-- Immagine della pallina arancio -->
        <div class="descrizione-pallina">Miniature di frutti e verdure arancioni, come arance, carote o zucche, o piccoli oggetti che rappresentano l’autunno.</div> <!-- Descrizione della pallina arancio -->
    </div>
</section>

<!-- Quinta sezione -->
<section class="colore-bianco"> <!-- Sezione con sfondo bianco -->
    <div class="pallina-container"> <!-- Contenitore della pallina -->
        <img src="immagini/pallinaVerde.png" height="180" width="225" alt="pallina verde"> <!-- Immagine della pallina verde -->
        <div class="descrizione-pallina">Piccole piante o alberi in miniatura, o figure di creature della foresta come folletti o fate.</div> <!-- Descrizione della pallina verde -->
    </div>
</section>

<!-- Sesta sezione -->
<section class="colore-grigio"> <!-- Sezione con sfondo grigio -->
    <div class="pallina-container"> <!-- Contenitore della pallina -->
        <img src="immagini/pallinaGialla.png" height="180" width="225" alt="pallina gialla"> <!-- Immagine della pallina gialla -->
        <div class="descrizione-pallina">Oggetti che simboleggiano la felicità e l’energia, come il sole, girasoli o piccole lampadine.</div> <!-- Descrizione della pallina gialla -->
    </div>
</section>

</body>
</html>
