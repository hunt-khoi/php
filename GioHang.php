<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>WinaShoes</title>
<link rel="stylesheet" type="text/css" href="css/home.css" />
<link rel="stylesheet" type="text/css" href="css/carousel.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>

</head>
<body>
	<div class="container">
		<div class="page-header">
            <h1 class="lead">Giỏ hàng (<?php include 'KetNoi.php'; echo isset($_SESSION['gio']) ? count($_SESSION['gio']) : 0; ?>)</h1>
	    </div>
        
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <img class="logo" src="HinhAnh/logo.png" width="126" height="47">
                </div>
                
                <div class="collapse navbar-collapse">
                    <ul class="nav nav-justified"> 
                        <li><a href="TrangChuKH.php"> Trang chủ <i class="glyphicon glyphicon-home"></i></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tài khoản<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="DangNhap.php">Đăng xuất</a></li>
                                <li><a href="DangKy.php">Đăng ký</a></li>
                            </ul>
                        </li>
                        <li><a href="Giay.php">Giày</a></li>
                        <li class="active"><a href="GioHang.php">Giỏ hàng <i class="glyphicon glyphicon-shopping-cart badge pull-right badge-pill badge-primary">
                        <?php include 'KetNoi.php'; echo isset($_SESSION['gio']) ? count($_SESSION['gio']) : 0; ?></i></a></li>
                        <li><a>
                            <form class="form-inline" action="TimKiemGiay.php">
                                <input class="form-control ml-auto" name="search" placeholder="Tìm kiếm giày...">
                                <button class="btn btn-success" onclick='find_shoes(search.value)'><i class="glyphicon glyphicon-search"></i></button> 
                            </form>
                        </a></li>
                        <li><a><i class="glyphicon glyphicon-user"></i> Chào <?php include 'KetNoi.php'; echo $_SESSION['dangnhap']; ?></a></li>
                    </ul>
                </div>

            </div>
        </div>
	
        <?php
            include 'KetNoi.php';

            if(isset($_POST['idgiay'], $_POST['sl']) && is_numeric($_POST['sl'])) {
                //$idgiay = isset($_GET['id']) ? $_GET['id'] : die('LỖI: Không tìm thấy mã giày !!');

                $idgiay = $_POST['idgiay'];
                $sl = (int) $_POST['sl'];

                $stmt = $con->prepare('SELECT * FROM giay WHERE MaGiay=?');
                $stmt->bindParam(1, $idgiay);
                $stmt->execute();

                $giay = $stmt->fetch(PDO::FETCH_ASSOC);

                if($giay && $sl>0) {
                    if(isset($_SESSION['gio']) && is_array($_SESSION['gio'])) {
                        if(array_key_exists($idgiay, $_SESSION['gio'])){
                            $_SESSION['gio'][$idgiay] += $sl;
                        }else{
                            $_SESSION['gio'][$idgiay] = $sl;
                        }
                    }else{
                        $_SESSION['gio'] = array($idgiay => $sl);
                    }
                }
            }
         
            //Xóa 
			if (isset($_GET['remove']) && isset($_SESSION['gio']) && isset($_SESSION['gio'][$_GET['remove']])) {
				unset($_SESSION['gio'][$_GET['remove']]);
			}
                
            //Cập nhật số lượng sản phẩm trong giỏ hàng
			if (isset($_POST['sua']) && isset($_SESSION['gio'])) {
				//Lặp lại thông qua dữ liệu post để cập nhật số lượng cho mỗi sản phẩm trong giỏ hàng
				foreach ($_POST as $k => $v) {
					if (strpos($k, 'soluong') !== false && is_numeric($v)) {
						$id = str_replace('soluong-', '', $k);
						$slcn = (int)$v;
						// Kiểm tra và xác nhận
						if (isset($_SESSION['gio'][$id]) && $slcn > 0) {
							$_SESSION['gio'][$id] = $slcn;
						}
					}
				}
			}

            
            //Kiểm tra biến session cho các sản phẩm trong giỏ hàng
            $giay_gio = isset($_SESSION['gio'])?$_SESSION['gio']:array();
            $giay = array();
            $tongcong = 0;

            if($giay_gio) {
                $array_to_question_marks = implode(',', array_fill(0, count($giay_gio), '?'));

                $stmt = $con->prepare('SELECT * FROM giay WHERE MaGiay IN ('. $array_to_question_marks.')');
                $stmt->execute(array_keys($giay_gio));
                $giay = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($giay as $items) {
                    $tongcong += $items['GiaBan']*$giay_gio[$items['MaGiay']];
                }
            }
        ?>



        <form method="post">
            <table class="table">    
                <tr align="center">
					<td>Giày</td>
                    <td>Tên giày</td>
					<td>Giá</td>
					<td>Số lượng</td>
					<td>Thành tiền</td>
				</tr> 
                <?php if(empty($giay)) {
                    echo "<tr>";
                        echo "<div class='alert alert-warning'>Giỏ hàng của bạn còn trống.</div>";
                    echo "</tr>";
                } else {
                        foreach($giay as $items) {
                ?>
				<tr align="center">
					<td><img src="hinhanh/Giay/<?php echo $items['HinhAnh']; ?>" width="50px" height="50px"/></td>
                    <td><b><?php echo $items["TenGiay"];?></b>
                    </td>
                    <td><?php echo $items["GiaBan"];?> đ</td>
                    <td><input type="number" name="soluong-<?=$items['MaGiay']?>" value="<?=$giay_gio[$items['MaGiay']]?>" min="1" max="<?=$items['SoLuong']?>"></td>
                    <td><?php echo $items['GiaBan']*$giay_gio[$items['MaGiay']]; ?> đ</td> 
                    <td><a href='GioHang.php?remove=<?php echo $items['MaGiay']; ?>'>Xóa </a> </td>
                </tr>
                <?php
                    }
                }
                ?>
                <tr align="center">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>Tổng cộng: </b></td>
                    <td><b><?=$tongcong?> đ</b></td>
                    <td></td>
                </tr>
                <tr align="center">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><input type="submit" class ="btn btn-primary" value="Cập nhật lại" name="sua"></td>
                    <td><a href="HienThiDonHang.php" class ="btn btn-danger" name="dat">Đặt hàng</a></td>
                    <td></td>
                </tr>
			</table>
        </form>

    </div>

    

	<div class="footer">
		<div class="container">
		<h5 class="pull-right"><a href="#">Trở lại đầu trang</a></h5>
			<p class="text-muted">
				Address: 1062A Cách Mạng Tháng Tám, Phường 4, Quận Tân Bình, TP. Hồ Chí Minh
				<br>Tel: 09.8523.5755 
				<br>Facebook: www.facebook.com/winashoes
				<br>&copy; Team PHP - 2rd Semester 5/2019</p>
		</div>
	</div>

	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<!-- jQuery (Thư viện Jquery, sự cần thiết cho Bootstrap's JavaScript) -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<!-- Thư viện Bootstrap JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script type='text/javascript'>
		// xác thực việc xóa bản ghi dữ liệu
		function find_shoes(id){
			alert(id);
			window.location.href = 'TimKiemGiay.php?search='+id;
		}
	</script>

</body>


</html>