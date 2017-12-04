<!DOCTYPE html>
<html lang="sv" xmlns="http://www.w3.org/1999/html">
<head>
    <link rel="stylesheet" type="text/css" href="css/productList.css">
    <meta charset="UTF-8">
    <?php include 'php/Navbar.php'; ?>
    <?php include 'php/LoginForm.php'; ?>
    <?php include 'php/DbConnection.php'; ?>
</head>
<body>
<?php
    session_start();
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
    if (isset($_POST['addToCartButton'])) {
        addToCart($id, $pris, 1);
        echo '<script> alert("Produkten är nu tillagd i din kundvagn")</script>';
    }
    // Skriv kommentar
    if (isset($_POST['comment']) && (isset($_POST['productGrade']))) {
        $conn = connectDb();
        $com = $_POST['comment'];
        $grade = $_POST['productGrade'];
        $user = $_SESSION['userid'];
        $sql = "INSERT INTO `rating` (`RatingID`,`ProductID`,`Comment`,`Rating`,`UserID`) VALUES (DEFAULT ,'$id', '$com', '$grade', '$user')";
        if ($conn->exec($sql) == TRUE) {
            echo '<script> alert("Kommentar tillagd!") </script>';
        }
        else {
            echo '<script> alert("Error: Kan inte lägga till data i databasen") </script>';
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
            </tr>

        </table>
        <br><br>
        <form action="ProductInfo.php?ID=<?php echo $id; ?>" method="post">
            <input id="addToCartButton" type="submit" value="Lägg till i kundvagn" name="addToCartButton">
        </form>
        <br><br>
        <?php
        $prepState = $conn->prepare("SELECT users.UserName, rating.Comment, rating.Rating, rating.RatingID FROM rating,users WHERE rating.ProductID = $id && users.UserID = rating.UserID");
        $prepState->execute();
        $fetchedData = $prepState->fetchAll();
        foreach ($fetchedData as $row)
        {
            echo "<br><br><br>";
            echo '<b>' . $row['UserName'] . '</b>';
            echo "<br><br>";
            echo $row['Comment'];
            echo "<br><br>";
            echo "Betyg: " . $row['Rating'] . "/5";
            echo "<br><br>";
            echo "_________________________________________________________________________________________________________________";
        }
        ?>
        <br><br><br><br>
        <h2>Skriv recension:</h2>
        <form id="addComment" method="post" action="ProductInfo.php?ID=<?php echo $id; ?>">
            <label><textarea rows="6" cols="124" form="addComment" name="comment" required>Skriv här...</textarea></label><br><br>
             <label>Ditt betyg:  <input type="number" name="productGrade" required></label> <br><br>
            <input type="submit" name="recension" value="Recensera">
        </form>
    </div>
    <div id="right-sidebar">
        <?php
        getLoginForm();
        ?>
    </div>
</div>

</body>
</html>
<?php
function addToCart($productID, $price, $amount){
    $cartID =$_SESSION['activecart'];
    $conn = connectDb();
    $prepState = $conn->prepare("INSERT INTO orders(OrderID, Amount, InstanceID, ProductID, Price) VALUES (DEFAULT, $amount, $cartID, $productID, $price)");
    $prepState->execute();
}
?>