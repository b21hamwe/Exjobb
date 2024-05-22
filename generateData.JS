const faker = require('@faker-js/faker').faker;
var fs = require('graceful-fs');

// Seed för samtlig data generering
faker.seed(9876);

let bookID = 1;
let bAuthID = 1;
let authID = 1;
let serieId = 1;

function writeLine(filename, line) {
    var logger = fs.createWriteStream(`output2/${filename}`, {
        flags: 'a' 
    });

    logger.write(`\n${line}`);
    logger.close();
}

function generateAuthor(statementAmount) {
    var sql = `INSERT INTO författare (id, namn) VALUES `;
    for (let x = 0; x < statementAmount; x++) {
        let autherName = faker.person.firstName() + " " + faker.person.lastName();
        autherName = autherName.replaceAll("'", "");

        // Spara författare till författar table i MYSQL
        sql = sql + `('${authID}','${autherName}')`;
        if (x !== statementAmount - 1) {
            sql = sql + `, `;
        }

        authID++;
    }
    sql = sql + `;`;
    writeLine('MillonAuthors.sql', sql);
}

function generateBooksWithCollection() {
    const serietitel = faker.lorem.words({ min: 1, max: 5 });

    // Sätt in data till bokserie tabellen
    var sql = `INSERT INTO bokserie (id, serietitel) VALUES ('${serieId}', '${serietitel}');`;
    writeLine('collections.sql', sql);

    const maxBooks = faker.number.int({ min: 10, max: 20 });
    sql = `INSERT INTO bok (id, boktitel, omslag, författarId, bokserieId) VALUES `;
    for (let i = 0; i < maxBooks; i++) {
        const boktitel = faker.lorem.sentence({ min: 2, max: 5 });
        const omslag = faker.datatype.boolean() ? 'Pocket' : 'Hardcover';

        // Sätt in data till bok tabellen
        sql = sql + `('${bookID}','${boktitel}', '${omslag}', '${bAuthID}', '${serieId}')`;
        if (i !== maxBooks - 1) {
            sql = sql + ', ';
        }

        bAuthID++;
        bookID++;
    }
    sql = sql + `;`;
    writeLine('MillionBooks.sql', sql);
    serieId++;
}

function init() {
    // Loop som generar författar namn
    for (let x = 0; x < 500; x++) {
        generateAuthor(1000);
    }

    for (let y = 0; y < 33334; y++) {
        generateBooksWithCollection();
    }
}

init();
