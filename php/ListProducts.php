<?php

Function ListProducts ($fetchedData){

    echo '<table id="productList">';
    echo    '<tr>';
    echo        '<th>Name</th>';
    echo        '<th>Price</th>';
    echo        '<th>Amount</th>';
    echo    '</tr>';

foreach ($fetchedData as $row)
    {

    echo    '<tr>';
    echo        '<td><a href="ProductInfo.php?ID=' . $row['ProductID'] . '">' . $row['Name'] . '</a></td>';
    echo        '<td>'. $row['Price'] .'</td>';
    echo        '<td>'. $row['Amount'] .'</td>';
    echo    '</tr>';

    }
    echo '</table>';
}
?>