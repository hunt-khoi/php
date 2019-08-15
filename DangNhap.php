<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>LoginWinaShoes</title>
<link rel="stylesheet" type="text/css" href="css/signin.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>

</head>
<body background="hinhanh/login.jpeg">
    
    <?php
        include 'KetNoi.php';

        if($_POST) {
            try{
                $query = "SELECT MatKhau, Quyen FROM taikhoan WHERE TenDangNhap=:name";
                $stmt = $con->prepare($query);

                $name = htmlspecialchars(strip_tags($_POST['name']));
                $pass = htmlspecialchars(strip_tags($_POST['pass']));

                $stmt->bindParam(':name', $name);
                $stmt->execute();
                $num = $stmt->rowCount();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                extract($row);
                        
                if($num == 0){
                    echo "<script>alert('Tên đăng nhập không tồn tại');</script>";
                }
                else if($pass != $MatKhau){
                    echo "<script>alert('Mật khẩu không hợp lệ');</script>";
                }
                else{
                    $_SESSION['dangnhap'] = $name;

                    if($Quyen == "kh"){
                        header('Location: TrangChuKH.php');
                    }
                    else if($Quyen == "nv")
                        header('Location: TrangChuNV.php');
                    else
                        header('Location: TrangChuAdmin.php');
                }

            }
            catch(PDOException $exception){
                die('LỗI: ' . $exception->getMessage());
            }
        }

    ?>

    <div class="container">
        <form class="form-signin" role="form" method="post">
            <h2 class="form-signin-heading" align="center">ĐĂNG NHẬP</h2><br>
            <input name="name" type="id" class="form-control" placeholder="Tên đăng nhập" required autofocus> 
            <!-- Tự động bắt focus khi tải trang -->
            <input name="pass" type="password" class="form-control" placeholder="Mật khẩu" required>
            <h4 align="center">Bạn chưa có tài khoản? <a href="DangKy.php">Tạo tài khoản</a></h4>
            <button class="btn btn-lg btn-primary" type="submit">Đăng nhập</button>
        </form>
    </div>


</body>
</html>