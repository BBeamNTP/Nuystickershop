<?php
require 'connection.php';
session_start();
if (!isset($_SESSION['email'])) {
    header('location: login.php');
}
$user_id = $_SESSION['id'];
$billing_id = $_GET['id'];
$status = $_POST['status'];
$billing_update_query = "UPDATE `billing` SET `status`='$status' WHERE id = '$billing_id' ";
$billing_update_result = mysqli_query($con, $billing_update_query) or die(mysqli_error($con));
?>
<script>
    window.alert('แก้ไขสถานะของหมายเลขรายการ <?php echo $billing_id ?> เรียบร้อย');
    window.location.href = 'adminbilling.php';
</script>