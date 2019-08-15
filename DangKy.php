<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>RegisterWinaShoes</title>
<link rel="stylesheet" type="text/css" href="css/register.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>

</head>
<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

	
?>
<?php
	// include file kết nối CSDL
	include 'KetNoi.php';
	

	if($_POST){
		try{
            $query = "INSERT INTO taikhoan SET tendangnhap=:id, matkhau=:pass, quyen=:role";

			$stmt = $con->prepare($query);
			$id = htmlspecialchars(strip_tags($_POST['id']));
			$pass = htmlspecialchars(strip_tags($_POST['pass']));
			$role = 'kh';

			$pass2 = htmlspecialchars(strip_tags($_POST['pass2']));
			if($pass2 != $pass){
				echo "<script>alert('Mật khẩu không khớp. Xác nhận mật khậu lại!!')</script>";
			}else{
				$stmt->bindParam(':id', $id);
				$stmt->bindParam(':pass', $pass);
				$stmt->bindParam(':role', $role);
				$stmt->execute();

				//Tạo mã kh tự động
				$query2 = "SELECT * FROM khachhang";
				$stmt = $con->prepare($query2);
				$stmt->execute();
				$num = $stmt->rowCount();
				
				$stt = $num + 1;
				if ($stt < 10) {
					$makh = 'KH000'.$stt;
				}
				else{
					$makh = 'KH00'.$stt;
				}
				
				$query3 = "INSERT INTO khachhang SET MaKH=:id, HoTenKH=:name, GioiTinh=:sex, 
                        DiaChi=:addr, SoDT=:phone, Email=:mail, TenDangNhap=:namelogin";
			
				$stmt = $con->prepare($query3);
				
				$name = htmlspecialchars(strip_tags($_POST['hoten']));
				$sex = htmlspecialchars(strip_tags($_POST['gioitinh']));
				$addr = htmlspecialchars(strip_tags($_POST['diachi']));
				$phone = htmlspecialchars(strip_tags($_POST['sdt']));
				$mail = htmlspecialchars(strip_tags($_POST['mail']));

				$stmt->bindParam(':id', $makh);
				$stmt->bindParam(':name', $name);
				$stmt->bindParam(':sex', $sex);
				$stmt->bindParam(':addr', $addr);
				$stmt->bindParam(':phone', $phone);
				$stmt->bindParam(':mail', $mail);
				$stmt->bindParam(':namelogin', $id);

				if($stmt->execute()){
					header('Location: DangNhap.php');
				}else{
					echo "<div class='alert alert-danger'>Đăng ký thất bại.</div>";
				}	
			}
		}
		// hiển thị lỗi
		catch(PDOException $exception){
			die('LỗI: ' . $exception->getMessage());
		}
	}
?>
<body>
	
	<div class="container">
	<form  class="form-register" method="post" action ="DangKy.php">
		<h2 class="form-register-heading" align="center">ĐĂNG KÝ</h2><br>
   		<table class="table table-hover table-bordered">
        	<tr>
				<td>Nhập tên tài khoản:</td>
				<td><input type="text" class="form-control" placeholder="Tên tài khoản" name="id" required autofocus></td>
            </tr>
            <tr>
            	<td>Nhập mật khẩu:</td>
                <td><input type="text" class="form-control" placeholder="Mật khẩu" name="pass" required></td>
            </tr>
            <tr>
            	<td>Nhập lại mật khẩu:</td>
                <td><input type="text" class="form-control" placeholder="Mật khẩu" name="pass2" required></td>
            </tr>
            <tr>
            	<td>Nhập họ và tên:</td>
                <td><input type="id" class="form-control" placeholder="Nguyễn Văn A" name="hoten" required></td>
            </tr>
			<tr>
				<td>Giới tính</td>
				<td><input type="radio" name="gioitinh" value="1" checked/> Nam <input type="radio" name="gioitinh" value="0"/> Nữ</td></td>
			</tr>
            <tr>
            	<td>Nhập địa chỉ:</td>
                <td><input type="text" class="form-control" placeholder="123/4A, TP Hồ Chí Minh" name="diachi" required></td>
            </tr>
            <tr>
            	<td>Nhập số điện thoại:</td>
                <td><input type="tel" class="form-control" placeholder="0123456789" name="sdt" required></td>
            </tr>
            <tr>
            	<td>Nhập email:</td>
				<td><input type="mail" class="form-control" placeholder="anguyenvan@gmail.com" name="mail" required></td>
			</tr>
			<tr></tr>
		</table>
		<button class="btn btn-lg btn-danger" type="submit" name="btnDangKi">Đăng kí</button>
	</form>
	</div>

</body>
</html>