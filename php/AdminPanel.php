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
        Användarnamn:<input type="text" name="editUserName"><br>';
        if(isset($_POST["editUserName"])){
            getUserData();
        }
    echo'
        <input type="submit" value="Välj">
    </form>
    ';
}

function getUserData(){
    $conn = connectDb();
    $prepState = $conn->prepare("SELECT * FROM users WHERE Username ='".$_POST["editUserName"]."'");
    $prepState->execute();
    $fetchedData = $prepState->fetchAll();
    $Fname = $fetchedData[0]["Fname"];
    $Lname = $fetchedData[0]["Fname"];
    $Address = $fetchedData[0]["Fname"];
    $ZipCode = $fetchedData[0]["Fname"];
    $UserType = $fetchedData[0]["Fname"];
    echo'
    Fname:<input type="text" name="editUserFname" value="' .$Fname . '"><br>;
    Lname:<input type="text" name="editUserLname" value="' .$Lname . '"><br>;
    Address:<input type="text" name="editUserAddress" value="' .$Address . '"><br>;
    ZipCode:<input type="text" name="editUserZipcode" value="' .$ZipCode . '"><br>;
    UserType:<input type="text" name="editUserUserType" value="' .$UserType . '"><br>;
    ';
}
?>