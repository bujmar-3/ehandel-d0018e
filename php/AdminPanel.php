<?php
/**
 * Created by PhpStorm.
 * User: MarZ
 * Date: 2017-11-25
 * Time: 16:31
 */
function getAdminPanel(){
    echo'
    <form id="adminFrom" action="Administrator.php" method="post">
    <select>
        <option value="user">Användare</option>
        <option value="addproduct">Lägg till produkt</option>
        <option value="removeproduct">Ta bort produkt</option>
        <option value="changeproduct">Redigera produkt</option>
    </select>
    <input type="submit" value="Välj">
    </form>
    ';

}