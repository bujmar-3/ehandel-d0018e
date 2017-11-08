<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/productList.css">
    <title>Test Site</title>
    <?php include 'php/DbConnection.php'; ?>
    <?php include 'php/ListProducts.php'; ?>
</head>
<body>
    <?php
    ListProducts(getProducts());
    ?>
</body>
</html>