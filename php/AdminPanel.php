<?php
/**
 * Created by PhpStorm.
 * User: MarZ
 * Date: 2017-11-25
 * Time: 16:31
 */

/**Skapar admin panel och visar för användaren*/
function getAdminPanel(){
    if(checkLoggedIn() && $_SESSION["usertype"]==1) {
        echo '
        <form id="adminFrom" action="Administrator.php" method="post">
        <select name="adminOption">
            <option value="user">Användare</option>
            <option value="addproduct">Lägg till produkt</option>
            <option value="removeproduct">Ta bort produkt</option>
            <option value="editproduct">Redigera produkt</option>
        </select>
        <input type="submit" value="Välj">
        </form>
        ';
        checkAdminPost();
    }
    else{
        echo '<p>Du har inte rättighet att se denna sida.</p>';
    }
}

/**Kollar vilken alternativ som valts i admin panelen */
function checkAdminPost(){
    if(isset($_POST["adminOption"])==false){
        return;
    }
    else{
        if($_POST["adminOption"] == "user"){
            if(isset($_POST["adminChoise"])){
                saveUserData();
            }
            else{
                editUser();
            }
        }
        if($_POST["adminOption"] == "addproduct"){
            if(isset($_POST["adminChoise"])){
                saveAddProduct();
            }
            else {
                addProduct();
            }
        }
        if($_POST["adminOption"] == "removeproduct"){
            if(isset($_POST["adminChoise"])){
                saveRemoveProduct();
            }
            else{
                removeProduct();
            }
        }
        if($_POST["adminOption"] == "editproduct"){
            if(isset($_POST["adminChoise"])){
                saveProductData();
            }
            else{
                editProduct();
            }
        }
    }
}

/**Funktioner för att editera en användare i databasen*/
function editUser(){
    echo'
    <form id="editUser" action="Administrator.php" method="post">
        <input type="hidden" name="adminOption" value="user">
        Användarnamn:<input type="text" name="editUserName" required>
        <input type="submit" value="Hämta data"><br>
    </form>';
        if(isset($_POST["editUserName"])){
            getUserData();
        }
}

/** Hämtar data om användare och presenterar i formulär*/
function getUserData(){
    $conn = connectDb();
    $prepState = $conn->prepare("SELECT * FROM users WHERE Username ='".$_POST["editUserName"]."'");
    $prepState->execute();
    $fetchedData = $prepState->fetchAll();
    if(count($fetchedData) == 0){
        echo '<p>Kunde inte hitta användare<p>';
    }else{
        $Fname = $fetchedData[0]["Fname"];
        $Lname = $fetchedData[0]["Lname"];
        $Address = $fetchedData[0]["Adress"];
        $ZipCode = $fetchedData[0]["Zipcode"];
        $UserType = $fetchedData[0]["UserType"];
        $UserID = $fetchedData[0]["UserID"];
        echo'
              <form id="saveEditUser" action="Administrator.php" method="post">
              <input type="hidden" name="adminChoise" value="saveUser">
              <input type="hidden" name="adminOption" value="user">
              <input type="hidden" name="editUserUserID" value="'.$UserID.'">
        Fname:<input type="text" name="editUserFname" value="' .$Fname . '"><br>
        Lname:<input type="text" name="editUserLname" value="' .$Lname . '"><br>
        Address:<input type="text" name="editUserAddress" value="' .$Address . '"><br>
        ZipCode:<input type="text" name="editUserZipcode" value="' .$ZipCode . '"><br>
        UserType:<input type="text" name="editUserUserType" value="' .$UserType . '"><br>
              <input type="submit" value="Spara data"><br>
              </form>
            ';
    }
}
/**Tar data från användarformulär och uppdaterar databasen*/
function saveUserData(){
    $Fname = $_POST["editUserFname"];
    $Lname = $_POST["editUserLname"];
    $Address = $_POST["editUserAddress"];
    $ZipCode= $_POST["editUserZipcode"];
    $UserType = $_POST["editUserUserType"];
    $UserID = $_POST["editUserUserID"];
    $conn = connectDb();
    $prepState = $conn->prepare("UPDATE users SET Fname='$Fname',Lname='$Lname',Adress='$Address',Zipcode=$ZipCode,UserType=$UserType WHERE UserID=$UserID ");
    $prepState->execute();
    echo '
    <p>Användare uppdaterad!</p>
    ';
}
/**-----------------------Slut på redigera användare----------------------------*/
/** Funktioner för att lägga till produkt*/
function addProduct(){
    echo '
          <form id="addProduct" action="Administrator.php" method="post">
            <input type="hidden" name="adminOption" value="addproduct">
            <input type="hidden" name="adminChoise" value="saveaddproduct">
            Produktnamn: <input type="text" name="addProductName" required><br>
            Pris: <input type="number" name="addProductPrice" required><br>
            Antal: <input type="number" name="addProductAmount" required><br>
            Produkt Beskrivning:<br><textarea rows="12" cols="80" name="addProductDescription" form="addProduct">Beskrivning..</textarea><br>
            Visa i produktlista:
            <select name="addProductShow">
            <option value="0">Ja</option>
            <option value="1">Nej</option><br>
            </select>
            <input type="submit" value="Lägg till produkt">
          </form>
    ';
}

function saveAddProduct(){
    $Name = $_POST["addProductName"];
    $Price = $_POST["addProductPrice"];
    $Amount = $_POST["addProductAmount"];
    $hidden = $_POST["addProductShow"];
    $Description = $_POST["addProductDescription"];
    $conn = connectDb();
    $prepState = $conn->prepare("INSERT INTO product(ProductID, Name, Price, Amount, Description, Hidden) VALUES (DEFAULT,'$Name',$Price,$Amount,'$Description',$hidden)");
    $prepState->execute();
}
/**-----------------------Slut på lägga till ny produkt----------------------------*/
/** Funktioner för att ta bort produkt*/
function removeProduct(){
    echo '
        <form id="removeProduct" action="Administrator.php" method="post">
            <input type="hidden" name="adminOption" value="removeproduct">
            <input type="hidden" name="adminChoise" value="saveremoveproduct">
            Produktnamn: <input type="text" name="removeProductName" required><br>
            <input type="submit" value="Ta bort produkt">
        </form>
    ';
}

function saveRemoveProduct(){
    try {
        $Name = $_POST["removeProductName"];
        $conn = connectDb();
        $prepState = $conn->prepare("DELETE FROM product WHERE Name='$Name'");
        $prepState->execute();
        echo 'produkt borttagen';
    }catch (Exception $e){
        echo'<p>Produkten ligger redan i någons kundvagn, kan inte ta bort produkt.</p>';
    }
}
/**-----------------------Slut på ta bort produkt----------------------------*/
/** Funktioner för att redigera produkt*/
function editProduct(){
    echo'
    <form id="editProduct" action="Administrator.php" method="post">
        <input type="hidden" name="adminOption" value="editproduct">
        Produktnamn:<input type="text" name="editProductName" required>
        <input type="submit" value="Hämta data"><br>
    </form>';
    if(isset($_POST["editProductName"])){
        getProductData();
    }
}

function getProductData(){
    $conn = connectDb();
    $prepState = $conn->prepare("SELECT * FROM product WHERE Name ='".$_POST["editProductName"]."'");
    $prepState->execute();
    $fetchedData = $prepState->fetchAll();
    if(count($fetchedData) == 0){
        echo 'Kunde inte hitta produkt';
    }
    else{
        $Name = $fetchedData[0]["Name"];
        $Price = $fetchedData[0]["Price"];
        $Amount = $fetchedData[0]["Amount"];
        $Description = $fetchedData[0]["Description"];
        $ProductID = $fetchedData[0]["ProductID"];
        echo'
            <form id="addProduct" action="Administrator.php" method="post">
                <input type="hidden" name="editproductID" value="'.$ProductID.'">
                <input type="hidden" name="adminOption" value="editproduct">
                <input type="hidden" name="adminChoise" value="saveeditproduct">
                Produktnamn: <input type="text" name="editProductName" value="'.$Name.'"><br>
                Pris: <input type="text" name="editProductPrice" value="'.$Price.'"><br>
                Antal: <input type="text" name="editProductAmount" value="'.$Amount.'"><br>
                Visa i produktlista:<select name="editProductShow">
                <option value="0">Ja</option>
                <option value="1">Nej</option><br>
                </select>
                Produkt Beskrivning:<br><textarea rows="12" cols="80" name="editProductDescription" form="addProduct">'.$Description.'</textarea><br>
                <input type="submit" value="Lägg till produkt">
            </form>
        ';
    }
}

function saveProductData(){
    $Name = $_POST["editProductName"];
    $Price = $_POST["editProductPrice"];
    $Amount = $_POST["editProductAmount"];
    $Description= $_POST["editProductDescription"];
    $ProductID= $_POST["editproductID"];
    $Hidden= $_POST["editProductShow"];
    $conn = connectDb();
    $prepState = $conn->prepare("UPDATE product SET Name='$Name',Price=$Price,Amount=$Amount,Description='$Description', Hidden= $Hidden WHERE ProductID=$ProductID ");
    $prepState->execute();
    echo '
    <p>Produkt uppdaterad!</p>
    ';
}
?>