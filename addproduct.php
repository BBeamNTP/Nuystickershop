<?php
require 'connection.php';
session_start();
if (!isset($_SESSION['email'])) {
    header('location: login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="img/logo3.jpg"/>
    <title>NuySticker Shop</title>
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
            height: 400px;
            border: solid 5px #000;
            border-radius: 5px;
            margin-top: 30px;
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
    <table width="1226" border="0" align="center">
        <tr>
            <td width="68" rowspan="3">&nbsp;</td>
            <td width="509" rowspan="3">
                <div>
                    <div style="height: 500px; width: 500px">
                        <h1><b>เพิ่มรายการสินค้า</b></h1>
                        <form action="upload.php" method="post" enctype="multipart/form-data">
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
                                <input type="radio"
                                       name="types" <?php if (isset($types) && $types == "male") echo "checked"; ?>
                                       value="Picture">
                                รูปภาพ
                                <input type="radio"
                                       name="types" <?php if (isset($types) && $types == "other") echo "checked"; ?>
                                       value="DesignExample">
                                งานออกแบบเอง
                            </div>
                            <br>
                            <div class="fileinputs">
                                <input type="file" class="file" name="fileToUpload" id="fileToUpload" accept="image/*"
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
                            <br><br><br><br><br><br>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="สร้าง">
                            </div>
                        </form>
                    </div>
                </div>
            </td>
            <td width="35">&nbsp;</td>
            <td width="558" height="73">&nbsp;</td>
            <td width="34" rowspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td height="401">
                <img align="right" id="showImage" class="rounded-circle" alt="Cinque Terre" width="auto" height="auto">
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
