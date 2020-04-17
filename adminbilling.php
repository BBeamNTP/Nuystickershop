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
</head>
<body>
<div>
    <?php
    require 'headeradmin.php';
    ?>
    <div class="container">
        <form id="form" method="post" action="">
            <br>
            <label class="checkbox-inline">ประเภทสถานะ : </label>
            <label class="checkbox-inline"> <input type="checkbox" name="Not_paid"
                                                   class="checkbox" <?= (isset($_POST['Not_paid']) ? ' checked' : '') ?>/>
                ยังไม่ได้ชำระเงิน<br></label>
            <label class="checkbox-inline"> <input type="checkbox" name="Paid"
                                                   class="checkbox" <?= (isset($_POST['Paid']) ? ' checked' : '') ?>/>
                ชำระเงินแล้ว<br></label>
            <label class="checkbox-inline"> <input type="checkbox" name="Wait"
                                                   class="checkbox" <?= (isset($_POST['Wait']) ? ' checked' : '') ?>/>
                รอการตรวจสอบ<br></label>
            <label class="checkbox-inline"> <input type="checkbox" name="Fail"
                                                   class="checkbox" <?= (isset($_POST['Fail']) ? ' checked' : '') ?>/>
                การชำระเงินผิดพลาด<br></label>

        </form>
        <script type="text/javascript">
            $(function () {
                $('.checkbox').on('change', function () {
                    $('#form').submit();
                });
            });
        </script>
        <?php
        if (isset($_POST["Not_paid"])) {
            $arguments[] = "status = 'Not_paid'";
        }
        if (isset($_POST["Paid"])) {
            $arguments[] = "status = 'Paid'";
        }
        if (isset($_POST["Wait"])) {
            $arguments[] = "status = 'Wait'";
        }
        if (isset($_POST["Fail"])) {
            $arguments[] = "status = 'Fail'";
        }
        if (!empty($arguments)) {
            $str = implode(' or ', $arguments);
            $user_products_query = "select * from billing where " . $str . " ORDER BY time DESC";
            $user_products_result = mysqli_query($con, $user_products_query) or die(mysqli_error($con));
        } else {
            //ถ้าไม่ติ๊ก checkbox จะ Query ทั้งหมด
            $user_products_query = "select * from billing ORDER BY time DESC";
            $user_products_result = mysqli_query($con, $user_products_query) or die(mysqli_error($con));
        }
        ?>
    </div>
    <br>
    <div class="container">
        <table class="table table-bordered table-striped">
            <tbody>
            <tr>
                <th width="11%"> ลำดับที่</th>
                <th width="18%">หมายเลขรายการ</th>
                <th width="22%">วันที่ทำรายการ</th>
                <th width="29%">สถานะ</th>
                <th width="20%">รายละเอียด</th>
            </tr>
            <?php
            $counter = 1;
            while ($row = mysqli_fetch_array($user_products_result)) {
                ?>
                <tr>
                    <th><?php echo $counter ?></th>
                    <th><?php echo $row['id'] ?></th>
                    <th><?php echo $row['time'] ?></th>
                    <th><?php if ($row['status'] == 'Not_paid') {
                            echo "ยังไม่ได้ชำระเงิน";
                        } else if ($row['status'] == 'Paid') {
                            echo "ชำระเงินแล้ว";
                        } else if ($row['status'] == 'Wait') {
                            echo "รอการตรวจสอบ";
                        } else {
                            echo "การชำระเงินผิดพลาด";
                        } ?>

                    </th>
                    <th>
                        <form id="form1" name="form1" method="post"
                              action="admindetailitem.php?id=<?php echo $row['id']; ?>&user_id=<?php echo $row['user_id']; ?>">
                            <input type="submit" name="submit" id="add" value="ตรวจสอบลายละเอียด" class="btn btn-info">
                        </form>

                    </th>
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
