<?php

Function ListProducts ($fetchedData){

    echo '<table id="productList">';
    echo    '<tr>';
    echo        '<th>Produkt Namn</th>';
    echo        '<th>Pris</th>';
    echo        '<th>Antal lager</th>';
    echo    '</tr>';

foreach ($fetchedData as $row)
    {

    echo    '<tr>';
    echo        '<td><a href="ProductInfo.php?ID=' . $row['ProductID'] . '">' . $row['Name'] . '</a></td>';
    echo        '<td>'. $row['Price'] .'kr</td>';
    echo        '<td>'. $row['Amount'] .'st</td>';
    echo    '</tr>';

    }
    echo '</table>';
}
?>