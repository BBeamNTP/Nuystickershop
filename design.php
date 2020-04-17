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
            height: 450px;
            border: solid 2px #000;
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
    require 'header.php';
    ?>
    <table width="1227" border="0" align="center">
        <tr>
            <td width="109" rowspan="3">&nbsp;</td>
            <td width="565" rowspan="3">
                <div>
                    <div style="height: 500px; width: 560px">
                        <h1><b>สั่งทำสติกเกอร์</b></h1>
                        <form action="detail.php" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="comment">ขนาดสติกเกอร์ / 1 รูป :</label>
                                <input type="number" class="form-control" name="width" id="width"
                                       placeholder="ขนาดความกว้าง / เซนติเมตร" required pattern=""
                                       onkeyup="myFunction() " required>
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="length" id="length"
                                       placeholder="ขนาดความยาว / เซนติเมตร" required pattern="" onkeyup="myFunction()"
                                       required>
                            </div>


                            <p id="demo1" hidden></p>
                            <p id="demo2" hidden></p>
                            <p id="demo3" hidden></p>
                            <p id="demo4"></p>
                            <div class="form-group">
                                <label for="comment">จำนวนตารางเมตร:</label>
                                <input type="number" class="form-control" name="meter" id="meter"
                                       placeholder="หน่วยตารางเมตร" maxlength="2" required pattern="[0-9]{2}"
                                       onkeyup="myFunction()">
                            </div>
                            <p id="demo5" hidden></p>
                            <p id="demo6"></p>
                            <br>
                            <script>
                                function myFunction(x) {
                                    var width = document.getElementById("width").value;
                                    var length = document.getElementById("length").value;
                                    var meter = document.getElementById("meter").value;

                                    var total = width * length;
                                    var sum = 1000 / total;
                                    var total2 = meter * sum;
                                    document.getElementById("demo1").innerHTML = width;
                                    document.getElementById("demo2").innerHTML = length;
                                    document.getElementById("demo3").innerHTML = total;
                                    document.getElementById("demo4").innerHTML = "จำนวนรูปที่ได้ / 1 ตารางเมตรคือ : " + sum + " รูป";
                                    document.getElementById("demo5").innerHTML = meter;
                                    document.getElementById("demo6").innerHTML = "จำนวนรูปที่ได้ทั้งหมด โดยประมาณคือ : " + total2 + " รูป";
                                    var total3 = x.value * meter
                                    document.getElementById("demo7").innerHTML = "จำนวนเงินที่ต้องชำระ : " + total3 + " บาท";

                                }

                                function validateForm() {
                                    var radios = document.getElementsByName("price");
                                    var formValid = false;

                                    var i = 0;
                                    while (!formValid && i < radios.length) {
                                        if (radios[i].checked) formValid = true;
                                        i++;
                                    }

                                    // if (!formValid) alert("Must check some option!");
                                    return formValid;
                                }
                            </script>


                            <div class="form-check"><b> ประเภทสติกเกอร์ : </b>&nbsp;
                                <input type="radio" id="price1"
                                       name="price" <?php if (isset($types) && $types == "female") echo "checked"; ?>
                                       value="1000" onclick="myFunction(this), validateForm()" required>
                                สะท้อนแสง 1000 บาท / 1 เมตร
                                &nbsp;
                                <input type="radio" id="price2"
                                       name="price" <?php if (isset($types) && $types == "male") echo "checked"; ?>
                                       value="800" onclick="myFunction(this), validateForm()" required>
                                ไม่สะท้อนแสง 800 บาท / 1 เมตร
                            </div>
                            <br>
                            <p id="demo7"></p>
                            <br>
                            <div class="form-group">
                                <label for="comment">รายละเอียดเพิ่มเติม:</label>
                                <textarea class="form-control" rows="3" id="comment" name="comment"></textarea>
                            </div>

                            <div class="fileinputs">
                                <input type="file" class="file" name="fileToUpload" id="fileToUpload" accept="image/*"
                                       onchange="showtxt()"/>
                                <div class="fakefile">
                                    <input type="button" value="ค้นหาไฟล์"/>
                                    <span id="showtext"> ที่อยู่ไฟล์ </span></div>
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
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="ถัดไป">
                            </div>
                        </form>
                    </div>
                </div>
            </td>
            <td width="19">&nbsp;</td>
            <td width="499" height="73">&nbsp;</td>
            <td width="13" rowspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td height="452">
                <img align="right" id="showImage" class="rounded-circle" alt="Cinque Terre" width="auto" height="auto">
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
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
