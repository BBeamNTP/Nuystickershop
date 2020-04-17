<?php
session_start();
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
</head>
<body>
<div>
    <?php
    require 'header.php';
    ?>
    <div id="bannerImage">
        <div class="container">
            <center>
                <div id="bannerContent">
                    <p>
                    <h2>ยินดีต้อนรับสู่ NuySticker Shop.</p>
                    <a href="products.php?type=all" class="btn btn-danger">เลือกซื้อสินค้าทั้งหมด ที่นี้</a>
                </div>
            </center>
        </div>
    </div>
    <div class="container">
        <div class="row">

            <div class="col-xs-3">
                <div class="thumbnail">
                    <a href="products.php?type=Letter">
                        <img src="img/138472.jpg" alt="Letter">
                    </a>
                    <center>
                        <div class="caption">
                            <p id="autoResize">สติกเกอร์ตัวอักษร</p>
                            <!--                                        <p>Letter Sticker.</p>-->
                        </div>
                    </center>
                </div>
            </div>

            <div class="col-xs-3">
                <div class="thumbnail">
                    <a href="products.php?type=Picture">
                        <img src="img/138473.jpg" alt="Picture">
                    </a>
                    <center>
                        <div class="caption">
                            <p id="autoResize">สติกเกอร์ภาพ</p>
                            <!--                                    <p>Picture Sticker.</p>-->
                        </div>
                    </center>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="thumbnail">
                    <a href="products.php?type=DesignExample">
                        <img src="img/138474.jpg" alt="DesignExample">
                    </a>
                    <center>
                        <div class="caption">
                            <p id="autoResize">สติกเกอร์ออกแบบเอง</p>
                            <!--                                   <p>Design Sticker Example.</p>-->
                        </div>
                    </center>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="thumbnail">
                    <?php if (!isset($_SESSION['email'])) { ?>
                        <p><a href="login.php"</p>
                        <img src="img/138475.jpg" alt="Design">

                        <?php
                    } else { ?>
                        <a href="design.php">
                            <img src="img/138475.jpg" alt="Design">
                        </a>
                        <?php
                    }
                    ?>


                    <center>
                        <div class="caption">
                            <p id="autoResize">สั่งสติกเกอร์ออกแบบ</p>
                            <!--                                   <p>Design Sticker.</p>-->
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <br><br> <br><br><br><br>
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