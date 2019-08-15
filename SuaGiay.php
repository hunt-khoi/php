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
		<div class="page-header"><h1>Sửa thông tin sản phẩm</h1>
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
						<li><a><i class="glyphicon glyphicon-user"></i> Chào <?php include 'KetNoi.php'; echo $_SESSION['dangnhap']; ?></a></li>
					</ul>
				</div>

			</div>
		</div>


	<?php
		// lấy giá trị của tham số ‘id’ trên URL
		// isset() là hàm trong PHP cho phép kiểm tra giá trị là có hoặc không
		$id=isset($_GET['id']) ? $_GET['id'] : die('LỖI: Không tìm thấy ID.');

		include 'KetNoi.php';
		// đọc dữ liệu của bản ghi hiện tại
		// Lấy dữ liệu tên hãng từ hãng giày
		$query2 = "SELECT * FROM hanggiay";
		$stmt2 = $con->prepare($query2);
		$stmt2->execute();

		// Lấy dữ liệu tên loại từ loại giày
		$query3 = "SELECT * FROM loaigiay";
		$stmt3 = $con->prepare($query3);
		$stmt3->execute();


		try {
			// chuẩn bị truy vấn SELECT
            $query = "SELECT MaGiay, TenGiay, GiaBan, SoLuong, MoTa, HinhAnh, MaHang, MaLoai, GhiChu
            FROM giay WHERE MaGiay = ? LIMIT 0,1";

			$stmt = $con->prepare( $query );

			$stmt->bindParam(1, $id);
			$stmt->execute();
			// lưu bản ghi dữ liệu lấy được vào một biến ‘row’ vì nó chỉ là 1 dòng DL
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$name = $row['TenGiay'];
			$price = $row['GiaBan'];
			$amount = $row['SoLuong'];
			$descript= $row['MoTa'];
			$img = $row['HinhAnh'];
			$idhang = $row['MaHang'];
			$idloai = $row['MaLoai'];
			$note = $row['GhiChu'];
		}
		catch(PDOException $exception){
			die('LỖI: ' . $exception->getMessage());
		}
	?>
	
	<!-- Mã PHP xử lý cập nhật dữ liệu sẽ đặt tại đây -->
	<?php
	// kiểm tra nếu form đã được submit
	if($_POST){
        // include file kết nối CS

        try{
            $query = "UPDATE giay SET TenGiay=:name, GiaBan=:price, SoLuong=:amount, 
                        MoTa=:descript, HinhAnh=:img, MaHang=:idhang, MaLoai=:idloai, GhiChu=:note WHERE MaGiay=:id";
			
			// Chuẩn bị cho thực thi truy vấn
			$stmt = $con->prepare($query);
			
			// Các giá trị được lấy từ các trường nhập trên form
			
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
			$stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':amount', $amount);
			$stmt->bindParam(':descript', $descript);
			$stmt->bindParam(':img', $img);
			$stmt->bindParam(':idhang', $idhang);
			$stmt->bindParam(':idloai', $idloai);
			$stmt->bindParam(':note', $note);
			$stmt->bindParam(':id', $id);

			// Thực thi truy vấn
			if($stmt->execute()){
                echo "<div class='alert alert-success'>Cập nhật sản phẩm thành công.</div>";
				}
			else{
                echo "<div class='alert alert-danger'>Quá trình cập nhật thất bại. Vui lòng thử lại!</div>";
            }
		}
		// hiển thị lỗi
		catch(PDOException $exception){
			die('ERROR: ' . $exception->getMessage());
		}
	}
	?>
	
		
	<!-- HTML form để cập nhật bản ghi dữ liệu sẽ đặt tại đây -->
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post" enctype="multipart/form-data">
		<table class='table table-hover table-responsive table-bordered'>
				<tr>
					<td>Tên sản phẩm</td>
					<td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>" class='form-control' /></td>
				</tr>
                <tr>
					<td>Giá bán</td>
					<td><input type='text' name='price' value="<?php echo htmlspecialchars($price, ENT_QUOTES); ?>" class='form-control' /></td>
				</tr>
                <tr>
					<td>Số lượng</td>
					<td><input type='number' name='amount' value="<?php echo htmlspecialchars($amount, ENT_QUOTES); ?>" class='form-control' value="1" /></td>
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
						<input type='submit' value='Cập nhật' class='btn btn-primary' />
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
	
	<!-- jQuery (JQuery, Thư viện hỗ trợ cho Bootstrap JavaScript) -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<!-- Thư viện Bootstrap JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>