<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/Layout.css">
    <?php include 'php/DbConnection.php'; ?>
    <?php include 'php/LoginForm.php'; ?>
    <?php include 'php/Navbar.php'; ?>
</head>
<body>
<?php
session_start();
echo '
<div id="header">
    <div id="navmenu">';
        getNavBar();
echo    '</div>
</div>
<div id="wrapper">
    <div id="left-sidebar">
    </div>
    <div id="content">
        <table id="productList"></table>';
        if (checkLoggedIn() == true) {
            echo '<p>Du är redan registrarad!</p>';
        }
        else if (checkLoggedIn() == false) {
            registrationForm();
        }
echo '    
    </div>
    <div id="right-sidebar">
    </div>
</div>
<div id="footer"></div>

</body>
</html>';

    if (isset($_POST['username']) && isset($_POST['pass']) && isset($_POST['pass_rep'])) {
        signUp();
    }

function registrationForm() {
    echo      '<br><form method="post" id="register" action="Registration.php">';
    echo            '<label for="1"><b>Användarnamn: *</b></label><br><input value="'; getPreset("username"); echo  '" type="text" name="username" id="r1" required><br><br>';
    echo            '<label for="2"><b>Namn: </b></label><br><input value="'; getPreset("name"); echo '" type="text" name="name" id="2"><br><br>';
    echo            '<label for="3"><b>Eftermanm: </b></label><br><input value="'; getPreset("lastname"); echo '" type="text" name="lastname" id="3"><br><br>';
    echo            '<label for="4"><b>Lösenord: *</b></label><br><input value="" type="password" name="pass" id="regPass" required><br><br>
                    <label for="5"><b>Upprepa lösenord: *</b><br></label><input value="" type="password" name="pass_rep" id="regPass" required><br><br>';
    echo            '<label for="6"><b>Adress: </b></label><br><input value="'; getPreset("adress"); echo '" type="text" name="adress" id="6"><br><br>';
    echo            '<label for="7"><b>Postkod: </b></label><br><input value="'; getPreset("zip"); echo '" type="number" name="zip" id="7"><br><br> 
                    <input type="submit" name="Registrera" value="Registrera">
                </form>';
}

function getPreset ($str) {
        if (isset($_POST[$str])) {
            echo $_POST[$str];
        }
}

Function signUp()
{
        if ($_POST['pass'] == $_POST['pass_rep']) {
            $conn = connectDb();
            $prepState = $conn->prepare("SELECT UserName FROM users WHERE Username ='".$_POST['username']."'");
            $prepState->execute();
            $fetchedData = $prepState->fetchAll();
            if (count($fetchedData) == 0){
                newUser();
            }
            else {
                echo '<script> alert("Användarnamnet du angivit är redan taget") </script>';
            }
        }
        else {
            echo '<script> alert("Lösenord och upprepa lösenord matchar inte varandra") </script>';
        }
}
Function newUser()
{
    $user = $_POST["username"];
    $name = $_POST["name"];
    $lname = $_POST["lastname"];
    $pass = $_POST["pass"];
    $adress = $_POST["adress"];
    $zip = $_POST['zip'];
    $conn = connectDb();
    $sql = "INSERT INTO users (UserID,UserName, Fname, Lname, Password, Adress, Zipcode, UserType) VALUES (DEFAULT ,'$user', '$name', '$lname', '$pass', '$adress', $zip, '0')";
    if ($conn->exec($sql) == TRUE) {
        echo '<script> alert("Ny användare skapad!") </script>';
    } else {
        echo "Error: Kan inte lägga till data i databasen.";
    }
}
