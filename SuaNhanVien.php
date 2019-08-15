<!DOCTYPE HTML>
<html>
<head>
	<title>WinaShoes</title>
	<link rel="stylesheet" type="text/css" href="css/home.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<body>
	<!-- container -->
	<div class="container">
		<div class="page-header"><h1>Sửa thông tin nhân viên</h1>
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
                        <li><a href="DanhSachKhachHang.php"> Khách hàng</a></li>
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


	<?php
		$id=isset($_GET['id']) ? $_GET['id'] : die('LỖI: Không tìm thấy ID.');

		include 'KetNoi.php';

		try {
			// chuẩn bị truy vấn SELECT
            $query = "SELECT MaNV, HoNV, TenNV, NgaySinh, GioiTinh, DiaChi, SoDT, Email FROM nhanvien WHERE MaNV = ? LIMIT 0,1";

			$stmt = $con->prepare( $query );

			$stmt->bindParam(1, $id);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			
            $fname = $row['HoNV'];
            $lname = $row['TenNV'];
			$birth = $row['NgaySinh'];
			$sex = $row['GioiTinh'];
			$addr = $row['DiaChi'];
			$phone = $row['SoDT'];
			$mail = $row['Email'];
		}
		catch(PDOException $exception){
			die('LỖI: ' . $exception->getMessage());
		}
	?>
	
	<?php
	// kiểm tra nếu form đã được submit
	if($_POST){
        include 'KetNoi.php';

        try{
            $query = "UPDATE nhanvien SET HoNV=:fname, TenNV=:lname, NgaySinh=:birth, GioiTinh=:sex, 
                        DiaChi=:addr, SoDT=:phone, Email=:mail WHERE MaNV=:id";
			
			// Chuẩn bị cho thực thi truy vấn
			$stmt = $con->prepare($query);
			
			// Các giá trị được lấy từ các trường nhập trên form
			
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
            $stmt->bindParam(':id', $id);


			// Thực thi truy vấn
			if($stmt->execute()){
                echo "<div class='alert alert-success'>Cập nhật nhân viên thành công.</div>";
				}
			else{
                echo "<div class='alert alert-danger'>Quá trình cập nhật thất bại!</div>";
            }
		}
		// hiển thị lỗi
		catch(PDOException $exception){
			die('ERROR: ' . $exception->getMessage());
		}
	}
	?>
    
	<!-- HTML form để cập nhật bản ghi dữ liệu sẽ đặt tại đây -->
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
		<table class='table table-hover table-responsive table-bordered'>
				<tr>
					<td>Họ nhân viên</td>
					<td><input type='text' name='fname' value="<?php echo htmlspecialchars($fname, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
					<td>Tên nhân viên</td>
					<td><input type='text' name='lname' value="<?php echo htmlspecialchars($lname, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
					<td>Ngày sinh</td>
					<td><input type='text' name='birth' value="<?php echo htmlspecialchars($birth, ENT_QUOTES); ?>" class='form-control' /></td>
				</tr>
                <tr>
                    <td>Giới tính</td>
					<td><input type="radio" name="sex" value="1" checked/> Nam <input type="radio" name="sex" value="0"/> Nữ</td></td>
				</tr>
                <tr>
                    <td>Địa chỉ</td>
					<td><input type='text' name='addr' value="<?php echo htmlspecialchars($addr, ENT_QUOTES); ?>" class='form-control'/></td>
                </tr>
                <tr>
					<td>Số điện thoại</td>
					<td><input type='text' name='phone' value="<?php echo htmlspecialchars($phone, ENT_QUOTES); ?>" class='form-control'/></td>
                </tr>
                <tr>
					<td>Email</td>
					<td><input type='text' name='mail' value="<?php echo htmlspecialchars($mail, ENT_QUOTES); ?>" class='form-control'/></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type='submit' value='Cập nhật' class='btn btn-primary' />
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
	
	<!-- jQuery (JQuery, Thư viện hỗ trợ cho Bootstrap JavaScript) -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<!-- Thư viện Bootstrap JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>