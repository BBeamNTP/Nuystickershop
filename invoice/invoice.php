<?php
session_start();
require '../connection.php';

if (!isset($_SESSION['email'])) {
    header('location: login.php');
}
$user_id = $_SESSION['id'];
$billing_id = $_GET['id'];
$user_products_query = "select * from users_items ut inner join items it on it.id=ut.item_id where ut.user_id='$user_id' and ut.bill_id='$billing_id' and ut.status='Confirmed'";
$user_products_result = mysqli_query($con, $user_products_query) or die(mysqli_error($con));
$no_of_user_products = mysqli_num_rows($user_products_result);
$sum = 0;

$user_query = "select us.id, us.name, us.email, us.contact, us.city, us.address, bl.time, bl.id from users us inner join billing bl on us.id=bl.user_id where us.id = '$user_id' and bl.id='$billing_id'";
$user_result = mysqli_query($con, $user_query) or die(mysqli_error($con));
$row = mysqli_fetch_array($user_result);
//echo $row['time'];
//echo $row['id'];
//echo $row['name'];
//echo $row['email'];
//echo $row['contact'];
//echo $row['city'];
//echo $row['address'];
$user_email = $row['email'];
$user_name = $row['name']; //name user
$user_status = $_SESSION['status']; //status user
$user_contact = $row['contact']; //contact user
$user_city = $row['city'];//city user
$user_address = $row['address']; //address user
$billing_time = $row['time'];
if ($no_of_user_products == 0) {
    ?>
    <script>
        window.alert("No items in the cart!!");
    </script>
    <?php
} else {
    while ($row = mysqli_fetch_array($user_products_result)) {
        $sum = $sum + $row['totalprice'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="logo.jpg"/>

    <style type="text/css" media="print">
        input {

            display: none;
        }
    </style>


    <title>NuySticker Store</title>
    <link rel="stylesheet" href="style.css" media="all"/>
    <input type="image" src="print.png" width="20px" height="auto" align="right" style="padding-top:6% " name="button"
           id="button" value="Print" onclick="print();">
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img src="logo.jpg" ">
    </div>
    <div align="center"><h1>ใบเสร็จชำระเงิน</h1></div>
    <div id="company" class="clearfix">
        <div>ร้าน NuySticker Shop.</div>
        <div>เลขที่ 25 ถนน สวนผัก แขวง ตลิ่งชัน <br/> เขต ตลิ่งชัน กรุงเทพมหานคร 10170</div>
        <div>เบอร์โทร 028867366</div>
        <div>อีเมล์ <a href="mailto:company@example.com">nuysticker@gmail.com</a></div>
    </div>
    <div id="project">
        <div><span>วันที่</span> <?php echo $billing_time ?></div>
        <div><span>สั่งซื้อโดย</span> <?php echo $user_name ?> </div>
        <div><span>ที่อยู่</span> <?php echo $user_address ?></div>
        <div><span>เบอร์โทร</span> <?php echo $user_contact ?></div>
        <div><span>อีเมล์</span> <?php echo $user_email ?></div>
    </div>
</header>
<main>
    <table>
        <thead>

        </thead>
        <tbody>
        <div class="container">
            <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <th>รายการที่</th>
                    <th>ชื่อรายการ</th>
                    <th>จำนวน (ชิ้น)</th>
                    <th>ราคา (บาท/ชิ้น)</th>
                    <th>ราคารวม (บาท)</th>
                </tr>
                <?php
                $user_products_result = mysqli_query($con, $user_products_query) or die(mysqli_error($con));
                $no_of_user_products = mysqli_num_rows($user_products_result);
                $counter = 1;
                while ($row = mysqli_fetch_array($user_products_result)) {

                    ?>
                    <tr>
                        <th><?php echo $counter ?></th>
                        <th><?php echo $row['name'] ?></th>
                        <th><?php echo $row['quantity'] ?></th>
                        <th><?php echo $row['price'] ?></th>
                        <th><?php echo $row['totalprice'] ?></th>
                    </tr>
                    <?php $counter = $counter + 1;
                } ?>

                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th><br>รวมทั้งสิ้น <br></th>
                    <th><br><?php echo $sum; ?> บาท <br></th>
                </tr>
                </tbody>
            </table>
        </div>
        </tbody>
    </table>

</main>
<footer>
    Invoice was created on a computer and is valid without the signature and seal.
</footer>
</body>
</html>