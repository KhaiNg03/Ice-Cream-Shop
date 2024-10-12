<?php 
include '../components/connect.php'; 
// Khởi tạo biến thông báo
$warning_msg = [];
$success_msg = [];
// Define log file path
$log_file = '../logs/cart_actions.log'; // Make sure this path is correct and writable

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    header('Location: login.php');
    exit();
}

if (isset($_POST['update_cart'])) {
    // Get and sanitize input
    $cart_id = htmlspecialchars($_POST['cart_id'], ENT_QUOTES, 'UTF-8');
    $qty = htmlspecialchars($_POST['qty'], ENT_QUOTES, 'UTF-8');

    // Validate quantity as an integer
    $qty = filter_var($qty, FILTER_VALIDATE_INT);

    // Check if the quantity is valid
    if ($qty === false || $qty < 1) {
        $error_msg[] = 'Số lượng không hợp lệ.';
    } else {
        // Update the cart quantity
        $update_qty = $conn->prepare("UPDATE `cart` SET qty = ? WHERE id = ?");
        $update_qty->execute([$qty, $cart_id]);

        // Success message
        $success_msg[] = 'Cập nhật số lượng giỏ hàng thành công.';
    }
}

// Delete products from cart
if (isset($_POST['delete_item'])) {
    // Get and sanitize input
    $cart_id = htmlspecialchars($_POST['cart_id'], ENT_QUOTES, 'UTF-8');    
    // Check if the cart_id is valid
    if ($cart_id === false) {
        $error_msg[] = 'Mặt hàng giỏ hàng không hợp lệ.';
    } else {
        // Verify the item exists in the cart
        $verify_delete_item = $conn->prepare("SELECT * FROM `cart` WHERE id = ?");
        $verify_delete_item->execute([$cart_id]);

        // If the item exists, delete it
        if ($verify_delete_item->rowCount() > 0) {
            $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
            $delete_cart_id->execute([$cart_id]);

            $success_msg[] = 'Mặt hàng giỏ hàng đã được xóa thành công.';
        } else {
            $warning_msg[] = 'Mặt hàng giỏ hàng đã được xóa hoặc không tồn tại.';
        }
    }
}

if (isset($_POST['empty_cart'])) {
    // Check if the cart contains products
    $verify_empty_item = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $verify_empty_item->execute([$user_id]);

    if ($verify_empty_item->rowCount() > 0) {
        // Delete all products from the cart
        $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
        $delete_cart_id->execute([$user_id]);

        // Success message
        $success_msg[] = 'Giỏ hàng đã được làm trống.';
        error_log("Giỏ hàng đã được làm trống: User ID $user_id\n", 3, $log_file);
    } else {
        // Warning message if cart is already empty
        $warning_msg[] = 'Giỏ hàng của bạn đã trống.';
        error_log("Giỏ hàng đã trống: User ID $user_id\n", 3, $log_file);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Trang Giỏ Hàng</title>
    <link rel="stylesheet" type="text/css" href="../css/user_style.css">
</head>
<body>
    <?php include '../components/user_header.php'; ?>
    <!-- slider section start -->
    <div class="products">
        <div class="heading">
            <h1>Giỏ Hàng Của Tôi</h1>
            <img src="../image/separator-img.png" alt="Hình Ảnh Phân Cách">
        </div>
        <div class="box-container">
        <?php 
            $grand_total = 0; // Initialize grand_total
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);

            if ($select_cart->rowCount() > 0) { 
                while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                    $select_products->execute([$fetch_cart['product_id']]);
                
                    if ($select_products->rowCount() > 0) { 
                        $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC); 
                        $sub_total = $fetch_cart['qty'] * $fetch_products['price'];
                        $grand_total += $sub_total;
                        ?>
                        <form action="" method="post" class="box <?php if ($fetch_products['stock'] == 0) { echo 'disabled'; } ?>">
                            <input type="hidden" name="cart_id" value="<?= htmlspecialchars($fetch_cart['id'], ENT_QUOTES, 'UTF-8'); ?>">
                            <img src="../uploaded_files/<?= htmlspecialchars($fetch_products['image'], ENT_QUOTES, 'UTF-8'); ?>" class="image" alt="Hình Ảnh Sản Phẩm">
                    
                            <?php 
                            if ($fetch_products['stock'] > 9) { 
                            ?>
                                <span class="stock" style="color: green;">Còn hàng</span>
                            <?php 
                            } elseif ($fetch_products['stock'] == 0) { 
                            ?>
                                <span class="stock" style="color: red;">Hết hàng</span>
                            <?php 
                            } else { 
                            ?>
                                <span class="stock" style="color: red;">Nhanh lên, chỉ còn <?= htmlspecialchars($fetch_products['stock'], ENT_QUOTES, 'UTF-8'); ?> sản phẩm</span>
                            <?php 
                            } 
                            ?>

                            <div class="content">
                                <img src="../image/shape-19.png" class="shap" alt="Hình Ảnh Hình Dạng">
                                <h3 class="name"><?= htmlspecialchars($fetch_products['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                <div class="flex-btn">
                                    <p class="price">Giá <?= htmlspecialchars($fetch_products['price'], ENT_QUOTES, 'UTF-8'); ?>đ</p>
                                    <input type="number" name="qty" required min="1" value="<?= htmlspecialchars($fetch_cart['qty'], ENT_QUOTES, 'UTF-8'); ?>" max="99" maxlength="2" class="box qty">
                                    <button type="submit" name="update_cart" class="bx bxs-edit fa-edit box">Cập nhật</button>
                                </div>
                                <div class="flex-btn">
                                    <p class="sub-total">Tổng phụ: <span><?= $sub_total; ?>đ</span></p>
                                    <button type="submit" name="delete_item" class="btn" onclick="return confirm('Xóa khỏi giỏ hàng?');">Xóa</button>
                                </div>
                            </div>
                        </form>
                        <?php 
                    } 
                }
            } else {
                echo '<div class="empty"><p>Chưa có sản phẩm nào được thêm!</p></div>';
            }
            ?>
        </div>
        <?php if ($grand_total > 0) { ?>
            <div class="cart-total">
                <p>Tổng số tiền thanh toán: <span><?= $grand_total; ?>đ</span></p>
                <div class="button">
                    <form action="" method="post">
                        <button type="submit" name="empty_cart" class="btn" onclick="return confirm('Bạn có chắc muốn làm trống giỏ hàng?');">Làm Trống Giỏ Hàng</button>
                    </form>
                    <a href="checkout.php" class="btn">Tiến Hành Thanh Toán</a>
                </div>
            </div>
        <?php } ?>
            
    </div>
    <?php include '../components/footer.php'; ?>
    <!-- Your content goes here -->
         <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modal-message"></p>
        </div>
    </div>

    <script>
        // Hiển thị modal với thông báo
        function showModal(message) {
            document.getElementById('modal-message').innerText = message;
            document.getElementById('myModal').style.display = "block";
        }

        // Đóng modal khi nhấn nút "X"
        document.querySelector('.close').onclick = function() {
            document.getElementById('myModal').style.display = "none";
        }

        // Đóng modal khi nhấn ra ngoài modal
        window.onclick = function(event) {
            if (event.target == document.getElementById('myModal')) {
                document.getElementById('myModal').style.display = "none";
            }
        }

        // Hiển thị thông báo khi có thông báo thành công hoặc cảnh báo
        <?php if (!empty($warning_msg)) { ?>
            showModal('<?php echo implode("\\n", $warning_msg); ?>');
        <?php } elseif (!empty($success_msg)) { ?>
            showModal('<?php echo implode("\\n", $success_msg); ?>');
        <?php } ?>
    </script>
    <!-- Custom JS link -->
    <script src="../js/user_script.js"></script>
</body>
</html>
