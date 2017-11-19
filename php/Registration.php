<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/productList.css">
    <?php include 'DbConnection.php'; ?>
    <?php include 'LoginForm.php'; ?>
</head>>

<body>

    <form action="<?php checkData($user, $name, $lname, $pass, $pass_rep, $adress, $zip) ?>" method="post" id="register">
        <fieldset>
            <label for="1"><b>Användarnamn: *</b></label><br><input type="text" name="username" id="1" required <?php $user = $_POST['username']; ?> >
            <label for="2"><b>Namn: </b></label><br><input type="text" name="name" id="2" <?php $name = $_POST["name"]; ?> >
            <label for="3"><b>Eftermanm: </b></label><br><input type="text" name="lastname" id="3" <?php $lname = $_POST["lastname"]; ?> >
            <label for="4"><b>Lösenord: *</b></label><br><input type="password" name="pass" id="4" required <?php $pass = $_POST["pass"]; ?> >
            <label for="5"><b>Upprepa lösenord: *</b></label><br><input type="password" name="pass_rep" id="5" required <?php $pass_rep = $_POST["pass_rep"]; ?> >
            <label for="6"><b>Adress: </b></label><br><input type="text" name="adress" id="6" <?php $adress = $_POST["adress"]; ?> >
            <label for="7"><b>Postkod: </b></label><br><input type="text" name="zip" id="7" <?php $zip = $_POST["zip"]; ?> >
            <input type="submit" name="Registrera">
            <button type="button" onclick="" name="Avbryt"></button>
        </fieldset>
    </form>
<?php

Function checkData($user, $name, $lname, $pass, $pass_rep, $adress, $zip)
{
    if(isset($_SESSION["username"])&&isset($_SESSION["pass"])&&isset($_SESSION["pass_rep"])){
        if ($pass_rep==$pass) {
            $conn = connectDb();
            $prepState = $conn->prepare("SELECT UserName FROM users WHERE Username ='".$user."'");
            $prepState->execute();
            $fetchedData = $prepState->fetchAll();
            if (count($fetchedData) == 0){
                insertData($user, $name, $lname, $pass, $adress, $zip);
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
    else{
        echo '<script> alert("Vänligen fyll i all obligatoriska fällt (*)") </script>';
    }
}
Function insertData($username, $name, $lname, $pass, $adress, $zip)
{
    $conn = connectDb();
    $sql = "INSERT INTO `users` (`UserID`, `UserName`, `Fname`, `Lname`, `Password`, `Adress`, `Zipcode`, `UserType`) VALUES ('4',$username, $name, $lname, $pass, $adress, $zip, '1')";
    if ($conn->query($sql) === TRUE) {
        echo "Ny användare skapad!";
    } else {
        echo "Error";
    }
}
?>
</body>
</html>
