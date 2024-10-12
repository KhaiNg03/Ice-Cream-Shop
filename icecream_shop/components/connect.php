<?php
// Kết nối cơ sở dữ liệu
$db_name = 'mysql:host=localhost;dbname=icecream_db';
$user_name = 'root';
$user_password = '';

try {
    $conn = new PDO($db_name, $user_name, $user_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Kết nối thất bại: " . $e->getMessage();
    die();
}

// Kiểm tra và định nghĩa hàm unique_id nếu chưa tồn tại
if (!function_exists('unique_id')) {
    function unique_id() {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charLength = strlen($chars);
        $randomString = '';
        for ($i = 0; $i < 20; $i++) {
            $randomString .= $chars[random_int(0, $charLength - 1)];
        }
        return $randomString;
    }
}
?>
