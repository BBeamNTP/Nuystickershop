<?php
session_start();
require 'connection.php';
if (!isset($_SESSION['email'])) {
    header('location: login.php');
}
$user_id = $_SESSION['id'];

$user_query = "select id, name, email, contact, city, address from users where id = '$user_id'";
$user_result = mysqli_query($con, $user_query) or die(mysqli_error($con));
$row = mysqli_fetch_array($user_result);

$user_name = $row['name']; //name user
$user_status = $_SESSION['status']; //status user
$user_contact = $row['contact']; //contact user
$user_city = $row['city'];//city user
$user_address = $row['address']; //address user

$billing_id = $_GET['id'];
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
            /*margin-top: 30px;*/
        }

    </style>
</head>
<body>
<div>
    <?php
    require 'header.php';

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

    <div class="container">
        <center>
            <br><br>
            <h1><b>แจ้งชำระสินค้าที่นี่</b></h1>
            <br>
            <img src="img/142845.jpg" width="450px" height="auto">
            <br><br><br><br>

        </center>
    </div>


    <table width="771" border="0" align="center">
        <tr>
            <td width="509" rowspan="3">
                <div>
                    <div style="height: auto; width: 500px">
                        <form action="paymentsuccess.php?id=<?php echo $billing_id; ?>" method="post"
                              enctype="multipart/form-data">

                            <div class="fileinputs">
                                <input type="file" class="file" name="fileToUpload" id="fileToUpload" accept="image/*"
                                       onchange="showtxt()"/>
                                <div class="fakefile">
                                    <input type="button" value="ค้นหาไฟล์" required="true"/>
                                    <span id="showtext"> เลือกรูปใบเสร็จชำระเงิน</span></div>
                            </div>
                            <br>
                            <script>
                                var filename = document.getElementById('fileToUpload');
                                filename.onchange = function () {
                                    var files = filename.files[0];
                                    var reader = new FileReader();
                                    reader.readAsDataURL(files);
                                    reader.onload = function () {
                                        var result = reader.result;
                                        document.getElementById('showImage').src = result;
                                    };
                                };

                            </script>
                            <br>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="ยืนยันการแจ้งชำระ"
                                       onclick="chkConfirm()">
                            </div>
                        </form>
                    </div>
                </div>
            </td>

        </tr>
        <tr>
            <td width="233" height="260">
                <img align="right" id="showImage" class="rounded-circle" alt="Cinque Terre" width="300px" height="auto">
            </td>
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
