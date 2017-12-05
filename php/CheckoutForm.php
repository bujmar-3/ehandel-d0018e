<?php
/**
 * Created by PhpStorm.
 * User: MarZ
 * Date: 2017-12-04
 * Time: 16:42
 */

function checkoutPost(){
    if (isset($_POST['payID'])){
        checkOutCart($_POST['payID']);
    }
}

function getCheckOutFrom(){
    checkoutPost();
    $cartID = $_POST['checkoutID'];
    $cartName = $_POST['checkoutName'];
    $cartList = getCartProducts($cartID);
    if(count($cartList)>0){
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
            $sumprice = $row['Amount']*$row['Price'];
            echo '
            <tr>
                <td>' . $row['Name'] . '</td>
                <td>' . $row['Amount'] . 'st</td>
                <td>' . $sumprice . 'kr</td>
            </tr>
        ';
            $sum = $sum + $sumprice;
        }
        echo '
    <tr>
        <td></td>
        <td></td>
        <td><b>Summa: </b>'.$sum.' kr</td>
    </tr>
    </table>
    <div>
    <form action="Checkout.php" method="post">
        <input type="hidden" name="payID" value="'.$cartID.'">
        <input type="submit" value="Betala">
    </form>
    </div>
    ';
    }
    else{
        header("Location: Cart.php");
    }
}


function checkOutCart($cartID){
    try{
        $conn = connectDb();
        $conn->beginTransaction();
        $prepState = $conn->prepare("UPDATE order_instance SET Status = 2 WHERE InstanceID = $cartID");
        $prepState->execute();
        $cartProductList = getCartProducts($cartID);
        foreach ($cartProductList as $row){
            $productID = $row['ProductID'];
            $amount = $row['Amount'];
            $prepState = $conn->prepare("UPDATE product SET Amount = Amount - $amount WHERE ProductID = $productID");
            $prepState->execute();
        }
        $conn->commit();
    }catch (Exception $e){
        $conn->rollBack();
        echo 'Kunde inte checka ut kundvagn';
        die();
    }
    if($cartID == $_SESSION["activecart"]){
        setNextCartActive();
    }
    header("Location: Cart.php");
}