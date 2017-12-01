<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
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
echo $pris . "$antal" . "$beskrivning" . "$namn";
?>
</body>
</html>
