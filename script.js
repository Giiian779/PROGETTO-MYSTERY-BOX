// Attende che il documento HTML sia completamente caricato prima di eseguire il codice
document.addEventListener('DOMContentLoaded', () => {
    // Inizializza il contatore a 1
    let count = 1;
    // Imposta la quantità massima disponibile
    let maxQuantity = 6;

    // Selezione degli elementi dal DOM
    const counterDisplay = document.getElementById('counter-display');
    const incrementButton = document.getElementById('increment-button');
    const decrementButton = document.getElementById('decrement-button');
    const purchaseButton = document.getElementById('purchase-button');
    const soldOutMessage = document.getElementById('sold-out-message');

    // Funzione per aggiornare il display del contatore
    const updateCounterDisplay = () => {
        counterDisplay.textContent = count;
    };

    // Funzione per controllare se il prodotto è esaurito
    const checkSoldOut = () => {
        if (maxQuantity === 0) {
            // Nasconde il pulsante di acquisto e mostra il messaggio di esaurimento
            purchaseButton.style.display = 'none';
            soldOutMessage.style.display = 'block';
            console.log("Quantità esaurita. Visualizzazione del messaggio di esaurimento.");
        } else {
            soldOutMessage.style.display = 'none';
        }
    };

    // Aggiunge un event listener per l'incremento del contatore
    incrementButton.addEventListener('click', () => {
        if (count < maxQuantity) {
            count++;
        } else {
            count = 1; // Reimposta il contatore a 1 quando raggiunge il massimo
        }
        updateCounterDisplay(); // Aggiorna il display del contatore
    });

    // Aggiunge un event listener per il decremento del contatore
    decrementButton.addEventListener('click', () => {
        if (count > 1 && maxQuantity > 0) {
            count--;
        }
        updateCounterDisplay(); // Aggiorna il display del contatore
    });

    // Aggiunge un event listener per il pulsante di acquisto
    purchaseButton.addEventListener('click', () => {
        // Verifica se il browser supporta la geolocalizzazione
        if (navigator.geolocation) {
            // Ottiene la posizione corrente dell'utente
            navigator.geolocation.getCurrentPosition(function(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                // Usa ip-api.com per ottenere il nome della città
                const url = http://ip-api.com/json/?fields=city;

                // Esegue una richiesta fetch per ottenere il nome della città
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const city = data.city;

                        // Invia una richiesta POST al server per eseguire l'acquisto
                        const xhr = new XMLHttpRequest();
                        xhr.open("POST", "pagamento.php", true);
                        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                // Gestisce la risposta dal server dopo l'acquisto
                                if(xhr.responseText === "Quantità non specificata.") {
                                    alert("Errore: Quantità non specificata.");
                                } else if (xhr.responseText === "Impossibile erogare") {
                                    alert("Impossibile erogare. Quantità massima disponibile: 6.");
                                } else {
                                    alert(Hai acquistato ${count} elementi!);
                                    // Aggiorna la quantità disponibile sulla pagina
                                    maxQuantity -= count;
                                    count = 1; // Reimposta il contatore a 1 dopo l'acquisto
                                    updateCounterDisplay();
                                    checkSoldOut(); // Verifica se il messaggio di esaurimento deve essere mostrato
                                }
                            }
                        };
                        xhr.send(quantita=${count}&city=${city}); // Invia i dati al server
                    })
                    .catch(error => {
                        alert("Errore nel recupero del nome della città: " + error.message);
                    });
            }, function(error) {
                alert("Errore nel recupero della posizione: " + error.message);
            });
        } else {
            alert("Geolocalizzazione non supportata dal browser.");
        }
    });

    // Imposta il contatore iniziale e verifica se il prodotto è esaurito
    updateCounterDisplay();
    checkSoldOut();
});
