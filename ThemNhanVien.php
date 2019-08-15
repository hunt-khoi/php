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

	if($_POST){
		try{
            $query = "INSERT INTO nhanvien SET HoNV=:fname, TenNV=:lname, NgaySinh=:birth, GioiTinh=:sex, 
                        DiaChi=:addr, SoDT=:phone, Email=:mail";
			
			// Chuẩn bị cho thực thi thêm
			$stmt = $con->prepare($query);
			
			$fname = htmlspecialchars(strip_tags($_POST['fname']));
            $lname = htmlspecialchars(strip_tags($_POST['lname']));
            $birth = htmlspecialchars(strip_tags($_POST['birth']));
            $sex = htmlspecialchars(strip_tags($_POST['sex']));
			$addr = htmlspecialchars(strip_tags($_POST['addr']));
			$phone = htmlspecialchars(strip_tags($_POST['phone']));
			$mail = htmlspecialchars(strip_tags($_POST['mail']));

			// truyền các tham số cho câu truy vấn
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':birth', $birth);
            $stmt->bindParam(':sex', $sex);
            $stmt->bindParam(':addr', $addr);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':mail', $mail);

			// Thực thi truy vấn thêm giày mới
			if($stmt->execute()){
				echo "<div class='alert alert-success'>Thêm nhân viên mới thành công.</div>";
			}
			// Thêm giày mới không thành công
			else{
					echo "<div class='alert alert-danger'>Thêm nhân viên mới thất bại.</div>";
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
			<h1>Thêm đôi giày mới</h1>
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
                        <li><a href="TrangChuAdmin.php">Trang chủ <i class="glyphicon glyphicon-home"></i></a></li>
                        <li><a href="DangNhap.php">Đăng nhập</a></li>
                        <li><a href="DanhSachNguoiDung.php"> Người dùng</a></li>
                        <li class="active"><a href="DanhSachNhanVien.php"> Nhân viên</a></li>
                        <li><a href="DanhSachNguoiDung.php"> Khách hàng</a></li>
                        <li><a>
                            <form class="form-inline">
                                <input class="form-control ml-auto" placeholder="Find user...">
                                <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </form>
                        </a></li>
                        <li><a><i class="glyphicon glyphicon-user" style="color:blue"></i> Hi Admin</a></li>
                    </ul>
                </div>

            </div>
	    </div>

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
			<table class='table table-hover table-responsive table-bordered'>
                <tr>
					<td>Họ nhân viên</td>
					<td><input type='text' name='fname' class='form-control' /></td>
                </tr>
                <tr>
					<td>Tên nhân viên</td>
					<td><input type='text' name='lname' class='form-control'/></td>
                </tr>
                <tr>
					<td>Ngày sinh</td>
					<td><input type='text' name='birth' class='form-control' /></td>
				</tr>
                <tr>
					<td>Giới tính</td>
					<td><input type="radio" name="sex" value="1"/> Nam <input type="radio" name="sex" value="0"/> Nữ</td></td>
				</tr>
                <tr>
					<td>Địa chỉ</td>
					<td><input type='text' name='addr' class='form-control' /></td>
                </tr>
                <tr>
					<td>Số điện thoại</td>
					<td><input type='text' name='phone' class='form-control' /></td>
                </tr>
                <tr>
					<td>Email</td>
					<td><input type='text' name='mail' class='form-control' /></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type='submit' value='Lưu' class='btn btn-primary' />
						<a href='DanhSachNhanVien.php' class='btn btn-danger'>Quay lại danh sách nhân viên</a>
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