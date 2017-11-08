<?php

Function ListProducts ($fetchedData){

    echo '<table id="productList" border="1px solid black">';
    echo    '<tr>';
    echo        '<th>Name</th>';
    echo        '<th>Price</th>';
    echo        '<th>Amount</th>';
    echo    '</tr>';

foreach ($fetchedData as $row)
    {

    echo    '<tr>';
    echo        '<td>'. $row['Name'] .'</td>';
    echo        '<td>'. $row['Price'] .'</td>';
    echo        '<td>'. $row['Amount'] .'</td>';
    echo        '</br>';
    echo    '</tr>';

    }
}
echo '</table>';

echo '</body>';
echo '</html>';
?>