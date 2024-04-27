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

for (let x = 0; x < 500; x++) {

    let autherName = faker.person.firstName() + " " + faker.person.lastName();
    autherName = autherName.replaceAll("'", "")

    // Spara författare till författar table i MYSQL
    var sql = `INSERT INTO författare (id, namn) VALUES ('${authID}','${autherName}')`;
    mysqlCon.query(sql, function (err, result) {
        if (err) throw err;
    });
    authID++;
}