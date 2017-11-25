<?php
/**
 * Created by PhpStorm.
 * User: MarZ
 * Date: 2017-11-25
 * Time: 16:31
 */
function getAdminPanel(){
    echo'
    <form id="adminFrom" action="Administrator.php" method="post">
    <select name="adminOption">
        <option value="user">Användare</option>
        <option value="addproduct">Lägg till produkt</option>
        <option value="removeproduct">Ta bort produkt</option>
        <option value="changeproduct">Redigera produkt</option>
    </select>
    <input type="submit" value="Välj">
    </form>
    ';
    checkAdminPost();
}

/**Kollar vilken alternativ som valts i admin panelen */
function checkAdminPost(){
    if(isset($_POST["adminOption"])==false){
        return;
    }
    else{
        if($_POST["adminOption"] == "user"){
            editUser();
        }
        if($_POST["adminOption"] == "addproduct"){
            echo 'valde addproduct';
        }
        if($_POST["adminOption"] == "removeproduct"){
            echo 'valde removeproduct';
        }
        if($_POST["adminOption"] == "changeproduct"){
            echo 'valde changeproduct';
        }
    }
}

function editUser(){
    echo'
    <form id="editUser" action="Administrator.php" method="post">
        <input type="hidden" name="adminOption" value="user">
        Användarnamn:<input type="text" name="editUserName">
        <input type="submit" value="Hämta data"><br>';
        if(isset($_POST["editUserName"])){
            getUserData();
        }
    echo'
    </form>
    ';
}

function getUserData(){
    $conn = connectDb();
    $prepState = $conn->prepare("SELECT * FROM users WHERE Username ='".$_POST["editUserName"]."'");
    $prepState->execute();
    $fetchedData = $prepState->fetchAll();
    if(count($fetchedData) == 0){
        echo 'Kunde inte hitta användare';
    }else{
        $Fname = $fetchedData[0]["Fname"];
        $Lname = $fetchedData[0]["Lname"];
        $Address = $fetchedData[0]["Adress"];
        $ZipCode = $fetchedData[0]["Zipcode"];
        $UserType = $fetchedData[0]["UserType"];
        echo'
        Fname:<input type="text" name="editUserFname" value="' .$Fname . '"><br>
        Lname:<input type="text" name="editUserLname" value="' .$Lname . '"><br>
        Address:<input type="text" name="editUserAddress" value="' .$Address . '"><br>
        ZipCode:<input type="text" name="editUserZipcode" value="' .$ZipCode . '"><br>
        UserType:<input type="text" name="editUserUserType" value="' .$UserType . '"><br>
            ';
    }
}
?>