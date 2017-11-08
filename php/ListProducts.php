<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../CSS/productList.css">
    <meta charset="UTF-8">
</head>
<body>

<table id="productList" border="1px solid black">
    <tr>
    <th>Name</th>
    <th>Price</th>
    <th>Amount</th>
    </tr>
<?php
Function ListProducts ($fetchedData){
foreach ($fetchedData as $row){
?>
    <tr>
    <td><?php echo $row['Name']?> </td>
    <td><?php echo $row['Price']?> </td>
    <td><?php echo $row['Amount']?> </td>
        </br>
    </tr>
<?php } ?>
<?php } ?>

</table>

</body>
</html>