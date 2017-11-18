<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/productList.css">
    <title>Test Site</title>
    <?php include 'php/DbConnection.php'; ?>
    <?php include 'php/ListProducts.php'; ?>
    <?php include 'php/LoginForm.php'; ?>
</head>
<body>
    <?php
    session_start();
    ListProducts(getProducts());
    getLoginForm();
    ?>
</body>
</html>