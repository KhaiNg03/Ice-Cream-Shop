<?php
// Khởi tạo biến thông báo
$warning_msg = [];
$success_msg = [];
    include '../components/connect.php';

    if (isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];
    } else {
        $seller_id = '';
        header('location:login.php');
    }
    // xóa sản phẩm

    if (isset($_POST['delete'])) {
        $p_id = htmlspecialchars($_POST['product_id']); 
        $p_id = filter_var($p_id); 
        $delete_product = $conn->prepare('DELETE FROM `products` WHERE id = ?'); 
        $delete_product->execute([$p_id]); 
        $success_msg[] = 'Sản phẩm đã được xóa thành công'; 
    }

?>
    

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Trang Hiển Thị Sản Phẩm</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">

</head>
<body>    
<div class="main-container">
    <?php include '../components/admin_header.php'; ?>
    <section class="show-post">
        <div class="heading">
            <h1>Sản phẩm của bạn</h1>
            <img src="../image/separator-img.png" alt="Hình ảnh phân cách">
        </div>
        <div class="box-container">
            <?php 
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ?");
            $select_products->execute([$seller_id]);

            if ($select_products->rowCount() > 0) {
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                    // Hiển thị chi tiết sản phẩm
            ?>
            <form action="" method="post" class="box">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">
                <?php if (!empty($fetch_products['image'])) { ?>
                    <img src="../uploaded_files/<?= htmlspecialchars($fetch_products['image']); ?>" class="image"><?php } ?>
                <div class="status" style="color: <?php if($fetch_products['status'] == 'Đang bán') {echo 'limegreen';}else{echo 'coral';} ?>"><?= htmlspecialchars($fetch_products['status']); ?>
                </div>
                <div class="price"><?= htmlspecialchars($fetch_products['price']); ?>đ</div>
                <div class="content">
                    <img src="../image/shape-19.png" class="shap" alt="Hình dạng">
                    <div class="title"><?= htmlspecialchars($fetch_products['name']); ?></div>
                    <div class="flex-btn">
                        <a href="edit_product.php?id=<?= htmlspecialchars($fetch_products['id']); ?>" class="btn">Sửa</a>
                        <button type="submit" name="delete" class="btn" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</button>
                        <a href="read_product.php?post_id=<?= htmlspecialchars($fetch_products['id']); ?>" class="btn">Đọc</a>
                    </div>
                </div>
            </form>
            <?php
                    }
                } else {
                    echo '
                        <div class="empty">
                            <p>Chưa có sản phẩm nào được thêm! <br><a href="add_products.php" class="btn" style="margin-top: 1.5rem; line-height:2;">Thêm sản phẩm</a></p>
                        </div>
                    ';
                }
            ?>
        </div>
    </section>
</div>
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
    <!-- custom js link -->
    <script src="../js/admin_script.js"></script>
    
    <?php include '../components/alert.php'; ?>
</body>
</html>
