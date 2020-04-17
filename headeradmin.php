<nav class="navbar navbar-inverse navabar-fixed-top">
               <div class="container">
                   <div class="navbar-header">
                       <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                       </button>
                       <a href="admin.php"><img src="img/logo3.jpg" align="left" width="50px" height="auto" border="0" style="margin-right:20px"/></a>
                       <a href="admin.php" class="navbar-brand">Nuy Sticker Shop</a>
                   </div>

                   <div class="collapse navbar-collapse" id="myNavbar">
                       <ul class="nav navbar-nav navbar-right">
                           <?php
                           if(isset($_SESSION['email'])){
                           ?>
                           <li><a href="addproduct.php"><span class="glyphicon glyphicon-plus"></span> เพิ่มรายการสินค้า </a></li>
                           <li><a href="adminbilling.php"><span class="glyphicon glyphicon-shopping-cart"></span> การชำระเงิน </a></li>
                           <li><a href="settingsadmin.php"><span class="glyphicon glyphicon-cog"></span> ตั่งค่า </a></li>
                           <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> ออกจากระบบ </a></li>
                           <?php
                           }else{
                            ?>
                            <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> สมัครสมาชิก </a></li>
                           <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> เข้าสู่ระบบ </a></li>
                           <?php
                           }
                           ?>

                       </ul>
                   </div>
               </div>
</nav>