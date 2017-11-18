<?php
/**
 * Created by PhpStorm.
 * User: MarZ
 * Date: 2017-11-18
 * Time: 15:57
 */

/** getLoginForm skapar ett login fomrulär, bundet till index.php vid submit*/
function getLoginForm(){
    setSessionLoggin();
    /** Om ej inloggad visa formulär*/
    if(checkLoggedIn()==false){
        echo '
        <form action="index.php" method="post">
        Användarnamn: <input type="text" name="username"><br>
        Lösenord: <input type="password" name="password"><br>
        <input type="submit" name="Logga in">
        </form>';
    }
    else{
        $name = $_SESSION["username"];
        echo 'inloggad som ' . $name;
    }
}
/** Kollar om sessionen inehåller användardata, retunerar true eller false*/
function checkLoggedIn(){
    if(isset($_SESSION["username"])&&isset($_SESSION["password"])){
        return true;
    }
    else{
        return false;
    }
}
/** Om person klickat på logga in*/
function setSessionLoggin(){
    if(isset($_POST["username"]) && isset($_POST["password"])){
        $name = $_POST["username"];
        $pass = $_POST["password"];
        $conn = connectDb();
        $prepState = $conn->prepare("SELECT UserID, UserName, Password FROM users WHERE Username ='".$name."' AND password = '".$pass."' ");
        $prepState->execute();
        $fetchedData = $prepState->fetchAll();
        if (count($fetchedData) >= 1){
            $_SESSION["username"]=$_POST["username"];
            $_SESSION["password"]=$_POST["password"];
        }
    }
    else{
        return;
    }
}