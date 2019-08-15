<?php
session_start();

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
// Thiết lập các biến kết nối với CSDL
$host = "localhost";
$db_name = "quanlybangiay";
$username = "root";
$password = "";
$option = $options = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", //Giúp hiện thị tiếng Việt
);
try {
	$con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password, $option);
	// Thiết lập chế độ lỗi
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
// Hiển thị lỗi nếu quá trình kết nối xảy ra vấn đề
catch(PDOException $exception){
	echo "Kết nối thất bại: " . $e->getMessage();
}

//Thiết lập điều hướng
// $pages = array('cart', 'home', 'product', 'products', 'placeorder');
// $page = isset($_GET['page']) &&
// in_array($_GET['page'], $pages) ? $_GET['page'] : 'home';

?>