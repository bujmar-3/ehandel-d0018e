<?php
echo '<!DOCTYPE html>';
echo '<html lang="sv">';
echo '<head>';
echo    '<meta charset="UTF-8">';
echo    '<link rel="stylesheet" type="text/css" href="css/productList.css">';
        include 'php/DbConnection.php';
echo    '</head>';
echo    '<body>';

    echo '<form method="post" id="register" action="Registration.php">';
        echo '<fieldset>';
        echo    '<legend><b>Registrering</b></legend>';
        echo    '<label for="1"><b>Användarnamn: *</b></label><br><input type="text" name="username" id="1" required><br><br>';
        echo    '<label for="2"><b>Namn: </b></label><br><input type="text" name="name" id="2"><br><br>';
        echo    '<label for="3"><b>Eftermanm: </b></label><br><input type="text" name="lastname" id="3"><br><br>';
        echo    '<label for="4"><b>Lösenord: *</b></label><br><input type="text" name="pass" id="4" required><br><br>';
        echo    '<label for="5"><b>Upprepa lösenord: *</b><br></label><input type="text" name="pass_rep" id="5" required><br><br>';
        echo    '<label for="6"><b>Adress: </b></label><br><input type="text" name="adress" id="6"><br><br>';
        echo    '<label for="7"><b>Postkod: </b></label><br><input type="text" name="zip" id="7"><br><br>';
        echo    '<input type="submit" name="Registrera">';
        echo   '<!-- <button type="button" onclick="" name="Avbryt"></button> -->';

                if (isset($_POST["username"])) {
                    $user = $_POST["username"];
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
                if (isset($_POST["pass_rep"])) {
                    $pass_rep = $_POST["pass_rep"];
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
//checkData($user, $name, $lname, $pass, $pass_rep, $adress, $zip);
echo '</fieldset>';
echo '</form>';

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

echo '</body>';
echo '</html>';
?>