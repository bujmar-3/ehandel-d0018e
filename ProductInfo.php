<!DOCTYPE html>
<html lang="sv" xmlns="http://www.w3.org/1999/html">
<head>
    <link rel="stylesheet" type="text/css" href="css/Layout.css">
    <meta charset="UTF-8">
    <?php include 'php/Navbar.php'; ?>
    <?php include 'php/LoginForm.php'; ?>
    <?php include 'php/DbConnection.php'; ?>
    <?php include 'php/ShoppingCart.php'; ?>
</head>
<body>
<?php
    session_start();

    //Hämta information om produkten
    if (isset($_GET['ID'])) {
        $id = $_GET['ID'];
        $conn = connectDb();
        $sql = $conn->prepare("SELECT * FROM `product` WHERE ProductId ='" . $id . "'");
        $sql->execute();
        $check = $sql->fetchAll();
        if (count($check) > 0){
                foreach ($check as $row) {
                    $namn = $row['Name'];
                    $pris = $row['Price'];
                    $antal = $row['Amount'];
                    $beskrivning = $row['Description'];
                }
        }
        else {
            echo "Denna produkt finns inte!";
            exit();
        }
    }
    else {
        echo "Ingen produkt i systemet har detta ID";
        exit();
    }

    //Lägg till i kundvagn
    if (isset($_POST['addToCartButton'])) {
        if (checkLoggedIn() == TRUE) {
            if ( isset($_SESSION['activecart']))  {
                //if ()
                addToCart($id, $pris, 1);
                echo '<script> alert("Produkten är nu tillagd i din kundvagn")</script>';
            }
            else {
                createNewCart("Kundvagn");
                addToCart($id, $pris, 1);
            }
        }
        else {
            echo '<script> alert("Du måste vara inloggad för att kunna lägga till produkter i kundvagnen!")</script>';
        }
    }

    // Skriv kommentar
    if (isset($_POST['comment']) && (isset($_POST['productGrade']))) {
        if (checkLoggedIn() == TRUE) {
            writeComment();
        }
        else {
            echo '<script> alert("Du måste vara inloggad för att kunna skriva en recension!") </script>';
        }
    }

?>

<div id="header">
    <div id="navmenu">
        <?php
            getNavBar();
        ?>
    </div>
</div>
<div id="wrapper">
    <div id="left-sidebar">
    </div>
    <div id="content">
        <table id="productList">
            <tr>
                <th colspan="2"><?php echo "$namn" ?></th>
            </tr>
            <tr>
                <td>Pris:     </td>
                <td><?php echo "$pris" ?></td>
            </tr>
            <tr>
                <td>Antal:     </td>
                <td><?php echo "$antal" ?></td>
            </tr>
            <tr>
                <td>Beskrivning:     </td>
                <td><?php echo "$beskrivning" ?></td>
            </tr>
            <tr>
                <td>Snittbetyg:     </td>
                <td><?php $snitt  = getGrade(); echo $snitt;?></td>
            </tr>

        </table>
        <br><br>
        <form action="ProductInfo.php?ID=<?php echo $id; ?>" method="post">
            <input id="addToCartButton" type="submit" value="Lägg till i kundvagn" name="addToCartButton">
        </form>
        <br><br><br><br>
        <?php
            getComments();
        ?>
        <br><br><br><br>
        <h2>Skriv recension:</h2>
        <form id="addComment" method="post" action="ProductInfo.php?ID=<?php echo $id; ?>">
            <label><textarea rows="6" cols="124" form="addComment" name="comment" required>Skriv här...</textarea></label><br><br>
             <label>Ditt betyg:  <input type="number" name="productGrade" min="1" max="5" required></label> <br><br>
            <input type="submit" name="recension" value="Recensera">
        </form>
        <br><br><br><br><br><br>
    </div>
    <div id="right-sidebar">
        <?php
            getLoginForm();
        ?>

</div>
</div>
<div id="footer">
</div>
</body>
</html>
<?php

function getGrade () {
    $conn = connectDb();
    $id = $_GET['ID'];
    $count = 0;
    $num = 0;
    $sql = $conn->prepare("SELECT rating.Rating FROM rating,users WHERE rating.ProductID = $id");
    $sql->execute();
    $check = $sql->fetchAll();
    if (count($check) > 0){
        foreach ($check as $row) {
            $num = $num + $row['Rating'];
            $count = $count+1;
        }
        return ($num/$count . " / 5 ");
    }
    else {
        return ("Det finns inga betyg");
    }
}

function getComments () {
    $conn = connectDb();
    $id = $_GET['ID'];
    $prepState = $conn->prepare("SELECT users.UserName, rating.Comment, rating.Rating, rating.RatingID FROM rating,users WHERE rating.ProductID = $id && users.UserID = rating.UserID");
    $prepState->execute();
    $fetchedData = $prepState->fetchAll();
    if (count($fetchedData) > 0){
        echo '<table id="productList">
            <tr>
                <th colspan="3">Recensioner:</th>
            </tr>';
        foreach ($fetchedData as $row)
        {
            echo '<tr>';
            echo    '<td>';
            echo        '<b>' . $row['UserName'] . '</b>';
            echo    "<br><br>";
            echo    "Betyg: " . $row['Rating'] . "/5";
            echo        '</td>';
            echo    '<td colspan="2">';
            echo    $row['Comment'];
            echo    '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
    else {
        echo '<br>';
        echo "Det finns inga recensioner.";
    }
}

function writeComment () {
    $conn = connectDb();
    $id = $_GET['ID'];
    $com = $_POST['comment'];
    $grade = $_POST['productGrade'];
    $user = $_SESSION['userid'];
    $sql = "INSERT INTO rating (RatingID,ProductID,Comment,Rating,UserID) VALUES (DEFAULT ,$id, '$com', $grade, $user)";
    if ($conn->exec($sql) == TRUE) {
        echo '<script> alert("Kommentar tillagd!") </script>';
    }
    else {
        echo '<script> alert("Error: Kan inte lägga till data i databasen") </script>';
    }
}

function addToCart($productID, $price, $amount){
    $cartID =$_SESSION['activecart'];
    $activeCartData = getCartProducts($cartID);
    $foundproduct = false;
    foreach ($activeCartData as $row) {
        if ($row['ProductID'] == $productID && $row['Price'] == $price) {
            $conn = connectDb();
            $prepState = $conn->prepare("UPDATE orders SET Amount = Amount + 1 WHERE InstanceID =$cartID && ProductID = $productID && Price = $price");
            $prepState->execute();
            $foundproduct = true;
        }
    }
    if($foundproduct == false){
        $conn = connectDb();
        $prepState = $conn->prepare("INSERT INTO orders(OrderID, Amount, InstanceID, ProductID, Price) VALUES (DEFAULT, $amount, $cartID, $productID, $price)");
        $prepState->execute();
    }
}
?>