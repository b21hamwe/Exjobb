const faker = require('@faker-js/faker').faker;
const mysql = require('mysql');


//Seed för samtlig data generering
faker.seed(9876);

//Connecta till Databasen
let mysqlCon = mysql.createConnection({
    host: "localhost",
    user: "root", 
    password: "", 
    database: "exjobb"
})
mysqlCon.connect();


let bookID = 1;
let authID = 1; 
let serieId = 1;

// Loop som generar författar namn
for (let x = 0; x < 500; x++) {

    let autherName = faker.person.firstName() + " " + faker.person.lastName();
    autherName = autherName.replaceAll("'", "")

    // Spara författare till författar table i MYSQL
    var sql = `INSERT INTO författare (id, namn) VALUES ('${authID}','${autherName}')`;
    mysqlCon.query(sql, function (err, result) {
        if (err) throw err;
    });
    //Öka id räknare till författare
    authID++;
}


//For loop som generar data till bok och bokserie tabell
for (let x = 0; x < 500; x++) {

    const serietitel = faker.lorem.words({ min: 1, max: 5 });

     // Sätt in data till bokserie tabellen

    var sql = `INSERT INTO bokserie (id, serietitel) VALUES ('${serieId}', '${serietitel}')`;
    mysqlCon.query(sql, function (err, result) {
        if (err) throw err;
    });

    const maxBooks = faker.number.int({min: 2, max: 4});
    for (let i = 0; i < maxBooks; i++) {

        const boktitel = faker.lorem.sentence({ min: 3, max:5 })
        const omslag = faker.datatype.boolean() ? 'Pocket' : 'Hardcover';
        const inledningsText = faker.lorem.text();
        const authorId = faker.number.int({min: 0, max: 100 - 1});
        
        // Sätt in data till bok tabellen

            var sql = `INSERT INTO bok (id, boktitel, författarID, omslag, inledningstext, bokserieID) VALUES ('${bookID}','${boktitel}', '${authorId}', '${omslag}', '${inledningsText}', '${serieId}')`;

            mysqlCon.query(sql, function (err, result) {
                if (err) throw err;
            });

        bookID++;

    }
    serieId++;
    console.log(x);
}