<!DOCTYPE HTML>
<html>
<head>
	<title>WinaShoes</title>
	<link rel="stylesheet" type="text/css" href="css/home.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
	<style>
		.m-r-1em{ margin-right:1em; }
		.m-b-1em{ margin-bottom:1em; }
		.m-l-1em{ margin-left:1em; }
		.mt0{ margin-top:0; }
	</style>
</head>
<body>
	<!-- THANH ĐIỀU HƯỚNG ======================================= -->
	<div class="container">
		<div class="page-header">
			<h1>Danh sách hóa đơn</h1>
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
						<li><a href="TrangChuNV.php"> Trang chủ <i class="glyphicon glyphicon-home"></i></a></li>
						<li><a href="DangNhap.php">Đăng xuất</a></li>
						<li><a href="DanhSachGiay.php"> Giày</a></li>
						<li class="active"><a href="DanhSachHoaDon.php"> Hóa đơn</a></li>
						<li><a>
							<form class="form-inline" action="TimKiemGiayNV.php">
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

			// CÁC BIẾN PHÂN TRANG =============================================================
			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$records_per_page = 8; 
			
			// Tính toán phục vụ truy vấn trong mệnh đề LIMIT
			$from_record_num = ($records_per_page * $page) - $records_per_page;

			// HIỂN THỊ NỘI DUNG CÁC ĐÔI GIÀY VÀ PHÂN TRANG ===================================
			// lấy dữ liệu cho trang hiện tại
			$query = "SELECT SoHD, NgayLapHD, NgayGiaoHang, MaKH, TongTriGia FROM hoadon ORDER BY SoHD ASC
			LIMIT :from_record_num, :records_per_page";

			$stmt = $con->prepare($query);
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			$stmt->execute();

			$num = $stmt->rowCount();

			if($num>0){
				echo "<table class='table table-hover table-responsive table-bordered'>";
					echo "<tr>";
						echo "<th>Số hóa đơn</th>";
                        echo "<th>Ngày lập</th>";
                        echo "<th>Ngày giao</th>";
						echo "<th>Mã khách</th>";
						echo "<th>Tổng trị giá</th>";
					echo "</tr>";
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

						extract($row);
						echo "<tr>";
							echo "<td>{$SoHD}</td>";
							echo "<td>{$NgayLapHD}</td>";
                            echo "<td>{$NgayGiaoHang}</td>";
                            echo "<td>{$MaKH}</td>";
                            echo "<td>{$TongTriGia}</td>";
						echo "</tr>";
					}
				echo "</table>";

				// PHÂN TRANG ==============================================================
				$query = "SELECT COUNT(*) AS total_rows FROM hoadon";
				$stmt = $con->prepare($query);
				$stmt->execute();
				
				// lấy tổng số dòng dữ liệu
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$total_rows = $row['total_rows'];

				$page_url="DanhSachHoaDon.php?";
				include_once "PhanTrang.php";
			}

			// nếu không tìm thấy bản ghi dữ liệu nào
			else{
				echo "<div class='alert alert-danger'>Không tìm thấy sản phẩm nào.</div>";
			}
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

	<!-- jQuery (Thư viện Jquery, sự cần thiết cho Bootstrap's JavaScript) -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<!-- Thư viện Bootstrap JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</body>
</html>