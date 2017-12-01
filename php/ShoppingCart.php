<?php
/**
 * Created by PhpStorm.
 * User: MarZ
 * Date: 2017-12-01
 * Time: 16:09
 */
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
    }
}

function getCartData(){
    $userid = $_SESSION["userid"];
    $conn = connectDb();
    $prepState = $conn->prepare("SELECT InstanceID, Date, Name, Status FROM order_instance WHERE UserID = $userid");
    $prepState->execute();
    $fetchedData = $prepState->fetchAll();
    return $fetchedData;
}

function createCartTable($cartList){
    foreach ($cartList as $row){
        echo '
            <tr>
                <td>'. $row['Name'] .'</td>
                <td>'. $row['Date'] .'</td>
                <td>'. $row['Status'] .'</td>
            </tr>
        ';
    }
}

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

function checkCartPost(){
    if(isset($_POST["newCartName"])){
        createNewCart();
    }
}

function createNewCart(){
    $todayDate = date('Y-m-d');
    $name = $_POST["newCartName"];
    $userID = $_SESSION["userid"];
    $conn = connectDb();
    $prepState = $conn->prepare("INSERT INTO order_instance(InstanceID, Date, UserID, Name, Status) VALUES (DEFAULT, '$todayDate', $userID, '$name', 1)");
    $prepState->execute();
}