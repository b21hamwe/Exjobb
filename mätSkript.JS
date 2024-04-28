// ==UserScript==
// @name         Exjobb2
// @namespace    http://tampermonkey.net/
// @version      0.1
// @description  Reads in a JSON file containing an array of authors and performs searches using seeded data
// @require      http://localhost/exjobb/författare.json
// @require      https://cdnjs.cloudflare.com/ajax/libs/seedrandom/3.0.5/seedrandom.min.js
// @author       Me
// @match        http://localhost/exjobb/client.html
// @require      https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js
// @grant        none
// ==/UserScript==

(function() {
    'use strict';

    // Deklarerar variabler 
    var resultArr = [];
    var startTime, stopTime, time;
    var seed_value = 1
    let authors = []; // Array att spara författare från JSON filen 

    // Läser JSON filen
   $.getJSON("författare.json", function(data) {
    console.log(data); // Logar datan
    if (!data || data.length === 0) {
        console.error('No data found in the JSON file.');
        return;
    }
    // Extraherar namnen från JSON filen
    authors = data.map(item => item.namn);
    console.log(authors); // Loggar namnen från filen 
    startSearching(); // Startar funktionen när filen är inläst
});

    // Initerar seeden
    Math.seedrandom(seed_value);

    function startSearching() {
        setTimeout(async function () {
            try {
                // For loop som genererar 5 filer
                for (let j = 0; j < 5; j++) {
                    // For loop som söker igenom JSON filen
                    for (var i = 0; i < authors.length; i++) {
                        // Hämtar författare från array baserad på seed
                        let index = Math.floor(Math.random() * authors.length);
                        let author = authors[index];

                        // Startar tiden
                        startTime = performance.now();
                        console.log("Timer starts");

                        // Lägger in namn i sökfält
                        $('#searchInput').val(author);

                        // Kör funktionen som trycker sök knapp
                        await triggerSearch();

                        // Stanna och räkna ut tiden
                        stopTime = performance.now();
                        time = stopTime - startTime;

                        // Spara resultat
                        var sample = { name: author, time: time };
                        resultArr.push(sample);

                        console.log(resultArr);
                    }

                    // Spara resultat till en JSON fil
                    saveResults();
                    resultArr = [];
                }
            } catch (error) {
                console.error('An error occurred:', error);
            }
        }, 1000);
    }

    // Funktion som triggar sök knappen i klienten 
    function triggerSearch() {
        return new Promise((resolve, reject) => {
            $('#searchBtn').click(); // Click som trycker på knappen åt oss
            // En kortare timeout för att sökningen inte ska bli avbruten 
            setTimeout(() => {
                resolve();
            }, 500);
        });
    }

    // Funktion som sparar resultaten till en JSON fil 
    function saveResults() {
        const JSONresult = JSON.stringify(resultArr, null, "\t");
        const blob = new Blob([JSONresult], { type: "application/json" });
        const linkdownload = document.createElement('a');
        linkdownload.href = URL.createObjectURL(blob);
        linkdownload.download = 'EnkelMongoDB.json';
        linkdownload.textContent = 'Result from search script';
        document.body.appendChild(linkdownload);
        linkdownload.click();
        document.body.removeChild(linkdownload);
    }

})();