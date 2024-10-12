<?php
    include 'connect.php';
    
    // Xóa cookie 'seller_id' bằng cách đặt thời gian hết hạn trong quá khứ
    setcookie('seller_id', '', time() - 3600, '/');
    
    // Chuyển hướng đến trang đăng nhập
    header('location: ../admin_panel/login.php');
    exit();
?>
