<?php
echo '<!DOCTYPE html>';
echo '<html lang="sv">';
echo '<head>';
echo    '<meta charset="UTF-8">';
echo    '<link rel="stylesheet" type="text/css" href="css/productList.css">';
        include 'php/DbConnection.php';
echo    '</head>';
echo    '<body>';
?>

    <form method="post" id="register" action="Registration.php">
        <fieldset>
        <legend><b>  Registrering  </b></legend>
        <label for="1"><b>Användarnamn: *</b></label><br><input value="<?php if (isset($_POST["username"])) {echo $_POST["username"];} ?>" type="text" name="username" id="1" required><br><br>
        <label for="2"><b>Namn: </b></label><br><input value="<?php if (isset($_POST["name"])) {echo $_POST["name"];} ?>" type="text" name="name" id="2"><br><br>
        <label for="3"><b>Eftermanm: </b></label><br><input value="<?php if (isset($_POST["lastname"])) {echo $_POST["lastname"];} ?>" type="text" name="lastname" id="3"><br><br>
        <label for="4"><b>Lösenord: *</b></label><br><input type="password" name="pass" id="4" required><br><br>
        <label for="5"><b>Upprepa lösenord: *</b><br></label><input type="password" name="pass_rep" id="5" required><br><br>
        <label for="6"><b>Adress: </b></label><br><input value="<?php if (isset($_POST["adress"])) {echo $_POST["adress"];} ?>" type="text" name="adress" id="6"><br><br>
        <label for="7"><b>Postkod: </b></label><br><input value="<?php if (isset($_POST["zip"])) {echo $_POST["zip"];} ?>" type="text" name="zip" id="7"><br><br>
        <input type="submit" name="Registrera">
        <a href="index.php">Gå tillbaka</a>
        <!-- <button name="Button" onclick="index.php">Avbryt</button> -->

<?php
        check();
        function check() {
            if(isset($_POST['username']))
            {
                $username = $_POST["username"];
                $pass = $_POST["pass"];
                $pass_rep = $_POST["pass_rep"];
                signUp($username, $pass, $pass_rep);
            }
        }

echo '</fieldset>
     </form>';
    

Function signUp($user, $pass, $pass_rep)
{

        if ($pass_rep==$pass) {
            $conn = connectDb();
            $prepState = $conn->prepare("SELECT UserName FROM users WHERE Username ='".$user."'");
            $prepState->execute();
            $fetchedData = $prepState->fetchAll();
            if (count($fetchedData) == 0){
                newUser();
                return true;
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
    if (isset($_POST["username"])) {
        $user = $_POST["username"];
    }
    else {
        $user = null;
    }
    if (isset($_POST["name"])) {
        $name = $_POST["name"];
    }
    else {
        $name = null;
    }
    if (isset($_POST["lastname"])) {
        $lname = $_POST["lastname"];
    }
    else {
        $lname = null;
    }
    if (isset($_POST["pass"])) {
        $pass = $_POST["pass"];
    }
    else {
        $pass = null;
    }
    if (isset($_POST["adress"])) {
        $adress = $_POST["adress"];
    }
    else {
        $adress = null;
    }
    if (isset($_POST["zip"])) {
        $zip = $_POST["zip"];
    }
    else {
        $zip = null;
    }
    $conn = connectDb();
    $sql = "INSERT INTO `users` (`UserID`,`UserName`, `Fname`, `Lname`, `Password`, `Adress`, `Zipcode`, `UserType`) VALUES (DEFAULT ,'$user', '$name', '$lname', '$pass', '$adress', '$zip', '1')";
    if ($conn->exec($sql) == TRUE) {
        echo '<script> alert("Ny användare skapad!") </script>';
    } else {
        echo "Error";
    }
}

echo '</body>';
echo '</html>';
?>