<?php
    session_start();
    require 'connection.php';
    if(!isset($_SESSION['email'])){
        header('location:index.php');
    }else{
        $user_id=$_GET['id'];
        $sum=$_GET['sum'];

        $sql3 = "select MAX(bill_id) from users_items where user_id='$user_id' and status='Confirmed'";

        $result3=mysqli_query($con,$sql3);
        $dbarr = mysqli_fetch_row($result3) ;
        $bill_id = $dbarr[0]+1 ; // นำค่า id มาเพิ่มให้กับค่ารหัสสินค้าครั้งละ1

        $confirm_query="update users_items set status='Confirmed', bill_id='$bill_id' where user_id=$user_id and status='Added to cart' and bill_id='0'";
        $confirm_query_result=mysqli_query($con,$confirm_query) or die(mysqli_error($con));

        $dayTH = ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'];
        $monthTH = [null,'มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
        $monthTH_brev = [null,'ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];

        function thai_date_fullmonth($time){   // 19 ธันวาคม 2556
            global $dayTH,$monthTH;
            $thai_date_return = date("j",$time);
            $thai_date_return.=" ".$monthTH[date("n",$time)];
            $thai_date_return.= " ".(date("Y",$time)+543);
            return $thai_date_return;
        }
        $date = thai_date_fullmonth(time());
        $add_billing_query = "insert into billing(id, user_id, amount, status, time) values ('$bill_id', '$user_id','$sum','Not_paid','$date')";
        $add_billing_result = mysqli_query($con, $add_billing_query) or die(mysqli_error($con));

    }

?>
<script>
    window.alert("ระบบทำการสั่งซื้อเรียบร้อยกรุณาชำระเงิน");
    window.location.href = 'billing.php';
</script>
