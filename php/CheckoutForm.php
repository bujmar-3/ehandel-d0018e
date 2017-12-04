<?php
/**
 * Created by PhpStorm.
 * User: MarZ
 * Date: 2017-12-04
 * Time: 16:42
 */

function checkoutPost(){
    if(isset($_POST['checkoutName'])){
        getCheckOutFrom();
    }
    elseif (isset($_POST['checkoutID'])){
        checkOutCart($_POST['checkoutID']);
    }
}

function getCheckOutFrom(){
    $cartID = $_POST['checkoutID'];
    $cartName = $_POST['checkoutName'];
    $cartList = getCartProducts($cartID);
    echo '
    <table id="productList">
            <tr>
                <th>' . $cartName . '</th>
                <th></th>
                <th></th>
            </tr>
    ';
    $sum = 0;
    foreach ($cartList as $row){
        echo '
            <tr>
                <td>' . $row['Name'] . '</td>
                <td>' . $row['Amount'] . 'st</td>
                <td>' . $row['Price'] . 'kr</td>
            </tr>
        ';
        $sum = $sum + $row['Price'];
    }
    echo '
    <tr>
        <td></td>
        <td></td>
        <td><b>Summa: </b>'.$sum.' kr</td>
    </tr>
    </table>
    <div><form action="Checkout.php" method="post">
        <input type="hidden" name="checkoutID" value="'.$cartID.'">
        <input type="submit" value="Betala">
    </form></div>
    ';
}


function checkOutCart($cartID){
    $conn = connectDb();
    $prepState = $conn->prepare("UPDATE order_instance SET Status = 2 WHERE InstanceID =$cartID");
    $prepState->execute();
    getNextCart();
    header("Location: Cart.php");
}