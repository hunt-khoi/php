<!DOCTYPE HTML>
<html>
<head>
<title>WinaShoes</title>
<!--Thư viện Bootstrap CSS -->
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
            $query = "INSERT INTO giay SET MaGiay=:id, TenGiay=:name, GiaBan=:price, SoLuong=:amount, 
                        MoTa=:descript, HinhAnh=:img, MaHang=:idhang, MaLoai=:idloai, GhiChu=:note";
			
			// Chuẩn bị cho thực thi thêm
			$stmt = $con->prepare($query);
			
			// Các giá trị được lấy từ các trường nhập trên form
			$id = htmlspecialchars(strip_tags($_POST['id']));
			$name = htmlspecialchars(strip_tags($_POST['name']));
            $price = htmlspecialchars(strip_tags($_POST['price']));
            $amount = htmlspecialchars(strip_tags($_POST['amount']));
			$descript = htmlspecialchars(strip_tags($_POST['descript']));

			$img = !empty($_FILES["img"]["name"])? basename($_FILES["img"]["name"]): "";
			$img = htmlspecialchars(strip_tags($img));

			$idhang = htmlspecialchars(strip_tags($_POST['idhang']));
			$idloai = htmlspecialchars(strip_tags($_POST['idloai']));
			$note = htmlspecialchars(strip_tags($_POST['note']));

			// truyền các tham số cho câu truy vấn
			$stmt->bindParam(':id', $id);
			$stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':amount', $amount);
			$stmt->bindParam(':descript', $descript);
			$stmt->bindParam(':img', $img);
			$stmt->bindParam(':idhang', $idhang);
			$stmt->bindParam(':idloai', $idloai);
			$stmt->bindParam(':note', $note);

			// Thực thi truy vấn thêm giày mới
			if($stmt->execute()){
				echo "<div class='alert alert-success'>Tạo sản phẩm mới thành công.</div>";
			}
			// Thêm giày mới không thành công
			else{
					echo "<div class='alert alert-danger'>Tạo sản phẩm mới thất bại.</div>";
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
						<li class="active"><a href="TrangChuNV.php"> Trang chủ <i class="glyphicon glyphicon-home"></i></a></li>
						<li><a href="DangNhap.php">Đăng nhập</a></li>
						<li class="active"><a href="DanhSachGiay.php"> Giày</a></li>
						<li><a href="DanhSachHoaDon.php"> Hóa đơn</a></li>
						<li><a>
							<form class="form-inline">
								<input class="form-control ml-auto" placeholder="Tìm kiếm giày...">
								<button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i></button>
							</form>
						</a></li>
						<li><a><i class="glyphicon glyphicon-user"></i> Chào Khôi</a></li>
					</ul>
				</div>

			</div>
		</div>

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
			<table class='table table-hover table-responsive table-bordered'>
				<tr>
					<td>Mã giày</td>
					<td><input type='text' name='id' class='form-control' required autofocus/></td>
				</tr>
				<tr>
					<td>Tên giày</td>
					<td><input type='text' name='name' class='form-control' /></td>
				</tr>
                <tr>
					<td>Giá bán</td>
					<td><input type='text' name='price' class='form-control' /></td>
				</tr>
                <tr>
					<td>Số lượng</td>
					<td><input type='number' name='amount' class='form-control'/></td>
				</tr>
				<tr>
					<td>Mô tả</td>
					<td><textarea name='descript' class='form-control'></textarea></td>
				</tr>
				<tr>
					<td>Hình ảnh</td>
					<td><input type="file" name="img"/></td>
				</tr>
				<tr>
					<td>Mã hãng</td>
					<td>
						<select name='idhang' class='form-control'>
							<?php
							while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
								extract($row);
								echo "<option>{$MaHang}</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Mã loại</td>
					<td>
						<select name='idloai' class='form-control'>
							<?php
							while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)){
								extract($row);
								echo "<option>{$MaLoai}</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Ghi chú</td>
					<td><textarea name='note' class='form-control'></textarea></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type='submit' value='Lưu' class='btn btn-primary' />
						<a href='DanhSachGiay.php' class='btn btn-danger'>Quay lại danh sách giày</a>
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