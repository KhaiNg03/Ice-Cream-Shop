<?php
include '../components/connect.php'; 

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}
// Thêm sản phẩm vào danh sách yêu thích
if (isset($_POST['add_to_wishlist'])) {
    // Kiểm tra người dùng đã đăng nhập chưa
    if ($user_id != '') {
        $id = unique_id();
        $product_id = $_POST['product_id'];

        // Kiểm tra xem sản phẩm đã có trong danh sách yêu thích chưa
        $verify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");
        $verify_wishlist->execute([$user_id, $product_id]);
        $cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
        $cart_num->execute([$user_id, $product_id]);

        if ($verify_wishlist->rowCount() > 0) {
            $warning_msg[] = 'Sản phẩm đã có trong danh sách yêu thích của bạn';
        } else {
            // Kiểm tra xem sản phẩm có trong giỏ hàng không (nếu bạn có bảng giỏ hàng)
            $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
            $verify_cart->execute([$user_id, $product_id]);

            if ($verify_cart->rowCount() > 0) {
                $warning_msg[] = 'Sản phẩm đã có trong giỏ hàng của bạn';
            } else {
                // Lấy giá sản phẩm
                $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
                $select_price->execute([$product_id]);
                $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

                // Thêm sản phẩm vào danh sách yêu thích
                $insert_wishlist = $conn->prepare("INSERT INTO `wishlist` (id, user_id, product_id, price) VALUES (?, ?, ?, ?)");
                $insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']]);

                $success_msg[] = 'Sản phẩm đã được thêm vào danh sách yêu thích của bạn thành công';
            }
        }
    } else {
        $warning_msg[] = 'Vui lòng đăng nhập trước';
    }
}
?>
