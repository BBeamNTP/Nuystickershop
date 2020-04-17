<?php
function function_alert($message)
{

    // Display the alert box
    echo "<script>alert('$message');</script>";
}

session_start();
if (!isset($_SESSION['email'])) {
    header('location: login.php');
}
require 'connection.php';
$user_id = $_SESSION['id'];
$bill_id = $_GET['id'];

$dayTH = ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'];
$monthTH = [null, 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
$monthTH_brev = [null, 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];

function thai_date_short_number($time)
{   // 19-12-56
    global $dayTH, $monthTH;
    $thai_date_return = date("d", $time);
    $thai_date_return .= "-" . date("m", $time);
    $thai_date_return .= "-" . substr((date("Y", $time) + 543), -2);
    return $thai_date_return;
}

function thai_date_fullmonth($time)
{   // 19 ธันวาคม 2556
    global $dayTH, $monthTH;
    $thai_date_return = date("j", $time);
    $thai_date_return .= " " . $monthTH[date("n", $time)];
    $thai_date_return .= " " . (date("Y", $time) + 543);
    return $thai_date_return;
}

$date = thai_date_short_number(time());
$date2 = thai_date_fullmonth(time());


echo $path = 'payment-' . $user_id . "-" . (string)$bill_id . "-" . $date . ".jpg";
$target_dir = "img/payment/" . $bill_id . "/"; //ที่อยู่ ของไฟล์ที่เก็บ รูป
$target_file = $target_dir . $path;  //เปลียรนชื่อไฟล์ใหม่

//$flgCreate = mkdir("$target_dir");
if (!@mkdir($target_dir, 0, true)) {
//        echo "Folder Created.";
} else {
    echo "Folder Not Create.";
}

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
$n = 1;
if (file_exists($target_file)) {
    echo $path = 'payment-' . $user_id . "-" . (string)$bill_id . "-" . $date . ".jpg";
    $target_file = $target_dir . $path;  //เปลียรนชื่อไฟล์ใหม่
    $n = $n + 1;
} else {

}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo " path : " . $target_file;

        $add_payment_query = "insert into payment(user_id,bill_id,image, time) values ('$user_id','$bill_id','$target_file', '$date2')";
        $add_payment_result = mysqli_query($con, $add_payment_query) or die(mysqli_error($con));
        $billing_update_query = "UPDATE `billing` SET `status`='Wait' WHERE id = '$bill_id' ";
        $billing_update_result = mysqli_query($con, $billing_update_query) or die(mysqli_error($con));
        mysqli_close($con);
        basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";

        ?>
        <script>
            window.alert('แจ้งชำระสินค้าเรียบร้อย กรุณารอผลการตรวจสอบ ภายใน 24 ชม.');
            window.location.href = 'billing.php';
        </script>
        <?php
        exit();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


?>

