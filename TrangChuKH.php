<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>WinaShoes</title>
<link rel="stylesheet" type="text/css" href="css/home.css" />
<link rel="stylesheet" type="text/css" href="css/carousel.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
<style>
		.table td:hover {
			background-color: GhostWhite;
		}
</style>

</head>
<body>
	<div class="container">
		<div class="page-header">
			<h1 align="center">WINA SHOES</h1>

		<!-- Carousel
		 ================================================== -->
  		<div id="myCarousel" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
					<li data-target="#myCarousel" data-slide-to="1"></li>
					<li data-target="#myCarousel" data-slide-to="2"></li>
				</ol>
				<div class="carousel-inner">
					<div class="item active">
						<img src="hinhanh/hinhnen2.jpeg" alt="First slide">
						<div class="container">
							<div class="carousel-caption">
								<h1>WinaShoes</h1>
								<p>Everywhere you want to be. We'll always go together.</p>
							</div>
						</div>
					</div>
					<div class="item">
						<img src="hinhanh/hinhnen3.jpg" alt="Second slide">
						<div class="container">
							<div class="carousel-caption">
								<h1>Let's join with us</h1>
								<p>Currently the shop is in a discount period, sign up now to have the best experience.You'll find your favorite shoes</p>
								<p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
							</div>
						</div>
					</div>
					<div class="item">
						<img src="hinhanh/hinhnen1.jpeg" alt="Third slide">
						<div class="container">
							<div class="carousel-caption">
								<h1>Just do it</h1>
								<p>Sneakers are shoes primarily designed for sports or other forms of physical exercise, but which are now also widely used for everyday wear.</p>
								<p><a class="btn btn-lg btn-primary" href="#" role="button">More sneakers</a></p>
							</div>
						</div>
					</div>
				</div>
				<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
				<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
				</div>
			</div>
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
					<li class="active"><a href="TrangChuKH.php"> Trang chủ <i class="glyphicon glyphicon-home"></i></a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Tài khoản<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="DangNhap.php">Đăng xuất</a></li>
							<li><a href="DangKy.php">Đăng ký</a></li>
						</ul>
					</li>
					<li><a href="Giay.php">Giày</a></li>
					<li><a href="GioHang.php">Giỏ hàng <i class="glyphicon glyphicon-shopping-cart badge pull-right badge-pill badge-primary">
					<?php include 'KetNoi.php'; echo isset($_SESSION['gio']) ? count($_SESSION['gio']) : 0; ?></i></a></li>
					<li><a>
						<form class="form-inline" action="TimKiemGiay.php">
							<input class="form-control ml-auto" name="search" placeholder="Tìm kiếm giày...">
							<button class="btn btn-success" onclick='find_shoes(search.value)'><i class="glyphicon glyphicon-search"></i></button> 
						</form>
					</a></li>
					<li><a><i class="glyphicon glyphicon-user"></i> Chào <?php include 'KetNoi.php'; echo $_SESSION['dangnhap']; ?> </a></li>
				</ul>
			</div>

		</div>
	</div>
	
	<div class="container">
			<p class="lead">Sản phẩm bán chạy nhất <i class="glyphicon glyphicon-fire" style="color:FireBrick"></i></p>
			<?php
			include 'KetNoi.php';

			$query = "SELECT MaGiay, TenGiay, GiaBan, HinhAnh  FROM giay ORDER BY MaGiay ASC LIMIT 0,4";

			$stmt = $con->prepare($query);
			$stmt->execute();

			$num = $stmt->rowCount();

			echo "<table class='table table-responsive'>";
					// lấy các nội dung vào bảng
					echo "<tr>";
					$KhuyenMai = 500000;
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						extract($row);
						$GiaGiam = $GiaBan-$KhuyenMai;
						$PhanTram = ceil(($KhuyenMai/$GiaBan)*100);
						echo "<td align='center' valign='top'><img src='hinhanh/Giay/$HinhAnh' width='150' height='150'>
       			 		<h4>$TenGiay</h4>
								<h3><b>$GiaGiam đ</b> <sub>&nbsp-$PhanTram%</sub></h3>
								<p><strike>$GiaBan đ</strike></p>
        				<a href='ChiTietGiayChoKH.php?id={$MaGiay}' class='btn btn-sm btn-info'>Xem Chi Tiết</a>
        			</td>";
					}
					echo "</tr>";
				echo "</table>";
		?>
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

	<!-- Subiz -->
	<script>
		(
			function(s, u, b, i, z){
			u[i]=u[i]||function(){
				u[i].t=+new Date();
				(u[i].q=u[i].q||[]).push(arguments);
			};
			z=s.createElement('script');
			var zz=s.getElementsByTagName('script')[0];
			z.async=1; z.src=b; z.id='subiz-script';
			zz.parentNode.insertBefore(z,zz);
			}
		)
		(document, window, 'https://widgetv4.subiz.com/static/js/app.js', 'subiz');
		subiz('setAccount', 'acqiqjjkkkeqfqrfvuxd');
	</script>
	<!-- End Subiz -->

</body>


</html>