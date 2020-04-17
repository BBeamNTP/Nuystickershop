<?php
session_start();
require 'connection.php';
if (!isset($_SESSION['email'])) {
    header('location: login.php');
}
$user_id = $_SESSION['id'];
$item_id = $_GET['id'];
$user_products_query = "select * from items where id = '$item_id'";
$user_products_result = mysqli_query($con, $user_products_query) or die(mysqli_error($con));
$no_of_user_products = mysqli_num_rows($user_products_result);


?>
<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="img/logo3.jpg"/>
    <title>Projectworlds Store</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- latest compiled and minified CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
    <!-- jquery library -->
    <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <!-- Latest compiled and minified javascript -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <!-- External CSS -->
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
    <script>
        function showtxt() {
            var fartxt = document.getElementById('fileToUpload').value;
            document.getElementById('showtext').innerHTML = fartxt;
        }
    </script>
</head>
<body>
<div>
    <?php
    require 'headeradmin.php';
    ?>
    <br>
    <div class="container">

        <table width="100%" height="231" class="table table-dark">
            <tbody>
            <tr class="table-danger">
                <br>
                <th width="13%" height="52"><h4><b>รหัสสินค้า</th>
                <th width="16%"><h4><b>ประเภท</th>
                <th width="24%"><h4><b>ชื่อสินค้า</th>
                <th width="18%"><h4><b>ราคา</th>
                <th width="29%"><h4><b>รูปเดิม</th>
              </tr>
            <?php
            $counter = 1;
            while ($row = mysqli_fetch_array($user_products_result)) {
                $type = $row['types'];
                ?>
                <tr>
                    <th><h4><?php echo $row['id'] ?></th>
                    <th rowspan="3"><h4><?php if ($type == 'Letter') {
                                echo "ประเภทตัวอักษร";
                            } elseif ($type == 'Picture') {
                                echo "ประเภทรูป";
                            } elseif ($type == 'DesignExample') {
                                echo "ประเภทออกแบบ";
                            } else {
                                echo "ไม่มีประเภท";
                            }
                            ?>
                        </h4></th>
                    <th rowspan="3"><h4><?php echo $row['name'] ?></h4></th>
                    <th rowspan="3"><h4><?php echo $row['price'] . ' บาท' ?></h4></th>
                    <th height="150"><h4><img src="<?php echo $row['image'] ?>" alt="" width="300px" height="auto"
                                              border="0"/></h4></th>
                </tr>
                <?php $counter = $counter + 1;
            } ?>
        </table>

    <!------------------------------------------------->
        <table width="1189" border="0" align="center">
            <tr>
                <td width="0" rowspan="3">&nbsp;</td>
                <td width="509" rowspan="3">
                    <div>
                        <div style="height: 400px; width: 500px">
                            <h1><b>แก้ไขสินค้า</b></h1>
                            <form action="update.php?id=<?php echo $item_id ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="ชื่อสินค้า"
                                           required>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="price" id="price"
                                           placeholder="ราคาสินค้า / ชิ้น เช่น 100" required pattern="">
                                </div>
                                <div class="form-check"> ประเภท :&nbsp;
                                    <input type="radio"
                                           name="types" <?php if (isset($types) && $types == "female") echo "checked"; ?>
                                           value="Letter" checked>
                                    ตัวหนังสือ
                                    &nbsp;
                                    <input type="radio"
                                           name="types" <?php if (isset($types) && $types == "male") echo "checked"; ?>
                                           value="Picture">
                                    รูปภาพ
                                    &nbsp;
                                    <input type="radio"
                                           name="types" <?php if (isset($types) && $types == "other") echo "checked"; ?>
                                           value="DesignExample">
                                    งานออกแบบเอง
                                    &nbsp;
                                </div>
                                <br>
                                <div class="fileinputs">
                                    <input type="file" class="file" name="fileToUpload" id="fileToUpload"  accept="image/*"
                                           onchange="showtxt()"/>
                                    <div class="fakefile">
                                        <input type="button" value="ค้นหาไฟล์"/>
                                        <span id="showtext"> ที่อยู่ไฟล์ </span></div>
                                </div>
                                <br>
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
                                <br>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="ยืนยันการแก้ไข">
                                </div>
                            </form>
                        </div>
                    </div>
                </td>
                <td width="103">&nbsp;</td>
                <td width="424" height="73" align="center"><h4><b>รูปใหม่</b></h4></td>
                <td width="131" rowspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td height="260">
                    <img align="right" id="showImage" class="rounded-circle" alt="Cinque Terre" width="400px" height="auto">
                </td>
            </tr>
            <tr>
                <td height="22">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>

    </div>


</div>
<br><br><br><br><br><br><br><br><br><br>
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
