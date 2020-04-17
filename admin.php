<?php
session_start();
require 'connection.php';
if (!isset($_SESSION['email'])) {
    header('location: login.php');
}
$user_id = $_SESSION['id'];
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
        <form id="form" method="post" action="">
            <label class="checkbox-inline">ประเภท สติกเกอร์ : </label>
            <label class="checkbox-inline"> <input type="checkbox" name="Letter"
                                                   class="checkbox" <?= (isset($_POST['Letter']) ? ' checked' : '') ?>/>
                ประเภทตัวอักษร<br></label>
            <label class="checkbox-inline"> <input type="checkbox" name="Picture"
                                                   class="checkbox" <?= (isset($_POST['Picture']) ? ' checked' : '') ?>/>
                ประเภทรูป<br></label>
            <label class="checkbox-inline"> <input type="checkbox" name="DesignExample"
                                                   class="checkbox" <?= (isset($_POST['DesignExample']) ? ' checked' : '') ?>/>
                ประเภทตัวอย่างออกแบบ<br></label>
            <label class="checkbox-inline"> <input type="checkbox" name="Design01"
                                                   class="checkbox" <?= (isset($_POST['Design01']) ? ' checked' : '') ?>/>
                ประเภทออกแบบสะท้อนแสง<br></label>
            <label class="checkbox-inline"> <input type="checkbox" name="Design02"
                                                   class="checkbox" <?= (isset($_POST['Design02']) ? ' checked' : '') ?>/>
                ประเภทออกแบบไม่สะท้อนแสง<br></label>
        </form>
        <script type="text/javascript">
            $(function () {
                $('.checkbox').on('change', function () {
                    $('#form').submit();
                });
            });
        </script>
        <?php
        if (isset($_POST["Letter"])) {
            $arguments[] = "types = 'Letter'";
        }
        if (isset($_POST["Picture"])) {
            $arguments[] = "types = 'Picture'";
        }
        if (isset($_POST["DesignExample"])) {
            $arguments[] = "types = 'DesignExample'";
        }
        if (isset($_POST["Design01"])) {
            $arguments[] = "types = 'Design01'";
        }
        if (isset($_POST["Design02"])) {
            $arguments[] = "types = 'Design02'";
        }
        if (!empty($arguments)) {
            $str = implode(' or ', $arguments);
            $user_products_query = "select * from items where " . $str . " ORDER BY id asc";
            $user_products_result = mysqli_query($con, $user_products_query) or die(mysqli_error($con));
            $no_of_user_products = mysqli_num_rows($user_products_result);
        } else {
            //ถ้าไม่ติ๊ก checkbox จะ Query ทั้งหมด
            $user_products_query = "select * from items";
            $user_products_result = mysqli_query($con, $user_products_query) or die(mysqli_error($con));
            $no_of_user_products = mysqli_num_rows($user_products_result);
        }
        ?>
        <table width="107%" class="table table-dark">
            <tbody>
            <tr class="table-danger">
                <br>
                <th width="10%" height="52"><h4><b>รหัสสินค้า</th>
                <th width="20%"><h4><b>ประเภท</th>
                <th width="17%"><h4><b>ชื่อสินค้า</th>
                <th width="18%"><h4><b>ราคา</th>
                <th width="23%"><h4><b>รูปเดิม</th>
                <th width="9%"></th>
            </tr>
            <?php
            $user_products_result = mysqli_query($con, $user_products_query) or die(mysqli_error($con));
            $no_of_user_products = mysqli_num_rows($user_products_result);
            $counter = 1;
            while ($row = mysqli_fetch_array($user_products_result)) {
                $type = $row['types'];
                ?>
                <tr>
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        <th><h4><b><?php echo $row['id'] ?></th>
                        <th><?php if ($type == 'Letter') {
                                echo "ประเภทตัวอักษร";
                            } elseif ($type == 'Picture') {
                                echo "ประเภทรูป";
                            } elseif ($type == 'DesignExample') {
                                echo "ประเภทตัวอย่างออกแบบ";
                            } elseif ($type == 'Design01') {
                                echo "ประเภทออกแบบสะท้อนแสง";
                            } elseif ($type == 'Design02') {
                                echo "ประเภทออกแบบไม่สะท้อนแสง";
                            } else {
                                echo "ไม่มีประเภท";
                            }
                            ?>
                            <h5>
                                <div class="form-check" style="margin-top: 30px"></div>
                            </h5>
                        </th>
                        <th><b><?php echo $row['name'] ?></th>
                        <th><b><?php echo $row['price'] . ' บาท' ?></th>
                        <th><img src="<?php echo $row['image'] ?>" width="200px" height="auto" border="0"/></th>
                        <th>
                            <script language="JavaScript">
                                function chkConfirm() {
                                    if (confirm('คุณต้องการลบ ใช่ หรือ ไม่') == true) {
                                        alert('ลบเรียบร้อยแล้ว');
                                        window.location.href = 'deleteproduct.php?id=<?php echo $row['id'] ?>';
                                    }
                                }
                                function upDate() {
                                    if (confirm('คุณต้องการลบ ใช่ หรือ ไม่') == true) {
                                        // alert('ลบเรียบร้อยแล้ว');
                                        window.location.href = 'updateproduct.php?id=<?php echo $row['id'] ?>';
                                    }
                                }
                            </script>
                            <input type="button" class="btn btn-danger" style="margin-bottom: 10px" name="btnConfirm"
                                   value="ลบรายการ"
                                   OnClick="chkConfirm()">
                            <input type="button" class="btn btn-warning" name="btnConfirm" value="ยืนยันแก้ไข"
                                   onclick="window.location.href='updateproduct.php?id=<?php echo $row['id'] ?>'">
                        </th>
                    </form>
                </tr>
                <?php $counter = $counter + 1;
            } ?>
            </tbody>
        </table>
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
