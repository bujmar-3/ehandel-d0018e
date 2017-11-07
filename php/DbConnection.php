<?php
/**
 * Created by PhpStorm.
 * User: MarZ
 * Date: 2017-11-07
 * Time: 21:42
 */

/** Denna fil inehåller funktioner för att koppla upp sig och arbeta mot den specefika databasen */
$servername = "localhost";
$username = "ehandelUser";
$password = "mubbhandel";
$port = "3306";
$databasename = "ehandeldb";

function connectDb(){
    global $servername;
    global $databasename;
    global $username;
    global $password;
    try{
        $conn = new PDO("mysql:host=$servername;dbname=$databasename;", $username, $password);
        /** Sätter PDOs error mode till exception */
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "db uppkoppling lyckades"; /** check code*/
    }
    /** Fångar exception och skriver ut error medelande */
    catch (PDOException $e){
        echo "Could not establish connection: " . $e->getMessage();
    }

}
