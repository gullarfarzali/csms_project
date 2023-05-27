<!-- Admin Dashboard -->
<?php
require __DIR__ . "\database.php";

$sql = "SELECT * FROM users";

if($result = $mysqli->query($sql)) {

    //Return the number of rows in USERS
    $userCount = mysqli_num_rows($result);

    //Display result
    printf("%d", $userCount);
}
?>

<?php
$sql = "SELECT * FROM services";

if($result = $mysqli->query($sql)) {

    //Return the number of rows in SERVICES
    $serviceCount = mysqli_num_rows($result);

    //Display result
    printf("%d", $serviceCount);
}
?>

<?php
$sql = "SELECT * FROM orders";

if($result = $mysqli->query($sql)) {

    //Return the number of rows in ORDERS
    $orderCount = mysqli_num_rows($result);

    //Display result
    printf("%d", $orderCount);
}
?>

<?php
$sql = "SELECT SUM(total) AS earnings FROM orders";

$result = $mysqli->query($sql); 
$row = mysqli_fetch_assoc($result);

//Return total earnings
$sum = $row['earnings'];

//Display result
printf("%d", $sum);
?>