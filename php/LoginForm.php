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
        <form id="loginForm" action="index.php" method="post">
        Användarnamn: <br><input type="text" name="username"><br>
        Lösenord: <br><input type="password" name="password"><br>
        <input type="submit" value="Logga in">
        <p><a href="Registration.php">Registrera</a></p>
        </form>';
    }
    /** om inloggad visa detta */
    else{
        $name = $_SESSION["username"];
        $id = $_SESSION["userid"];
        echo '<div id="loginForm">
        <p>Inloggad som:' .$name . '</p>
        <br>
        <p>UserID:' .$id . '</p>';
        if(isset($_SESSION["usertype"]) && $_SESSION["usertype"]==1){
            echo '<a href="Administrator.php">Admin panel</a>';
        }
        echo '
        </div>
        ';
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
        $prepState = $conn->prepare("SELECT UserID, UserName, UserType FROM users WHERE Username ='".$name."' AND password = '".$pass."' ");
        $prepState->execute();
        $fetchedData = $prepState->fetchAll();
        if (count($fetchedData) >= 1){
            $_SESSION["username"]=$fetchedData[0]["UserName"];
            $_SESSION["userid"]=$fetchedData[0]["UserID"];
            $_SESSION["usertype"]=$fetchedData[0]["UserType"];
        }
    }
    else{
        return;
    }
}