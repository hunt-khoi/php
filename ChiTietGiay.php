<!DOCTYPE HTML>
<html>
<head><title>WinaShoes</title>
	<link rel="stylesheet" type="text/css" href="css/home.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<body>
	<div class="container">
		<div class="page-header">
			<h1>Thông tin chi tiết giày</h1>
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
				<!-- <ul class="nav navbar-nav"> -->
					<li class="active"><a href="TrangChuNV.php"> Trang chủ <i class="glyphicon glyphicon-home"></i></a></li>
					<li><a href="DangNhap.php">Đăng xuất</a></li>
                    <li class="active"><a href="DanhSachGiay.php"> Giày</a></li>
					<li><a href="DanhSachHoaDon.php"> Hóa đơn</a></li>
                    <li><a>
						<form class="form-inline">
							<input class="form-control ml-auto" placeholder="Tìm kiếm giày...">
							<button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i></button>
						</form>
					</a></li>
					<li><a><i class="glyphicon glyphicon-user"></i> Chào  <?php include 'KetNoi.php'; echo $_SESSION['dangnhap']; ?></a></li>
				</ul>
			</div>

		</div>
	</div>

	<?php
		// lấy giá trị của tham số 'id' và 'page'trên URL từ index.php chuyển qua (thông qua '?')
		// isset() là hàm trong PHP cho phép kiểm tra giá trị là có hoặc không
		$id = isset($_GET['id']) ? $_GET['id'] : die('LỖI: Không tìm thấy ID.');
		$page = $_GET['page'];

		include 'KetNoi.php';
		// đọc dữ liệu của bản ghi hiện tại
		try {
			// chuẩn bị truy vấn SELECT
            $query = "SELECT MaGiay, TenGiay, GiaBan, SoLuong, MoTa, HinhAnh, MaHang, MaLoai
            FROM giay WHERE MaGiay = ? LIMIT 0,1";

			$stmt = $con->prepare( $query );

			$stmt->bindParam(1, $id);
			$stmt->execute();
			// lưu bản ghi dữ liệu lấy được vào một biến ‘row’ vì nó chỉ là 1 dòng DL
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
		}
		catch(PDOException $exception){
			die('LỖI: ' . $exception->getMessage());
		}
	?>

	<div class="col-sm-3">
		<img src= "hinhanh/Giay/<?php echo htmlspecialchars($HinhAnh, ENT_QUOTES); ?>" width="280px" height="280px"  align="left"/>
	</div>
	<div class="col-sm-9">
		<table class='table table-hover table-responsive table-bordered'>
			<tr>
				<td>Mã giày</td>
				<td><?php echo htmlspecialchars($MaGiay, ENT_QUOTES); ?></td>
			</tr>
			<tr>
				<td>Tên giày</td>
				<td><?php echo htmlspecialchars($TenGiay, ENT_QUOTES); ?></td>
			</tr>
			<tr>
				<td>Giá bán</td>
				<td><?php echo htmlspecialchars($GiaBan, ENT_QUOTES); ?></td>
			</tr>
			<tr>
				<td>Số lượng</td>
				<td><?php echo htmlspecialchars($SoLuong, ENT_QUOTES); ?></td>
			</tr>
			<tr>
				<td>Mô tả</td>
				<td><?php echo htmlspecialchars($MoTa, ENT_QUOTES); ?></td>
			</tr>
			<tr>
				<td>Mã hãng</td>
				<td><?php echo htmlspecialchars($MaHang, ENT_QUOTES); ?></td>
			</tr>
			<tr>
				<td>Mã loại</td>
				<td><?php echo htmlspecialchars($MaLoai, ENT_QUOTES); ?></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
				<a href='DanhSachGiay.php' class='btn btn-danger'>Quay lại danh sách giày</a>
				</td>
			</tr>
		</table>
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
    
	<!-- jQuery (Thư viện JQuery, sự cần thiết cho Bootstrap JavaScript) -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<!-- Thư viện Bootstrap JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>