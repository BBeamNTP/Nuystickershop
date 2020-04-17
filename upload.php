<?php
function function_alert($message) {

    // Display the alert box
    echo "<script>alert('$message');</script>";
}
session_start();
if(!isset($_SESSION['email'])){
    header('location: login.php');
}
require 'connection.php';
echo " name : ".$name = $_POST['name'];
echo " price : ".$price = $_POST['price'];
echo " types : ".$types = $_POST['types'];
$sql = "select * from items order by id desc limit 0,1";
$result=mysqli_query($con,$sql);
$num_result = mysqli_num_rows($result);
$dbarr = mysqli_fetch_row($result) ;
echo " id : ".$item_id = $dbarr[0]+1 ; // นำค่า id มาเพิ่มให้กับค่ารหัสสินค้าครั้งละ1
echo " path : ".$path = $types.(string)$item_id.".jpg";

$target_dir = "img/product/".$types."/";
//$target_file = $target_dir . basename($_FILES.$path); //ชื่อไฟล์แบบเดิม
$target_file = $target_dir . $path;  //เปลียรนชื่อไฟล์ใหม่

if(!@mkdir($target_dir,0,true)){ // เช็คว่ามีไฟล์หรือยัง
//        echo "Folder Created.";
}
else
{
    echo "Folder Not Create.";
}

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $add_items_query = "insert into items(id, types, name, price, image) values ('$item_id','$types','$name', '$price','$target_file')";
        $add_items_result = mysqli_query($con, $add_items_query) or die(mysqli_error($con));
        mysqli_close($con);
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        function_alert("สร้างรายการสินค้าเรียบร้อยแล้ว");
        echo "<meta http-equiv='refresh' content='0;url=addproduct.php'>";
        exit();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


?>