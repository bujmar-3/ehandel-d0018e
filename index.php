<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test Site</title>
</head>
<body>
    <?php include 'php/DbConnection.php'; ?>
    <?php include 'php/ListProducts.php'; ?>
    <?php
    ListProducts(getProducts());
    ?>
</body>
</html>