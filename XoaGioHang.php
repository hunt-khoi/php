<?php
    // include kết nối CSDL
    include 'KetNoi.php';
    
    try {
        
        // lấy ID từ URL
        $id = isset($_GET['id']) ? $_GET['id'] : die('LỖI: Không tìm thấy mã khách hàng !!');
    
        // truy vấn xóa dữ liệu
        $query = "DELETE FROM taikhoan WHERE TenDangNhap = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $id);
        
        if($stmt->execute()){
            // Nếu xóa thành công chuyển về trang DanhSachGiay.php
            header('Location: DanhSachNguoiDung.php?action=deleted');
        }
        else{
            die('Không thể xóa bản ghi.');
        }
    }
    
    // Hiển thị lỗi
    catch(PDOException $exception){
        die('LỖI: ' . $exception->getMessage());
    }
?>