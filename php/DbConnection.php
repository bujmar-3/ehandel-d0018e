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
$databasename = "ehandel_db";

/** Tar gobala variabler definerade i början av denna fil och skapar en uppkoppling*/
function connectDb(){
    global $servername;
    global $databasename;
    global $username;
    global $password;
    try{
        $conn = new PDO("mysql:host=$servername;dbname=$databasename;", $username, $password);
        /** Sätter PDOs error mode till exception */
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
    /** Fångar exception och skriver ut error medelande */
    catch (PDOException $e){
        echo "Could not establish connection: " . $e->getMessage();
    }

}
/** Returnerar variabel $fechedData som inehåller namn, pris och antal från tabellen product från databasen */
function getProducts(){
    $conn = connectDb();
    $prepState = $conn->prepare("SELECT Name, Price, Amount FROM product");
    $prepState->execute();
    $fetchedData = $prepState->fetchAll();
    return $fetchedData;
    /**foreach ($fetchedData as $row){
        echo $row['Name'] . "<br />";
        echo $row['Price'] . "<br />";
        echo $row['Amount'] . "<br />";
        echo "Här över ska data komma";*/
    }
