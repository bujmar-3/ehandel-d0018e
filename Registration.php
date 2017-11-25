<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <?php include 'php/DbConnection.php'; ?>
</head>
<body>
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
        </fieldset>
    </form>
</body>
</html>

<?php
    if (isset($_POST['username']) && isset($_POST['pass']) && isset($_POST['pass_rep'])) {
        signUp();
    }

Function signUp()
{
        if ($_POST['pass_rep']== $_POST['pass_rep']) {
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
    $zip = $_POST["zip"];
    $conn = connectDb();
    $sql = "INSERT INTO `users` (`UserID`,`UserName`, `Fname`, `Lname`, `Password`, `Adress`, `Zipcode`, `UserType`) VALUES (DEFAULT ,'$user', '$name', '$lname', '$pass', '$adress', '$zip', '1')";

    if ($conn->exec($sql) == TRUE) {
        echo '<script> alert("Ny användare skapad!") </script>';
    } else {
        echo "Error: Kan inte lägga till data i databasen.";
    }
}
?>