<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/productList.css">
    <title>Test Site</title>
    <?php include 'php/DbConnection.php'; ?>
    <?php include 'php/ListProducts.php'; ?>
    <?php include 'php/LoginForm.php'; ?>
</head>
<body>
<?php session_start(); ?>
<div id="navmenu">
    <p>testmeny</p>
</div>
<div id="wrapper">
    <div id="content">
        <?php
        ListProducts(getProducts());
        ?>
    </div>
    <div id="right-sidebar">
        <?php
        getLoginForm();
        ?>
    </div>
</div>
</body>
</html>