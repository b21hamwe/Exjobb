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