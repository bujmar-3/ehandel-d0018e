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
        <button id="addToCartButton" onclick="<?php echo "addToCart($id, $pris, $antal);" ?>">Lägg till i kundvagn</button>
        <br><br><br><br>
        <h2>Skriv kommentar:</h2>
        <form id="addComment" method="post" action="ProductInfo.php?ID=<?php echo $id; ?>">
            <label><textarea rows="6" cols="124" form="addComment">Skriv här...</textarea></label>
            <input type="submit" name="Kommentera" value="Kommentera">
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
