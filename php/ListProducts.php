<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="">
    <meta charset="UTF-8">
</head>
<body>

<table>
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
    <td><?php echo $row['Name'] . "<br />";?> </td>
    <td><?php echo $row['Price'] . "<br />";?> </td>
    <td><?php echo $row['Amount'] . "<br />";?> </td>
    </tr>
<?php } ?>
<?php } ?>

</table>

</body>
</html>