<?php
include 'connect.php'; 
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}
// Thêm sản phẩm vào giỏ hàng
if (isset($_POST['add_to_cart'])) {
    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (!empty($user_id)) {
        $id = unique_id();

        // Làm sạch dữ liệu đầu vào bằng cách sử dụng htmlspecialchars
        $product_id = htmlspecialchars($_POST['product_id'], ENT_QUOTES, 'UTF-8');
        $qty = htmlspecialchars($_POST['qty'], ENT_QUOTES, 'UTF-8');

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
        $verify_cart->execute([$user_id, $product_id]);

        // Kiểm tra xem giỏ hàng đã đầy chưa
        $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $max_cart_items->execute([$user_id]);

        if ($verify_cart->rowCount() > 0) {
            $warning_msg[] = 'Sản phẩm đã có trong giỏ hàng của bạn';
        } elseif ($max_cart_items->rowCount() >= 20) {
            $warning_msg[] = 'Giỏ hàng của bạn đã đầy';
        } else {
            // Lấy giá sản phẩm từ cơ sở dữ liệu
            $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
            $select_price->execute([$product_id]);
            $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

            // Chèn sản phẩm vào giỏ hàng
            $insert_cart = $conn->prepare("INSERT INTO `cart` (id, user_id, product_id, price, qty) VALUES (?, ?, ?, ?, ?)");
            $insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $qty]);

            $success_msg[] = 'Sản phẩm đã được thêm vào giỏ hàng của bạn thành công';
        }
    } else {
        $warning_msg[] = 'Vui lòng đăng nhập trước';
    }
}
?>
