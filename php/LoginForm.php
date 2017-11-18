<?php
/**
 * Created by PhpStorm.
 * User: MarZ
 * Date: 2017-11-18
 * Time: 15:57
 */
function getLoginForm(){
    echo '
    <form action="login.php" method="post">
    Användarnamn: <input type="text" name="username"><br>
    Lösenord: <input type="password" name=password"><br>
    <input type="submit">
    </form>';
}