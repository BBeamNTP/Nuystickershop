<?php
    require 'connection.php';
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="img/logo3.jpg" />
        <title>เข้าสู่ระบบ</title>
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
            <br><br><br>
           <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3>เข้าสู่ระบบ</h3>
                            </div>
                            <div class="panel-body">
                                <p>ลงชื่อเข้าใช้เพื่อเข้าสู่ระบบ</p>
                                <form method="post" action="login_submit.php">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" placeholder="อีเมล์" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน (อย่างน้อย 6 ตัว)" pattern=".{6,}">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="เข้าสู่ระบบ" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                            <div class="panel-footer">ยังไม่ได้เป็นสมาชิกใช่ไหม ? <a href="signup.php">สมัครสมาชิก</a></div>
                        </div>
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
