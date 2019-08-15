<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>WinaShoes</title>
<link rel="stylesheet" type="text/css" href="css/home.css" />
<link rel="stylesheet" type="text/css" href="css/carousel.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>

</head>
<body>
	<div class="container">
		<div class="page-header"></div>
        
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
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tài khoản<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="DangNhap.php">Đăng xuất</a></li>
                                <li><a href="DangKy.php">Đăng ký</a></li>
                            </ul>
                        </li>
                        <li><a href="Giay.php">Giày</a></li>
                        <li class="active"><a href="GioHang.php">Giỏ hàng <i class="glyphicon glyphicon-shopping-cart badge pull-right badge-pill badge-primary">
                        <?php include 'KetNoi.php'; echo isset($_SESSION['gio']) ? count($_SESSION['gio']) : 0; ?></i></a></li>
                        <li><a>
                            <form class="form-inline" action="TimKiemGiay.php">
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

            //Kiểm tra biến session cho các sản phẩm trong giỏ hàng
            $giay_gio = isset($_SESSION['gio'])?$_SESSION['gio']:array();
            $giay = array();
            $tongcong = 0;

            if($giay_gio) {
                $array_to_question_marks = implode(',', array_fill(0, count($giay_gio), '?'));

                $stmt = $con->prepare('SELECT * FROM giay WHERE MaGiay IN ('. $array_to_question_marks.')');
                $stmt->execute(array_keys($giay_gio));
                $giay = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($giay as $items) {
                    $tongcong += $items['GiaBan']*$giay_gio[$items['MaGiay']];
                }
            }


            try{
                //Đặt hàng
                if (isset($_SESSION['gio'])) {

                    //Tạo số hóa đơn tự động
                    $query2 = "SELECT * FROM hoadon";
                    $stmt = $con->prepare($query2);
                    $stmt->execute();
                    $num = $stmt->rowCount();	
                    $stt = $num + 1;
                    if ($stt < 10) {
                        $id = 'HD0000'.$stt;
                    }
                    else{
                        $id = 'HD000'.$stt;
                    }

                    $datelap = date('Y-m-d');
                    $d = (int) date("d");
                    $m = (int) date("m");
                    $y = (int) date("Y");
                    //Ngày giao hàng là 5 ngày sau khi lập hóa đơn
                    $dateadd = mktime(0, 0, 0, $m, $d + 5, $y);
                    $dategiao = date('Y-m-d', $dateadd); 
                    
                    $tendn = $_SESSION['dangnhap'];
                    $query3 ="SELECT MaKH, DiaChi FROM khachhang WHERE TenDangNhap=:tendn";
                    $stmt = $con->prepare($query3);
                    $stmt->bindParam(':tendn', $tendn);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    extract($row);
                    $idkhach = $MaKH;

                    $thanhtien = 250000+$tongcong;  //cộng thêm tiền ship
                    $sumval = $thanhtien;

                    $query = "INSERT INTO hoadon SET SoHD=:id, NgayLapHD=:datelap, NgayGiaoHang=:dategiao, MaKH=:idkhach, TongTriGia=:sumval";
                    $stmt = $con->prepare($query);


                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':datelap', $datelap);
                    $stmt->bindParam(':dategiao', $dategiao);
                    $stmt->bindParam(':idkhach', $idkhach);
                    $stmt->bindParam(':sumval', $sumval);
                    
                    if($stmt->execute()){
                        echo "<div class='alert alert-success'><span>
                            <h3>Đơn đặt hàng thành công !!</h3>
                            <p>Mã đơn hàng: $id</p>
                            <p>Tổng giá trị: &nbsp;&nbsp;&nbsp;$tongcong VND 
                                <h6>(Chưa bao gồm thuế VAT)</h6></p>
                            <p>Ngày giao hàng dự kiến: $dategiao</p>
                            <p>Địa chỉ giao hàng: $DiaChi</p>
                            <p>Phí vận chuyển: 25000 VND</p>
                            <p>Thành tiền: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$thanhtien VND</p>
                        </span></div>";

                        //unset_session($_SESSION['gio']);
                    }
                    else{
                        echo "<div class='alert alert-success'>Đơn đặt hàng thất bại !!</div>";
                    }
                }
            }
            catch(PDOException $exception){
                die('LỗI: ' . $exception->getMessage());
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