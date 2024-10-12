<?php 
include '../components/connect.php';
// Khởi tạo biến thông báo
$warning_msg = [];
$success_msg = [];

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}
include '../components/add_wishlist.php';
include '../components/add_cart.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Trang Cửa Hàng của Chúng Tôi</title>
    <link rel="stylesheet" type="text/css" href="../css/user_style.css">
<body>
    <?php include '../components/user_header.php'; ?>
    <!-- slider section start -->
    <div class="products">
        <div class="heading">
            <h1>Hương Vị Mới Nhất</h1>
            <img src="../image/separator-img.png" alt="Hình ảnh Hương Vị">
        </div>
        <div class="box-container">
        <?php
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE status = 'Đang bán'");
            $select_products->execute();

            if ($select_products->rowCount() > 0) {
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <form action="" method="post" class="box <?php echo $fetch_products['stock'] == 0 ? 'Ngưng bán' : ''; ?>">
                        <?php if (!empty($fetch_products['image'])) { ?>
                            <img src="../uploaded_files/<?= htmlspecialchars($fetch_products['image']); ?>" alt="Hình ảnh Sản Phẩm" class="image">
                            <?php if ($fetch_products['stock'] > 9) { ?>
                            <span class="stock" style="color: green;">Còn hàng</span>
                        <?php } elseif ($fetch_products['stock'] == 0) { ?>
                            <span class="stock" style="color: red;">Hết hàng</span>
                        <?php } else { ?>
                            <span class="stock" style="color: red;">Nhanh lên, chỉ còn <?= htmlspecialchars($fetch_products['stock']); ?> cái!</span>
                        <?php } ?>
                        <?php } ?>
                        <div class="content">
                            <img src="../image/shape-19.png" alt="" class="shap">
                            <div class="button">
                                <div>
                                    <h3 class="name"><?= htmlspecialchars($fetch_products['name']); ?></h3>
                                </div>
                                <div>
                                    <button type="submit" name="add_to_cart">                                        
                                        <img src="../image/cart.webp" alt="Thêm vào giỏ hàng" width="25px" height="25px"></button>
                                    <button type="submit" name="add_to_wishlist">
                                        <img src="../image/heart.webp" alt="Heart" style="width: 25px; height: 25px;">
                                    </button>
                                    <a href="view_page.php?pid=<?= htmlspecialchars($fetch_products['id']); ?>" class="bx bxs-show">
                                    <img src="../image/pokemon.webp" alt="Thêm vào giỏ hàng" width="25px" height="25px">
                                    </a>
                                </div>
                            </div>
                            <p class="price">Giá: $<?= htmlspecialchars($fetch_products['price']); ?></p>
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">

                            <div class="flex-btn">
                                <a href="checkout.php?get_id=<?= htmlspecialchars($fetch_products['id']); ?>" class="btn">Mua Ngay</a>
                                <input type="number" name="qty" required min="1" value="1" max="99" class="qty box">
                            </div>

                        </div>              
                    </form>
            <?php
                }
            } else {
                echo '
                    <div class="empty">
                        <p>Chưa có sản phẩm nào được thêm!</p>
                    </div>
                ';
            }
        ?>
        </div>
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
    
    <?php include '../components/alert.php'; ?>
</body>
</html>
