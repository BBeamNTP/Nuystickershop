<?php
session_start();
require 'check_if_added.php';
require 'connection.php';
$perpage = 12;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$type = $_GET['type'];
if ($type == "Letter") {
    $start = ($page - 1) * $perpage;
    $sql = "select * from items WHERE types ='Letter'limit {$start} , {$perpage} ";
    $result = mysqli_query($con, $sql);
    $sql2 = "select * from items WHERE types ='Letter'";
    $query2 = mysqli_query($con, $sql2);
    $total_record = mysqli_num_rows($query2);
    $total_page = ceil($total_record / $perpage);
} elseif ($type == "Picture") {
    $start = ($page - 1) * $perpage;
    $sql = "select * from items WHERE types ='Picture'limit {$start} , {$perpage} ";
    $result = mysqli_query($con, $sql);
    $sql2 = "select * from items WHERE types ='Picture'";
    $query2 = mysqli_query($con, $sql2);
    $total_record = mysqli_num_rows($query2);
    $total_page = ceil($total_record / $perpage);

} elseif ($type == "DesignExample") {
    $start = ($page - 1) * $perpage;
    $sql = "select * from items WHERE types ='DesignExample' limit {$start} , {$perpage} ";
    $result = mysqli_query($con, $sql);
    $sql2 = "select * from items WHERE types ='DesignExample'";
    $query2 = mysqli_query($con, $sql2);
    $total_record = mysqli_num_rows($query2);
    $total_page = ceil($total_record / $perpage);
} else {
    $start = ($page - 1) * $perpage;
    $sql = "select * from items WHERE types !='Design01' and types !='Design02' limit {$start} , {$perpage} ";
    $result = mysqli_query($con, $sql);
    $sql2 = "select * from items ";
    $query2 = mysqli_query($con, $sql2);
    $total_record = mysqli_num_rows($query2);
    $total_page = ceil($total_record / $perpage);

}
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
    <script>
        function validateForm() {
            var x = document.forms["form1"]["num1"].value;
            console.log(x)
            if (x == "") {
                alert("Name must be filled out");
                return false;
            }
        }
    </script>
</head>
<body>
<div>
    <?php
    require 'header.php';
    $result = mysqli_query($con, $sql);
    ?>
    <div class="container">
        <br>
        <h3>สินค้า<?php if ($type == 'Letter') {
                echo "ประเภทตัวอักษร";
            } elseif ($type == 'Picture') {
                echo "ประเภทรูป";
            } elseif ($type == 'DesignExample') {
                echo "ประเภทออกแบบ";
            } else {
                echo "ไม่มีประเภท";
            }
            ?></php></h3>
    </div>
    <br><br>
    <div class="container">
        <div class="row">
            <?php
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <div class="col-md-3 col-sm-6">
                    <div class="thumbnail">
                        <a href="cart.php">
                            <img src="<?php echo $row['image']; ?>" class="img-responsive">
                        </a>
                        <center>
                            <div class="caption">
                                <h3><?php echo $row['name']; ?></h3>
                                <p> <h4 class="text-info">ราคา : <?php echo $row['price']; ?> บาท/ชิ้น </p>
                                <form id="form1" name="form1" method="post"
                                      action="cart_add.php?id=<?php echo $row['id']; ?>&type=<?php echo $type; ?>">
                                    <p><input type="number" name="num1" id="num1" pattern="[0-9]" class="caption"
                                              value="1"/></p>
                                    <?php if (!isset($_SESSION['email'])) { ?>
                                        <p><a href="login.php" role="button" class="btn btn-primary btn-block">สินค้าทั้งหมดที่นี่
                                                เลย</a></p>
                                        <?php
                                    } else {
                                        if (check_if_added_to_cart($row['id'])) {
                                            echo '<a href="#" class=btn btn-block btn-success disabled> เพิ่มลงตระกร้าสินค้าแล้ว </a>';
                                        } else {
                                            ?>
                                            <input type="submit" name="submit" id="add" value="เพิ่มลงตระกร้าสินค้า"
                                                   class="btn btn-block btn-primary">
                                            <?php
                                        }
                                    }
                                    ?>
                                </form>
                            </div>
                        </center>
                    </div>
                </div>

                <?php

            }
            ?>
        </div>
    </div>

    <div class="container" align="center">

        <nav>
            <ul class="pagination">
                <li>
                    <a href="./products.php?page=1" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                    <li><a href="./products.php?page=<?php echo $i; ?>&type=<?php echo $type; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
                <li>
                    <a href="./products.php?page=<?php echo $total_page; ?>&type=<?php echo $type; ?>"
                       aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

    </div>


    <br><br><br><br><br><br><br><br>
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
