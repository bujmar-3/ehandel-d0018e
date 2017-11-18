<?php
/**
 * Created by PhpStorm.
 * User: MarZ
 * Date: 2017-11-18
 * Time: 15:57
 */

/** getLoginForm skapar ett login fomrulär, bundet till index.php vid submit*/
function getLoginForm(){
    /** Om ej inloggad visa formulär*/
    if(CheckLoggedIn()==false){
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

function CheckLoggedIn(){
    if(isset($_SESSION["username"])&&isset($_SESSION["password"])){
        return true;
    }
    else{
        return false;
    }
}

function setSessionLoggin(){
    if(isset($_POST["username"]) && isset($_POST["password"])){
        $_SESSION["username"]=$_POST["username"];
        $_SESSION["password"]=$_POST["password"];
    }
    else{
        return;
    }
}