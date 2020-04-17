<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['email'])) {
    header('location: login.php');
}
function function_alert($message)
{
    // Display the alert box
    echo "<script>alert('$message');</script>";
}
$user_id = $_SESSION['id'];
$bill_id = $_GET['id'];
$name = $_POST['name'];
$contact = $_POST['contact'];
$city = $_POST['city'];
$address = $_POST['address'];


if( ($name == "" || $name == null) && ($contact == "" || $contact == null) && ($city == "" || $city == null) && ($address == "" || $address == null) ) { ?>
    <script>
        window.alert("คุณไม่ได้กรอกข้อมูลเพื่อแก้ไข");
        window.location.href = 'payment.php?id=<?php echo $bill_id ?>';

    </script>
    <?php
} else {

    $user_update_query = "UPDATE `users` SET `name`='$name',`contact`='$contact',`city`='$city',`address`='$address' WHERE id = '$user_id' ";
    $user_update_result = mysqli_query($con, $user_update_query) or die(mysqli_error($con));
    mysqli_close($con);
    ?>
<script>
    window.alert("แก้ไขข้อมูลเรียบร้อยแล้ว");
    window.location.href = 'payment.php?id=<?php echo $bill_id ?>';

</script>

<?php }

?>