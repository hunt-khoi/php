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
	<!-- Begin page content -->
	<div class="container">
		<div class="page-header">
            <h1 class="lead">Chi tiết sách giày</h1>
	    </div>
        

	<!-- Fixed navbar -->
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
				<!-- <ul class="nav navbar-nav"> -->
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
						<form class="form-inline" action="TimKiem">
							<input class="form-control ml-auto" name="tim" placeholder="Tìm kiếm giày...">
							<button class="btn btn-success" onclick='find_shoes(tim.value)'><i class="glyphicon glyphicon-search"></i></button> 
						</form>
					</a></li>
					<li><a><i class="glyphicon glyphicon-user"></i> Chào <?php include 'KetNoi.php'; echo $_SESSION['dangnhap']; ?></a></li>
				</ul>
			</div>

		</div>
	</div>
	
    <?php
		$id=isset($_GET['id']) ? $_GET['id'] : die('LỖI: Không tìm thấy ID.');

		include 'KetNoi.php';
		try {
            $query = "SELECT MaGiay, TenGiay, GiaBan, SoLuong, MoTa, HinhAnh, MaHang, MaLoai
            FROM giay WHERE MaGiay = ? LIMIT 0,1";

			$stmt = $con->prepare( $query );

			$stmt->bindParam(1, $id);
			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
		}
		catch(PDOException $exception){
			die('LỖI: ' . $exception->getMessage());
		}
	?>

		<div class="col-sm-4">
			<img src= "hinhanh/Giay/<?php echo htmlspecialchars($HinhAnh, ENT_QUOTES); ?>" width="320px" height="320px"/>
		</div>
		<div class="col-sm-6">
		<form action="GioHang.php" method="post">
			<table>
				<tr>
					<td><h1><?php echo htmlspecialchars($TenGiay, ENT_QUOTES); ?></h1></td>
				</tr>
				<tr>
					<td>
						<?php
							$KhuyenMai = 500000;
							$GiaGiam = $GiaBan-$KhuyenMai;
							$PhanTram = ceil(($KhuyenMai/$GiaBan)*100);
							echo "<h3>Giá bán: <b>$GiaGiam đ</b> <sub>&nbsp-$PhanTram%</sub></h3>
							<h5 style='color:red'>Giá gốc: <strike>$GiaBan đ</strike></h5>";
						?>
					</td>
				</tr>
				<tr height="75">
					<td>
						<div class="form-inline">
							<input type="button" class="btn btn-primary" onClick="if(sl.value < 1) sl.value = 1; else if (sl.value > 1) sl.value -= 1;" value="-">
							<input id="sl" type="text" name="sl"  class="form-control" value="1">
							<input type="button" class="btn btn-primary" onClick="if(sl.value < <?php echo htmlspecialchars($SoLuong, ENT_QUOTES);?>) sl.value ++; 
							else if(sl.value > <?php echo htmlspecialchars($SoLuong, ENT_QUOTES);?>) sl.value = <?php echo htmlspecialchars($SoLuong, ENT_QUOTES);?>;" value="+">
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<a href="Giay.php" class="btn btn-success">Trở về danh sách giày</a>
						<input type ="submit" class="btn btn-danger" value="Thêm vào giỏ hàng" onclick="alert('Đôi giày đã thêm vào giỏ hàng !!')">
						<input type="hidden" name="idgiay" value="<?php echo $MaGiay;?>"/>
					</td>
				</tr>
			</table>
			</form>
		</div> 
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