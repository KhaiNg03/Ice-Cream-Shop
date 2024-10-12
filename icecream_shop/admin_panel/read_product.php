<?php
include '../components/connect.php';

if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    $seller_id = '';
    header('location:login.php');
    exit(); // Thêm exit để ngăn chặn việc tiếp tục thực hiện mã nếu không đăng nhập
}

$get_id = isset($_GET['post_id']) ? htmlspecialchars($_GET['post_id']) : '';
if (isset($_POST['delete'])) {

    $p_id = htmlspecialchars($_POST['product_id']);

    $delete_image = $conn->prepare("SELECT * FROM `products` WHERE id = ? AND seller_id = ?");
    $delete_image->execute([$p_id, $seller_id]);
    $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

    if ($fetch_delete_image && !empty($fetch_delete_image['image'])) {
        unlink("../uploaded_files/" . $fetch_delete_image['image']);
    }

    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ? AND seller_id = ?");
    $delete_product->execute([$p_id, $seller_id]);

    header("Location: view_product.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Hiển Thị Chi Tiết Sản Phẩm</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
</head>
<body>    
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="read-post">
            <div class="heading">
                <h1>Chi Tiết Sản Phẩm</h1>
                <img src="../image/separator-img.png" alt="Ảnh Ngăn Cách">
            </div>
            <div class="box-container">
                <?php
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? AND seller_id = ?");
                $select_product->execute([$get_id, $seller_id]);

                if ($select_product->rowCount() > 0) {
                    while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_product['id']); ?>">
                    <div class="status" style="color: <?= ($fetch_product['status'] == 'active') ? 'limegreen' : 'coral'; ?>">
                        <?= htmlspecialchars($fetch_product['status']); ?>
                    </div>
                    <?php if (!empty($fetch_product['image'])) { ?>
                        <img src="../uploaded_files/<?= htmlspecialchars($fetch_product['image']); ?>" alt="Ảnh Sản Phẩm">
                    <?php } ?>
                    <div class="price">$<?= htmlspecialchars($fetch_product['price']); ?>/-</div>
                    <div class="title"><?= htmlspecialchars($fetch_product['name']); ?></div>
                    <div class="content"><?= htmlspecialchars($fetch_product['product_detail']); ?></div>
                    <div class="flex-btn">
                        <a href="edit_product.php?id=<?= htmlspecialchars($fetch_product['id']); ?>" class="btn">Chỉnh Sửa</a>
                        <button type="submit" name="delete" class="btn" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</button>
                        <a href="view_product.php?post_id=<?= htmlspecialchars($fetch_product['id']); ?>" class="btn">Quay Lại</a>
                    </div>
                </form>
                <?php   
                    }
                } else {
                    echo '
                    <div class="empty">
                        <p>Chưa có sản phẩm nào được thêm! <br><a href="add_products.php" class="btn" style="margin-top: 1.5rem">Thêm Sản Phẩm</a></p>
                    </div>';
                }
                ?>
            </div>
        </section>
    </div>
    <!-- Custom JS link -->
    <script src="../js/admin_script.js"></script>
    
    <?php include '../components/alert.php'; ?>
</body>
</html>
