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

    <div class="container">
		<?php
			include 'KetNoi.php';
            
			$search = isset($_GET['search']) ? $_GET['search'] : die('Lỗi không có từ khóa đề tìm');

            $sql_search = "SELECT * FROM taikhoan WHERE TenDangNhap LIKE '%$search%'";
            $stmt = $con->prepare($sql_search);
            $stmt->execute();

            $num = $stmt->rowCount();

            if($num<=0){
                echo '<div class="alert alert-danger">Không tìm thấy user nào !!</div>';
            }
            else {
                echo '<div class="alert alert-success">Có '.$num.' user được tìm thấy</div>';

				echo "<table class='table table-hover table-responsive table-bordered'>";
					echo "<tr>";
						echo "<th>Tên đăng nhập</th>";
                        echo "<th>Mật khẩu</th>";
                        echo "<th>Quyền</th>";
                        echo "<th>Hành động</th>";
                    echo "</tr>";
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						extract($row);
						echo "<tr>";
							echo "<td>{$TenDangNhap}</td>";
							echo "<td>$MatKhau</td>";
                            echo "<td>{$Quyen}</td>";
							echo "<td>";
                                echo "<a href='SuaUser.php?id={$TenDangNhap}&page=$page' class='btn btn-info m-r-1em'>Sửa</a>";
                                echo " ";
								echo "<a href='#' onclick='delete_user(\"$TenDangNhap\");' class='btn btn-success'>Xoá</a>";
							echo "</td>";
						echo "</tr>";
					}
                echo "</table>";
            }
		?>

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
			window.location.href = 'TimKiemUser.php?search='+id;
		}
	</script>

</body>


</html>