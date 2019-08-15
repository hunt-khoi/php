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
			<h1>Danh sách người dùng</h1>
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
                        <li><a href="TrangChuAdmin.php">Trang chủ <i class="glyphicon glyphicon-home"></i></a></li>
                        <li class="active"><a href="DanhSachNguoiDung.php"> Người dùng</a></li>
                        <li><a href="DanhSachNhanVien.php"> Nhân viên</a></li>
                        <li><a href="DanhSachKhachHang.php"> Khách hàng</a></li>
                        <li><a>
							<form class="form-inline" action="TimKiemUser.php">
									<input class="form-control ml-auto" name="search" placeholder="Find user...">
									<button class="btn btn-primary" onclick='find_user(search.value)'><i class="glyphicon glyphicon-search"></i></button> 
							</form>
                        </a></li>
                        <li><a><i class="glyphicon glyphicon-user" style="color:blue"></i> Hi Admin</a></li>
						<li><a href="DangNhap.php">Đăng xuất</a></li>
                    </ul>
                </div>

            </div>
	    </div>

		<?php
			include 'KetNoi.php';

			$action = isset($_GET['action']) ? $_GET['action'] : "";
			if($action=='deleted'){
				echo "<div class='alert alert-success'>User đã được xoá.</div>";
			}

			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$records_per_page = 5; 
			
			// Tính toán phục vụ truy vấn trong mệnh đề LIMIT
			$from_record_num = ($records_per_page * $page) - $records_per_page;

			// lấy dữ liệu cho trang hiện tại
			$query = "SELECT TenDangNhap, MatKhau, Quyen FROM taikhoan ORDER BY TenDangNhap ASC
			LIMIT :from_record_num, :records_per_page";

			$stmt = $con->prepare($query);
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			$stmt->execute();

			$num = $stmt->rowCount();
			
			echo "<a href='ThemUser.php' class='btn btn-primary m-b-1em'>Thêm user mới</a>";
			//kiểm tra nếu số bản ghi dữ liệu lấy được > 0
			if($num>0){
				echo "<table class='table table-hover table-responsive table-bordered'>";
					echo "<tr>";
						echo "<th>Tên đăng nhập</th>";
                        echo "<th>Mật khẩu</th>";
                        echo "<th>Quyền</th>";
                        echo "<th>Hành động</th>";
                    echo "</tr>";
					// lấy các nội dung vào bảng
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						extract($row);
						// mỗi bản ghi sẽ được hiển thị thành từng dòng trong bảng
						echo "<tr>";
							echo "<td>{$TenDangNhap}</td>";
							echo "<td>$MatKhau</td>";
                            echo "<td>{$Quyen}</td>";
							echo "<td>";
								echo "<a href='SuaUser.php?id={$TenDangNhap}&page=$page' class='btn btn-info m-r-1em'>Sửa</a>";
								echo "<a href='#' onclick='delete_user(\"$TenDangNhap\");' class='btn btn-success'>Xoá</a>";
							echo "</td>";
						echo "</tr>";
					}
				echo "</table>";

				$query = "SELECT COUNT(*) AS total_rows FROM taikhoan";
				$stmt = $con->prepare($query);
				$stmt->execute();
				
				// lấy tổng số dòng dữ liệu
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$total_rows = $row['total_rows'];

				$page_url="DanhSachNguoiDung.php?";
				include_once "PhanTrang.php";
			}

			// nếu không tìm thấy bản ghi dữ liệu nào
			else{
				echo "<div class='alert alert-danger'>Không tìm thấy khách hàng nào.</div>";
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
		function delete_user(id){
			//Xác nhận xóa hay không ??
			var answer = confirm('Bạn có chắc muốn xóa user này không?');
			if (answer){
				// nếu người dùng kích OK 
				// thì  chuyển trang và truyền id tới delete.php và thực thi truy vấn delete tại file đó
				window.location = 'XoaUser.php?id=' + id;
			} 
		}

		function find_user(id){
			alert(id);
			window.location.href = 'TimKiemUser.php?search='+id;
		}
	</script>



</body>
</html>