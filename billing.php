<?php
session_start();
require 'connection.php';
if (!isset($_SESSION['email'])) {
    header('location: login.php');
}
$user_id = $_SESSION['id'];
$user_billing_query = "select * from billing where user_id='$user_id' ORDER BY time DESC";
$user_billing_result = mysqli_query($con, $user_billing_query) or die(mysqli_error($con));
$no_of_user_billing = mysqli_num_rows($user_billing_result);
$sum = 0;

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="img/logo3.jpg"/>
    <title>NuySticker Store</title>
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
        <table class="table table-bordered table-striped">
            <tbody>
            <tr>
                <th width="6%"> ลำดับที่</th>
                <th width="17%">หมายเลขรายการ</th>
                <th width="19%">วันที่ทำรายการ</th>
                <th width="13%">สถานะ</th>
                <th width="14%">ใบเสร็จ</th>
            </tr>
            <?php
            $counter = 1;
            while ($row = mysqli_fetch_array($user_billing_result)) {
                ?>
                <tr>
                    <th><?php echo $counter ?></th>
                    <th><?php echo $row['id'] ?></th>
                    <th><?php echo $row['time'] ?></th>
                    <th><?php if ($row['status'] == 'Not_paid') {
                            echo "ยังไม่ได้ชำระเงิน";
                        } else if ($row['status'] == 'Paid')  {
                            echo "ชำระเงินแล้ว";
                        } else if ($row['status'] == 'Wait')  {
                            echo "รอการตรวจสอบ";
                        } else {
                            echo "การชำระเงินผิดพลาด";
                        } ?>

                    </th>
                    <th>
                        <?php if ($row['status'] == 'Not_paid') { ?>
                            <a href="payment.php?id=<?php echo $row['id']; ?>" class=btn btn-block btn-success disabled> กรุณาชำระเงิน ชำระเงินที่นี่ </a>
                        <?php } else if ($row['status'] == 'Paid') { ?>
                            <form id="form1" name="form1" method="post" target="_blank"
                                  action="./invoice/invoice.php?id=<?php echo $row['id']; ?>">
                                <input type="submit" name="submit" id="add" value="รายละเอียดบิล" class="btn btn-info">
                            </form>
                        <?php } else if ($row['status'] == 'Wait') { ?>
                            <a href="#" class=btn btn-block btn-success disabled> รอการตรวจสอบการชำระเงิน </a>
                        <?php } else { ?>
                            <a href="#" class=btn btn-block btn-success disabled> ชำระเงินผิดพลาด </a>
                        <?php } ?>
                    </th>
                </tr>
                <?php $counter = $counter + 1;
            } ?>
            </tbody>
        </table>
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
