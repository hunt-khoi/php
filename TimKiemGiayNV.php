<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>WinaShoes</title>
<link rel="stylesheet" type="text/css" href="css/home.css" />
<link rel="stylesheet" type="text/css" href="css/carousel.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
<style>
	.col-sm-4{
		text-align:center;
	}
</style>

</head>
<body>
	<div class="container">
		<div class="page-header">
			<h1 align="center">WINA SHOES</h1>
		</div>
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
					<li><a href="TrangChuKH.php"> Trang chủ <i class="glyphicon glyphicon-home"></i></a></li>
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

    <div class="container">
		<?php
			include 'KetNoi.php';
            
			$search = isset($_GET['search']) ? $_GET['search'] : die('Lỗi không có từ khóa đề tìm');
			$giatim = (int) $search;
			$giamax = $giatim + 500000;
			$giamin = $giatim - 500000;

            $sql_search = "SELECT * FROM giay, loaigiay WHERE (TenGiay = '$search' OR  (GiaBan BETWEEN $giamin AND $giamax) OR TenLoai LIKE '%$search%' )
                            AND giay.MaLoai=loaigiay.MaLoai";
            $stmt = $con->prepare($sql_search);
            $stmt->execute();

            $num = $stmt->rowCount();

            if($num<=0){
                echo '<div class="alert alert-danger">Không tìm thấy sản phẩm nào !!</div>';
            }
            else {
                echo '<div class="alert alert-success">Có '.$num.' sản phẩm được tìm thấy</div>';
            }
		?>

		<div class="container">
			<div class="row">
			<?php $KhuyenMai = 500000;
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
					extract($row);
					$GiaGiam = $GiaBan-$KhuyenMai;
					$PhanTram = ceil(($KhuyenMai/$GiaBan)*100); ?>
							
					<div class="col-sm-4 padding-right padding-">
						<?php echo "<img src='hinhanh/Giay/$HinhAnh' width='320' height='320'>
								<h4 algin='center'>$TenGiay</h4>
								<h3><b>$GiaGiam đ</b> <sub>&nbsp-$PhanTram%</sub></h3>
								<p><strike>$GiaBan đ</strike></p>
									<a href='ChiTietGiay.php?id={$MaGiay}' class='btn btn-sm btn-info'>Xem Chi Tiết</a>"; ?>
								<p></p>
					</div>
							
			<?php }
			?>
			</div>
		</div>
  </div>


	<div class="footer">
		<div class="container">
		<h5 class="pull-right"><a href="#">Trở lại đầu trang</a></h5>
			<p class="text-muted">
				Address: 1062A Cách Mạng Tháng Tám, Phường 4, Quận Tân Bình, TP.Hồ Chí Minh
				<br>Tel: 09.8523.5755 
				<br>Facebook: www.facebook.com/winashoes
				<br>&copy; Team PHP - 2rd Semester 5/2019</p>
		</div>
	</div>

	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<!-- jQuery (Thư viện Jquery, sự cần thiết cho Bootstrap's JavaScript) -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<!-- Thư viện Bootstrap JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script type='text/javascript'>
		// xác thực việc xóa bản ghi dữ liệu
		function find_shoes(id){
			alert(id);
			window.location.href = 'TimKiemGiay.php?search='+id;
		}
	</script>

</body>


</html>