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
        <label for="1">Användarnamn:</label><br><input type="text" name="username" id="1"><br>
        <label for="2">Lösenord:</label><br><input type="password" name="password" id="2"><br>
        <input type="submit" value="Logga in" class="loginFormButton">
        <a href="Registration.php">Registrera</a>
        </form>';
    }
    /** om inloggad visa detta */
    else{
        $name = $_SESSION["username"];
        $id = $_SESSION["userid"];
        echo '
        <form id="loginForm" action="index.php" method="post">
        <p>Inloggad som:' .$name . '</p>
        <br>
        <p>UserID:' .$id . '</p>';
        if(isset($_SESSION["usertype"]) && $_SESSION["usertype"]==1){
            echo '<a href="Administrator.php" class="loginFormButton">Admin panel</a>';
        }
        echo '
        <input type="hidden" name="logout" value="true">
        <input type="submit" class="loginFormButton" value="Logga ut">
        </form>
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
    if(isset($_POST["logout"])){
        logout();
    }
    else{
        return;
    }
}

/**Loggar ut användare och stänger session*/
function logout(){
    $_SESSION = array();
    session_destroy();
}