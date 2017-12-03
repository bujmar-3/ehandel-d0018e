<?php
/**
 * Created by PhpStorm.
 * User: MarZ
 * Date: 2017-12-01
 * Time: 16:09
 */

/**Listar och visar alla kundvagnar som personen har*/
function listCarts(){
    if(checkLoggedIn())
    {
        checkCartPost();
        $cartList = getCartData();
        echo '
            <table id="productList">
            <tr>
                <th>Namn</th>
                <th>Datum</th>
                <th>Status</th>
                <th></th>
            </tr>
        ';
        if (count($cartList) >= 1){
            createCartTable($cartList);
        }
        else{
            echo '
            <p>Du har ingen kundvagn ännu.</p>
        ';
        }
        createNewCartButton();
        echo '
            </table>
    ';
    }
    else{
        echo '
        <p>Du måste vara inloggad för att visa denna sida</p>
        ';
        die();
    }
}

/**Hämtar alla kundvagnar och dess data från databasen*/
function getCartData(){
    $userid = $_SESSION["userid"];
    $conn = connectDb();
    $prepState = $conn->prepare("SELECT InstanceID, Date, Name, Status FROM order_instance WHERE UserID = $userid");
    $prepState->execute();
    $fetchedData = $prepState->fetchAll();
    return $fetchedData;
}

/**Skapar en tabell av personliga kundvagnar*/
function createCartTable($cartList){
    foreach ($cartList as $row){
        echo '
            <tr>
                <td>'. $row['Name'] .'</td>
                <td>'. $row['Date'] .'</td>
                <td>'. $row['Status'] .'</td>
                <form id="newCart" action="Cart.php" method="post">
                <input type="hidden" name="activecart" value="'.$row['InstanceID'].'">
                <input type="hidden" name="activecartname" value="'.$row['Name'].'">
                <td><input type="submit" value="Välj"></td>
                </form>
            </tr>
        ';
    }
}

/**Skapar en rad innehållande knapp för att skapa ny kundvagn*/
function createNewCartButton(){
    $todayDate = date('Y-m-d');
    echo'
    <tr>
            <form id="newCart" action="Cart.php" method="post">
                <td><input type="text" name="newCartName" required></td>
                <td>'. $todayDate .'</td>
                <td><input type="submit" value="Skapa"></td>
            </form>
    </tr>
    ';
}

/**Kollar om GET eller POST anrop mot sidan körts*/
function checkCartPost(){
    if(isset($_POST["newCartName"])){
        createNewCart();
    }
    if(isset($_GET['ID'])){
        showCart($_GET['ID'],$_GET['Name']);
    }
    if(isset($_POST['activecart'])){
        setActiveCart($_POST['activecart'], $_POST['activecartname']);
    }
    if(isset($_SESSION['activecart'])){
        showCart($_SESSION['activecart'], $_SESSION['activecartname']);
    }
}

/**Skapar ny kundvagn med data från POST*/
function createNewCart(){
    $todayDate = date('Y-m-d');
    $name = $_POST["newCartName"];
    $userID = $_SESSION["userid"];
    $conn = connectDb();
    $prepState = $conn->prepare("INSERT INTO order_instance(InstanceID, Date, UserID, Name, Status) VALUES (DEFAULT, '$todayDate', $userID, '$name', 1)");
    $prepState->execute();
}

/**Visar innehåll av kundvagn baserat på kundvagnsID*/
function showCart($cartId, $cartName)
{
    echo '
          <table id="productList">
            <tr>
                <th>' . $cartName . '</th>
                <th></th>
                <th></th>
            </tr>
    ';
    $cartProductList = getCartProducts($cartId);
    foreach ($cartProductList as $row) {
        echo '
            <tr>
                <td>' . $row['Name'] . '</td>
                <td>' . $row['Amount'] . 'st</td>
                <td>' . $row['Price'] . 'kr</td>
            </tr>
        ';
    }
    echo'
            <form id="checkOut" action="Cart.php" method="post">
                <tr>
                    <td></td>
                    <td></td>
                    <td><input type="submit" value="Checka ut"></td>
                </tr>
            </form>
        </table>
    ';
}

function getCartProducts($cartID)
{
    $conn = connectDb();
    $prepState = $conn->prepare("SELECT product.Name, orders.Amount, orders.Price FROM product, orders WHERE orders.instanceID = $cartID && orders.ProductID = product.ProductID");
    $prepState->execute();
    $fetchedData = $prepState->fetchAll();
    return $fetchedData;
}

/**Sätter aktiv kundvagn till cartID**/
function setActiveCart($cartID, $cartName){
    $_SESSION["activecart"] = $cartID;
    $_SESSION["activecartname"] = $cartName;
}

/**Lägger till produkt i aktiv kundvagn*/
function addToCart($productID, $price, $amount){
    $cartID =$_SESSION['activecart'];
    $conn = connectDb();
    $prepState = $conn->prepare("INSERT INTO orders(OrderID, Amount, InstanceID, ProductID, Price) VALUES (DEFAULT, $amount, $cartID, $productID, $price)");
    $prepState->execute();
}