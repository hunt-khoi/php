<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>WinaShoes</title>
<link rel="stylesheet" type="text/css" href="css/home.css" />
<link rel="stylesheet" type="text/css" href="css/carousel.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
<style>
	.col-sm-4{
		text-align:center;
	}
</style>

</head>
<body>
	<div class="container">
		<div class="page-header">
			<h1 align="center">WINA SHOES</h1>
		</div>
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
					<li class="active"><a href="Giay.php">Giày</a></li>
					<li><a href="GioHang.php">Giỏ hàng <i class="glyphicon glyphicon-shopping-cart badge pull-right badge-pill badge-primary"> 
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

    <div class="container">
			<?php
			include 'KetNoi.php';

			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$records_per_page = 6; 
			$from_record_num = ($records_per_page * $page) - $records_per_page;

			$query = "SELECT MaGiay, TenGiay, GiaBan, HinhAnh FROM giay ORDER BY MaGiay ASC
			LIMIT $from_record_num, $records_per_page ";
			$stmt = $con->prepare($query);
			$stmt->execute();			
		?>

		<div class="container">
			<div class="row">
			<?php $KhuyenMai = 500000;
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
							extract($row);
							$GiaGiam = $GiaBan-$KhuyenMai;
							$PhanTram = ceil(($KhuyenMai/$GiaBan)*100); ?>
							
								<div class="col-sm-4 padding-right padding-">
										<?php echo "<img src='hinhanh/Giay/$HinhAnh' width='320' height='320'>
										<h4 algin='center'>$TenGiay</h4>
										<h3><b>$GiaGiam đ</b> <sub>&nbsp-$PhanTram%</sub></h3>
										<p><strike>$GiaBan đ</strike></p>
										<a href='ChiTietGiayChoKH.php?id={$MaGiay}' class='btn btn-sm btn-info'>Xem Chi Tiết</a>"; ?>
										<p></p>
								</div>
							
			<?php }
				echo "<br";
				$query = "SELECT COUNT(*) AS total_rows FROM giay";
				$stmt = $con->prepare($query);
				$stmt->execute();
				
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$total_rows = $row['total_rows'];

				$page_url="Giay.php?";
				include_once "PhanTrang.php";
			?>
			</div>
		</div>
		


  </div>


	<div class="footer">
		<div class="container">
		<h5 class="pull-right"><a href="#">Trở lại đầu trang</a></h5>
			<p class="text-muted">
				Address: 1062A Cách Mạng Tháng Tám, Phường 4, Quận Tân Bình, TP.Hồ Chí Minh
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
		function find_shoes(id){
			alert(id);
			window.location.href = 'TimKiemGiay.php?search='+id;
		}
	</script>

</body>


</html>