<?php
    session_start();
    require 'connection.php';
    if(!isset($_SESSION['email'])){
        header('location:index.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="img/logo3.jpg" />
        <title>Projectworlds Store</title>
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
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-xs-4 col-xs-offset-4">
                        <h1>เปลี่ยนรหัสผ่าน</h1>
                        <form method="post" action="setting_script.php">
                            <div class="form-group">
                                <input type="password" class="form-control" name="oldPassword" placeholder="รหัสผ่านเก่า">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="newPassword" placeholder="รหัสผ่านใหม่">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="retype" placeholder="รหัสผ่านใหม่ อีกครั้ง">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="ยืนยัน">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <br><br><br><br><br>
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
