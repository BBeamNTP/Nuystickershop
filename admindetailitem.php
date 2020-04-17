<?php
session_start();
require 'connection.php';
if (!isset($_SESSION['email'])) {
    header('location: login.php');
}
$user_id = $_GET['user_id'];
$billing_id = $_GET['id'];
$user_query = "select id, name, email, contact, city, address from users where id = '$user_id'";
$user_result = mysqli_query($con, $user_query) or die(mysqli_error($con));
$row = mysqli_fetch_array($user_result);

$user_name = $row['name']; //name user
$user_status = $_SESSION['status']; //status user
$user_contact = $row['contact']; //contact user
$user_city = $row['city'];//city user
$user_address = $row['address']; //address user

$user_products_query = "select * from users_items ut inner join items it on it.id=ut.item_id where ut.user_id='$user_id' and ut.bill_id = '$billing_id'";
$user_products_result = mysqli_query($con, $user_products_query) or die(mysqli_error($con));
$no_of_user_products = mysqli_num_rows($user_products_result);
$sum = 0;
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
<html>
<head>
    <link rel="shortcut icon" href="img/logo3.jpg"/>
    <title>Projectworlds Store</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
    <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <style>
        div.fileinputs {
            position: relative;
        }

        div.fakefile {
            position: absolute;
            top: 0px;
            left: 0px;
            z-index: 1;
        }

        input.file {
            position: relative;
            text-align: right;
            -moz-opacity: 0;
            filter: alpha(opacity:0);
            opacity: 0;
            z-index: 2;
        }

        #showImage {
            display: none;
        }

        #showImage[src] {
            display: block;
            height: auto;
            /*border: solid 5px #000;*/
            /*border-radius: 5px;*/
            /*margin-top: 5px;*/
        }
    </style>
</head>
<body>
<div>
    <?php
    require 'headeradmin.php';
    ?>
    <br>
    <div class="container" align="center">
        <form action="updateuser.php?id=<?php echo $billing_id ?>" method="post">
            <br><br>
            <table width="1001" border="0">
                <tr>
                    <td><h1>ข้อมูลผู้ใช้</h1></td>
                    <td>&nbsp;</td>
                    <td width="20">&nbsp;</td>
                    <td><h1>แก้ไขข้อมูล</h1></td>
                </tr>
                <tr>
                    <td width="173"><span class="card-text">ชื่อผู้ทำรายการ : </span></td>
                    <td width="362"><span class="card-text"><?php echo $user_name ?></span></td>
                    <td>&nbsp;</td>
                    <td width="428"><input type="text" class="form-control" name="name" id="name"
                                           value="<?php echo $user_name ?>" required></td>
                </tr>
                <tr>
                    <td><span class="card-text">เบอร์ติดต่อ : </span></td>
                    <td><span class="card-text"><?php echo $user_contact ?></span></td>
                    <td>&nbsp;</td>
                    <td><input type="text" class="form-control" name="contact" id="contact"
                               value="<?php echo $user_contact ?>" required pattern="[0-9].{9,10}" minlength="9"
                               maxlength="10"></td>
                </tr>
                <tr>
                    <td><span class="card-text">ประเทศ :</span></td>
                    <td><span class="card-text"><?php echo $user_city ?></span></td>
                    <td>&nbsp;</td>
                    <td><input type="text" class="form-control" name="city" id="city" value="<?php echo $user_city ?>"
                               required="true"></td>
                </tr>
                <tr>
                    <td><span class="card-text">ที่อยู่ : </span></td>
                    <td><span class="card-text"><?php echo $user_address ?></span></td>
                    <td>&nbsp;</td>
                    <td><textarea class="form-control" rows="5" name="address" id="address"
                                  required="true"><?php echo $user_address ?></textarea></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right"><br>
                        <button type="submit" class="btn btn-primary">ยืนยันแก้ไขข้อมูล</button>
                    </td>
                </tr>
            </table>
            <br><br>
        </form>
    </div>
    <div class="container">
        <table class="table table-bordered table-striped">
            <tbody>
            <label><h4> บิลเลขที่ <?php echo $billing_id ?> รายการของคุณมีดังนี้ </h4></label>
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
                <th><h3>รวมทั้งสิ้น</h3></th>
                <th><h3><?php echo $sum; ?> บาท </h3></th>
            </tr>
            </tbody>
        </table>
    </div>
    <script>
        function showtxt() {
            var fartxt = document.getElementById('fileToUpload').value;
            document.getElementById('showtext').innerHTML = fartxt;
        }
    </script>
    <?php
    $user_id = $_SESSION['id'];
    $billing_id = $_GET['id'];
    $user_products_query = "select * from billing bl inner join payment pm on pm.bill_id=bl.id where bl.id='$billing_id'";
    $user_products_result = mysqli_query($con, $user_products_query) or die(mysqli_error($con));
    $row = mysqli_fetch_array($user_products_result);
    $status = $row['status'];
    ?>
    <table width="1226" border="0" align="center">
        <tr>
            <td width="62" rowspan="3">&nbsp;</td>
            <td width="515" rowspan="3">
                <div>
                    <div style="height: 500px; width: 500px">
                        <h1><b>ตรวจสอบการชำระเงิน</b></h1>
                        <form action="updatedetailpay.php?id=<?php echo $billing_id ?>" method="post"
                              enctype="multipart/form-data">
                            <h4><p> ผู้สั่งซื้อ : <?php echo $row['user_id']; ?></p></h4>
                            <h4><p> หมายเลขคำสั่งซื้อ : <?php echo $row['bill_id']; ?></p></h4>
                            <h4><p> จำนวนเงินที่ต้องชำระ : <?php echo $row['amount']; ?></p></h4>
                            <p>&nbsp; </p>
                            <div class="form-check">
                                <h4><p>สถานะ :&nbsp; </p></h4>
                                <p>
                                    <input type="radio"
                                           name="status" <?php if (isset($status) && $status == "Not_paid") echo "checked"; ?>
                                           value="Not_paid" checked>
                                    ยังไม่ได้ชำระเงิน
                                    &nbsp; </p>
                                <p>
                                    <input type="radio"
                                           name="status" <?php if (isset($status) && $status == "Paid") echo "checked"; ?>
                                           value="Paid">
                                    ชำระเงินแล้ว
                                    &nbsp; </p>
                                <p>
                                    <input type="radio"
                                           name="status" <?php if (isset($status) && $status == "Wait") echo "checked"; ?>
                                           value="Wait">
                                    รอการตรวจสอบ
                                    &nbsp; </p>
                                <p>
                                    <input type="radio"
                                           name="status" <?php if (isset($status) && $status == "Fail") echo "checked"; ?>
                                           value="Fail">
                                    การชำระเงินผิดพลาด
                                    &nbsp;</p>
                            </div>
                            <br>

                            <div class="form-group">

                                <input type="submit" class="btn btn-primary" value="ยืนยัน">
                            </div>
                        </form>
                    </div>
                </div>
            </td>
            <td width="95">&nbsp;</td>
            <td width="415" height="104">&nbsp;</td>
            <td width="117" rowspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td height="302" class="text-center">
                <h1> สลิปการชำระเงินจากลูกค้า </h1>
                <?php
                echo $images = $row['image'];
                if (($images == "") && ($images == null)) { ?>
                    <h3><b>ยังไม่มีสลิกชำระเงินจากลูกค้า</b></h3>
                <?php } else { ?>
                    <img style="width: 400px" src="<?php echo $row['image']; ?>" align="right" id="showImage"
                         class="rounded-circle"
                         alt="Cinque Terre" width="auto" height="400">
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <br><br><br><br><br><br>
    <footer class="footer">
        <div class="container">
            <center>
                <p>Copyright &copy <a href="https://projectworlds.in">Projectworlds</a> Store. All Rights Reserved.</p>
                <p>This website is developed by Yugesh Verma</p>
            </center>
        </div>
    </footer>
</div>
</body>
</html>
