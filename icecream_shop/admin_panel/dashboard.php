<?php
    include '../components/connect.php';

    if (isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];
    } else {
        $seller_id = '';
        header('location:login.php');
        exit();
    }

    // Lấy thông tin hồ sơ người bán
    $fetch_profile = null;
    if ($conn instanceof PDO) {
        $select_profile = $conn->prepare("SELECT * FROM `sellers` WHERE id = ?");
        $select_profile->execute([$seller_id]);
        if ($select_profile->rowCount() > 0) {
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        }
    }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Trang Đăng Ký Người Bán</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
</head>
<body>    
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="dashboard">
            <div class="heading">
                <h1>Bảng Điều Khiển</h1>
                <img src="../image/separator-img.png" alt="Separator">
            </div>
            <div class="box-container">
                <div class="box">
                    <h3>Chào Mừng!</h3>
                    <p><?php echo htmlspecialchars($fetch_profile['name']); ?></p>
                    <a href="update.php" class="btn">Cập Nhật Hồ Sơ</a>
                </div>
                <div class="box">
                    <?php
                        $select_message = $conn->prepare("SELECT * FROM `message`");
                        $select_message->execute();
                        $number_of_msg = $select_message->rowCount();
                    ?>
                    <h3><?php echo $number_of_msg; ?></h3>
                    <p>Tin nhắn chưa đọc</p>
                    <a href="admin_message.php" class="btn">Xem Tin Nhắn</a>
                </div>
                <div class="box">
                    <?php
                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE `seller_id` = ?");
                        $select_products->execute([$seller_id]);
                        $number_of_products = $select_products->rowCount();
                    ?>
                    <h3><?php echo $number_of_products; ?></h3>
                    <p>Sản phẩm đã thêm</p>
                    <a href="add_products.php" class="btn">Thêm Sản Phẩm</a>
                </div>
                <div class="box">
                    <?php
                        $select_active_products = $conn->prepare("SELECT * FROM `products` WHERE `seller_id` = ? AND status = ?");
                        $select_active_products->execute([$seller_id, 'Đang bán']);
                        $number_of_active_products = $select_active_products->rowCount();
                    ?>
                    <h3><?php echo $number_of_active_products; ?></h3>
                    <p>Tổng sản phẩm đang hoạt động</p>
                    <a href="view_product.php" class="btn">Xem Các Loại Sản Phẩm</a>
                </div>
                <div class="box">
                    <?php
                        $select_deactive_products = $conn->prepare("SELECT * FROM `products` WHERE `seller_id` = ? AND status = ?");
                        $select_deactive_products->execute([$seller_id, 'Ngưng bán']);
                        $number_of_deactive_products = $select_deactive_products->rowCount();
                    ?>
                    <h3><?php echo $number_of_deactive_products; ?></h3>
                    <p>Tổng sản phẩm ngừng hoạt động</p>
                    <a href="view_product.php" class="btn">Xem Các Loại Sản Phẩm</a>
                </div>
                <div class="box">
                    <?php
                        $select_users = $conn->prepare("SELECT * FROM `users`");
                        $select_users->execute();
                        $number_of_users = $select_users->rowCount();
                    ?>
                    <h3><?= $number_of_users; ?></h3>
                    <p>Tài khoản người dùng</p>
                    <a href="user_accounts.php" class="btn">Xem Người Dùng</a>
                </div>
                <div class="box">
                    <?php
                        $select_sellers = $conn->prepare("SELECT * FROM `sellers`");
                        $select_sellers->execute();
                        $number_of_sellers = $select_sellers->rowCount();
                    ?>
                    <h3><?= $number_of_sellers; ?></h3>
                    <p>Tài khoản người bán</p>
                    <a href="user_accounts.php" class="btn">Xem Người Bán</a>
                </div>
                <div class="box">
                    <?php
                        $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE `seller_id` = ?");
                        $select_orders->execute([$seller_id]);
                        $number_of_orders = $select_orders->rowCount();
                    ?>
                    <h3><?= $number_of_orders; ?></h3>
                    <p>Tổng đơn hàng đã đặt</p>
                    <a href="admin_order.php" class="btn">Xem Đơn Hàng</a>
                </div>
                <div class="box">
                    <?php
                        $select_confirm_orders = $conn->prepare("SELECT * FROM `orders` WHERE `seller_id` = ? AND status = ?");
                        $select_confirm_orders->execute([$seller_id, 'Đã giao hàng']);
                        $number_of_confirm_orders = $select_confirm_orders->rowCount();
                    ?>
                    <h3><?= $number_of_confirm_orders; ?></h3>
                    <p>Tổng đơn hàng đã xác nhận</p>
                    <a href="admin_order.php" class="btn">Xem Đơn Hàng</a>
                </div>
                <div class="box">
                    <?php
                        $select_canceled_orders = $conn->prepare("SELECT * FROM `orders` WHERE `seller_id` = ? AND status = ?");
                        $select_canceled_orders->execute([$seller_id, 'Đã hủy']);
                        $number_of_canceled_orders = $select_canceled_orders->rowCount();
                    ?>
                    <h3><?= $number_of_canceled_orders; ?></h3>
                    <p>Tổng đơn hàng bị hủy</p>
                    <a href="admin_order.php" class="btn">Xem Đơn</a>
                </div>
            </div>
        </section>
    </div>
    <!-- Link Custom JS -->
    <script src="../js/admin_script.js"></script>
    
    <?php include '../components/alert.php'; ?>
</body>
</html>
