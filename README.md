# Exjobb


Detta förvar innehåller samtliga artefakter exklusive databaserna för studien, Prestandajämförelse mellan NOSQL och SQL vid sökningsoperationer på bokhandels hemsidor. 

enkelMongoServer.PHP - Är den webbserver som använder den enkla queryn mot databasen MongoDB för att ge vidare information till klienten (klient.HTML). 

mongodbWebbserver.PHP - Är den webbserver som använder den medel komplicerade queryn mot databasen MongoDB för att ge vidare information till klienten (klient.HTML). 

sqlWebbServer.PHP - Är den webbserver som används för att utföra samtliga querys mot MySQL databasen för att senare ge vidare information till klienten (klient.HTML).

Klient.HTML - Är den klientsida som används för att söka på data mot databasen genom en av de webbservrar. 

generateData.JS - Är det skripts som använts för att generera fiktiv data till MySQL databasen. 

inserJsonMongo.PHP - Är det skript som används för att hämta samtlig data från MySQL databasen för att sedan spara ned datan i JSON format som sedan kan användas för att importera datan till MongoDB. 

package.JSON - är det JS paket som generarats för att använda Node.JS vid användning av "generateData.JS" filen vid uppladdning av data till MySQL databasen. 
