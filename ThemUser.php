<!DOCTYPE HTML>
<html>
<head>
<title>WinaShoes</title>
<link rel="stylesheet" type="text/css" href="css/home.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<!-- Code PHP thêm mới sản phẩm sẽ đặt tại đây -->
<?php
	// include file kết nối CSDL
	include 'KetNoi.php';
	
	// Lấy dữ liệu tên hãng từ hãng giày
	$query2 = "SELECT * FROM hanggiay";
	$stmt2 = $con->prepare($query2);
	$stmt2->execute();

	// Lấy dữ liệu tên loại từ loại giày
	$query3 = "SELECT * FROM loaigiay";
	$stmt3 = $con->prepare($query3);
	$stmt3->execute();

	if($_POST){
		try{
            $query = "INSERT INTO taikhoan SET TenDangNhap=:id, MatKhau=:pass, Quyen=:role";
			
			// Chuẩn bị cho thực thi thêm
			$stmt = $con->prepare($query);
			
			// Các giá trị được lấy từ các trường nhập trên form
			$id = htmlspecialchars(strip_tags($_POST['id']));
			$pass = htmlspecialchars(strip_tags($_POST['pass']));
            $role = htmlspecialchars(strip_tags($_POST['role']));

			// truyền các tham số cho câu truy vấn
			$stmt->bindParam(':id', $id);
			$stmt->bindParam(':pass', $pass);
            $stmt->bindParam(':role', $role);


			// Thực thi truy vấn thêm giày mới
			if($stmt->execute()){
				echo "<div class='alert alert-success'>Tạo user mới thành công.</div>";
			}
			// Thêm giày mới không thành công
			else{
					echo "<div class='alert alert-danger'>Tạo user mới thất bại.</div>";
			}	
		}
		// hiển thị lỗi
		catch(PDOException $exception){
			die('LỗI: ' . $exception->getMessage());
		}
	}
?>
<body>
<!-- container -->
	<div class="container">
		<div class="page-header">
			<h1>Thêm user mới</h1>
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

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
			<table class='table table-hover table-responsive table-bordered'>
				<tr>
					<td>Tên đăng nhập</td>
					<td><input type='text' name='id' class='form-control' required autofocus/></td>
				</tr>
				<tr>
					<td>Mật khẩu</td>
					<td><input type='text' name='pass' class='form-control' /></td>
				</tr>
				<tr>
					<td>Quyền</td>
					<td>
						<select name='role' class='form-control'>
							<option selected>nv</option>
                            <option>admin</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type='submit' value='Lưu' class='btn btn-primary' />
						<a href='DanhSachNguoiDung.php' class='btn btn-danger'>Quay lại danh sách user</a>
					</td>
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

<!-- jQuery (Thư viện Jquery, sự cần thiết cho Bootstrap's JavaScript) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<!--Thư viện Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>