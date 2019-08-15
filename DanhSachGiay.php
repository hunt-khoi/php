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
			<h1>Danh sách giày</h1>
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
						<li class="active"><a href="DanhSachGiay.php"> Giày</a></li>
						<li><a href="DanhSachHoaDon.php"> Hóa đơn</a></li>
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

			// hiển thị thông báo alert đã xóa bản ghi thành công sẽ đặt tại đây
			$action = isset($_GET['action']) ? $_GET['action'] : "";
			// nếu nó được điều hướng từ trang delete.php
			if($action=='deleted'){
				echo "<div class='alert alert-success'>Sản phẩm đã được xoá.</div>";
			}

			// CÁC BIẾN PHÂN TRANG =============================================================
			// $page là trang hiện tại, nếu không thiết lập, mặc định là trang 1
			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$records_per_page = 5; //Số sản phẩm xuất hiện mỗi trang
			
			// Tính toán phục vụ truy vấn trong mệnh đề LIMIT
			$from_record_num = ($records_per_page * $page) - $records_per_page;

			// HIỂN THỊ NỘI DUNG CÁC ĐÔI GIÀY VÀ PHÂN TRANG ===================================
			// lấy dữ liệu cho trang hiện tại
			$query = "SELECT MaGiay, TenGiay, GiaBan, SoLuong FROM giay ORDER BY MaGiay ASC
			LIMIT :from_record_num, :records_per_page";

			$stmt = $con->prepare($query);
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			$stmt->execute();

			$num = $stmt->rowCount();
			echo "<a href='ThemGiay.php' class='btn btn-primary m-b-1em'>Thêm đôi giày mới</a>";

			//kiểm tra nếu số bản ghi dữ liệu lấy được > 0
			if($num>0){
				echo "<table class='table table-hover table-responsive table-bordered'>";
				// Lớp .table-hover giúp tạo ra hiệu ứng đổi màu nền khi con trỏ (pointer)
				// di chuyển trên các dòng của bảng (chỉ các dòng trong <tbody>).
				// Lớp .table-bordered sẽ tạo ra viền cho 4 cạnh của bảng và tất cả các cạnh của tất cả các ô của bảng.
				// Lớp. table-responsive nếu bảng không thể tự thu nhỏ chiều rộng của nó hơn nữa, thanh cuộn nằm ngang sẽ xuất hiện.
					echo "<tr>";
						echo "<th>Mã giày</th>";
                        echo "<th>Tên giày</th>";
                        echo "<th>Giá bán</th>";
						echo "<th>Số lượng</th>";
						echo "<th>Hành động</th>";
					echo "</tr>";
					// lấy các nội dung vào bảng
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						// thay cho việc truy xuất dữ liệu bằng cách $row['MaGiay'], thì chỉ cần gọi $MaGiay
						// bằng cách sử dụng hàm extract($row)
						extract($row);
						// mỗi bản ghi sẽ được hiển thị thành từng dòng trong bảng
						echo "<tr>";
							echo "<td>{$MaGiay}</td>";
							echo "<td>{$TenGiay}</td>";
                            echo "<td>{$GiaBan} đ</td>";
                            echo "<td>{$SoLuong}</td>";
							echo "<td>";
								// liên kết gọi chức năng hiển thị chi tiết từng sản phẩm theo ID
								echo "<a href='ChiTietGiay.php?id={$MaGiay}&page=$page' class='btn btn-success m-r-1em'>Xem</a>";
								// liên kết gọi chức năng cập nhật sản phẩm theo ID.

								echo "<a href='SuaGiay.php?id={$MaGiay}&page=$page' class='btn btn-warning m-r-1em'>Sửa</a>";
								echo "<a href='#' onclick='delete_shoes(\"$MaGiay\");' class='btn btn-danger'>Xoá</a>";
							echo "</td>";
						echo "</tr>";
					}
				echo "</table>";

				// PHÂN TRANG ==============================================================
				$query = "SELECT COUNT(*) AS total_rows FROM giay";
				$stmt = $con->prepare($query);
				$stmt->execute();
				
				// lấy tổng số dòng dữ liệu
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$total_rows = $row['total_rows'];

				$page_url="DanhSachGiay.php?";
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

	<script type='text/javascript'>
		// xác thực việc xóa bản ghi dữ liệu
		function delete_shoes(id){
			//Xác nhận xóa hay không ??
			var answer = confirm('Bạn có chắc muốn xóa sản phẩm này không?');
			if (answer){
				// nếu người dùng kích OK 
				// thì  chuyển trang và truyền id tới delete.php và thực thi truy vấn delete tại file đó
				window.location = 'XoaGiay.php?id=' + id;
			} 
		}

		function find_shoes(id){
			alert(id);
			window.location.href = 'TimKiemGiay.php?search='+id;
		}
	</script>



</body>
</html>