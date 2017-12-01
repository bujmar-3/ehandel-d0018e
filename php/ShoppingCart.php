<?php
/**
 * Created by PhpStorm.
 * User: MarZ
 * Date: 2017-12-01
 * Time: 16:09
 */
function listCarts(){
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
    echo '
            </table>
    ';

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

}