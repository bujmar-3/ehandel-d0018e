<?php
session_start();
?>
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
<div id="header">
    <div id="navmenu">
        <?php
        getNavBar();
        ?>
    </div>
</div>
<?php
if (checkLoggedIn()) {
    $data = userData();
    echo '
<div id="wrapper">
    <div id="left-sidebar"></div>
    <div id="content">
        <table id="productList">
            <tr>
                <th colspan="2">' . $data[0]["UserName"] . '</th>
            </tr>
            <tr>
                <td>Förnamn     </td>
                <td>' . $data[0]["Fname"] . '</td>
            </tr>
            <tr>
                <td>Efternamn     </td>
                <td>' . $data[0]["Lname"] . '</td>
            </tr>
            <tr>
                <td>Adress:     </td>
                <td>' . $data[0]["Adress"] . '</td>
            </tr>
            <tr>
                <td>Postkod:     </td>
                <td>' . $data[0]["Zipcode"] . '</td>
            </tr>
            <tr>
                <td>Användartyp:     </td>
                <td>';
                    if ($_SESSION['usertype']  == 0)
                    {
                     echo "Användare";
                    }
                    else
                    {
                        echo "Admin";
                    };
echo            '</td>
            </tr>
        </table>
        <br><br><br><br>';
             getOutcheckedCarts($data[0]["UserID"]);
echo '
    </div>
    <div id="right-sidebar">';
}

else {
    echo
        '<div id="wrapper">
            <div id="left-sidebar">
            </div>
            <div id="content">
                <table id="productList"></table>
                <P>Du måste vara inloggad för att få tillgång till din profil</p>
            </div>
            <div id="right-sidebar">';
}
        getLoginForm();
echo '
       </div>
    </div>
    </div>
    <div id="footer">
    </div>
</body>
</html>';

?>
<?php

function getOutcheckedCarts ($data) {
    $conn = connectDb();
    $prepState = $conn->prepare("SELECT order_instance.Name, order_instance.Date  FROM order_instance WHERE order_instance.Status = '2' &&order_instance.UserID = $data ");
    $prepState->execute();
    $fetchedData = $prepState->fetchAll();
    if (count($fetchedData) > 0){
        echo '<table id="productList">
            <tr>
                <th colspan="3">Utcheckade kundvagnar</th>
            </tr>';
    foreach ($fetchedData as $row)
    {
        echo '<tr>';
        echo    '<td><b>' . $row['Name'] . '</b></td>';
        echo    '<td>' . $row['Date'] . '</td>';
        echo    '<td><form method="post"><input type="submit" name="showOutcheckedCartButton" value="Visa"></form></td>';
        echo '</tr>';
    }
    echo '</table>';
}
    else {
        echo '<br>';
        echo "Du har inte utcheckat någon kundvagn.";
    }
}

function userData () {
    $conn = connectDb();
    $prepState = $conn->prepare("SELECT * FROM users WHERE Username ='". $_SESSION["username"] ."'");
    $prepState->execute();
    $fetchedData = $prepState->fetchAll();
    return ($fetchedData);
}
?>