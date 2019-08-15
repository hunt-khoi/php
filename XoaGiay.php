<?php
    // include kết nối CSDL
    include 'KetNoi.php';
    
    try {
        
        // lấy ID từ URL
        $id = isset($_GET['id']) ? $_GET['id'] : die('LỖI: Không tìm thấy mã giày !!');
    
        // truy vấn xóa dữ liệu
        $query = "DELETE FROM giay WHERE MaGiay = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $id);
        
        if($stmt->execute()){
            // Nếu xóa thành công chuyển về trang DanhSachGiay.php
            header('Location: DanhSachGiay.php?action=deleted');
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