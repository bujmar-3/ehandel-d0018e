<?php
/**
 * Created by PhpStorm.
 * User: MarZ
 * Date: 2017-11-18
 * Time: 15:57
 */

/** getLoginForm skapar ett login fomrulär, bundet till index.php vid submit*/
function getLoginForm(){
    checkLoginPost();
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
        $id = $_SESSION["userid"];
        echo 'inloggad som ' . $name . ' UserID ' . $id;
    }
}
/** Kollar om sessionen inehåller användardata, retunerar true eller false*/
function checkLoggedIn(){
    if(isset($_SESSION["username"])&&isset($_SESSION["userid"])){
        return true;
    }
    else{
        return false;
    }
}
/** Om person klickat på logga in*/
function checkLoginPost(){
    if(isset($_POST["username"]) && isset($_POST["password"])){
        $name = $_POST["username"];
        $pass = $_POST["password"];
        $conn = connectDb();
        $prepState = $conn->prepare("SELECT UserID, UserName FROM users WHERE Username ='".$name."' AND password = '".$pass."' ");
        $prepState->execute();
        $fetchedData = $prepState->fetchAll();
        if (count($fetchedData) >= 1){
            $_SESSION["username"]=$fetchedData[0]["UserName"];
            $_SESSION["userid"]=$fetchedData[0]["UserID"];
        }
    }
    else{
        return;
    }
}