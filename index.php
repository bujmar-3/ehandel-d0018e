<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/productList.css">
    <title>Test Site</title>
    <?php include 'php/DbConnection.php'; ?>
    <?php include 'php/ListProducts.php'; ?>
    <?php include 'php/LoginForm.php'; ?>
    <?php include 'php/Navbar.php'; ?>
</head>
<body>
<?php session_start(); ?>
<div id="header">
    <div id="navmenu">
        <?php
        getNavBar();
        ?>
    </div>
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