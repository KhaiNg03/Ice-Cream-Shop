<?php
    include '../components/connect.php';

    if (isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];
    } else {
        $seller_id = '';
        header('location:login.php');
        exit();
    }

    // Fetch seller profile
    $fetch_profile = null;
    if ($conn instanceof PDO) {
        $select_profile = $conn->prepare("SELECT * FROM `sellers` WHERE id = ?");
        $select_profile->execute([$seller_id]);
        if ($select_profile->rowCount() > 0) {
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        }
    }
    $select_products = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ?");
    $select_products->execute([$seller_id]);

    $total_products = $select_products->rowCount();

    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ?");
    $select_orders->execute([$seller_id]);

    $total_orders = $select_orders->rowCount();

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Trang Hồ Sơ Người Bán</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
</head>
<body>    
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="seller-profile">
            <div class="heading">
                <h1>Thông Tin Hồ Sơ</h1>
                <img src="../image/separator-img.png" alt="Separator">
            </div>
            <div class="details">
                <div class="seller">
                    <img src="../uploaded_files/<?= htmlspecialchars($fetch_profile['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Ảnh Người Bán">
                    <h3 class="name"><?= htmlspecialchars($fetch_profile['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                    <span>Người Bán</span>
                    <a href="update.php" class="btn">Cập Nhật Hồ Sơ</a>
                </div>
                <div class="flex">
                    <div class="box">
                        <span><?= htmlspecialchars($total_products, ENT_QUOTES, 'UTF-8'); ?></span>
                        <p>Tổng Sản Phẩm</p>
                        <a href="view_product.php" class="btn">Xem Sản Phẩm</a>
                    </div>
                    <div class="box">
                        <span><?= htmlspecialchars($total_orders, ENT_QUOTES, 'UTF-8'); ?></span>
                        <p>Tổng Đơn Hàng Đã Đặt</p>
                        <a href="admin_order.php" class="btn">Xem Đơn Hàng</a>
                    </div>
                </div>
            </div>

        </section>
    </div>

    <!-- Custom JS link -->
    <script src="../js/admin_script.js"></script>
    
    <?php include '../components/alert.php'; ?>
</body>
</html>
