<?php
require 'connection.php';
require 'header.php';
session_start();
$item_id = $_GET['id'];
$type = $_GET['type'];
$user_id = $_SESSION['id'];
$num1 = $_POST['num1'];
printf("Num1". $num1. "\n") ;
printf("item_id". $item_id. "\n") ;
printf("type". $type. "\n") ;
printf("*-*-*--". $type. "\n") ;

$sql = "SELECT * FROM items WHERE id = '$item_id';";
$result = mysqli_query($con, $sql);


if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        "id: " . $row["id"]. " - Name: " . $row["name"]. "- Price " . $row["price"]. "<br>";
        $totalprice = $num1 * $row['price'];
    }
} else {
    echo "0 results";
}


echo "TotalPrice : " . $totalprice;


$add_to_cart_query = "insert into users_items(user_id,item_id,status, quantity, totalprice) values ('$user_id','$item_id','Added to cart', '$num1' , '$totalprice')";
$add_to_cart_result = mysqli_query($con, $add_to_cart_query) or die(mysqli_error($con));
header("location: products.php?&type=$type");


mysqli_close($con);

?>