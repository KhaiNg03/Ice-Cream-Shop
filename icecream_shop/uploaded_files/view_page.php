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
// Include necessary files
include '../components/add_wishlist.php';
include '../components/add_cart.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Trang chi tiết sản phẩm</title>
    <link rel="stylesheet" type="text/css" href="../css/user_style.css">
</head>
<body>
    <?php include '../components/user_header.php'; ?>
    <!-- slider section start -->
    <section class="view_page">
        <div class="heading">
            <h1>Chi tiết Sản phẩm</h1>
            <img src="../image/separator-img.png" alt="Hình ảnh phân cách">
        </div>
        <?php
        if (isset($_GET['pid'])) {
            $pid = $_GET['pid'];
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_products->execute([$pid]);
            if ($select_products->rowCount() > 0) {
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <form action="" method="post" class="box">
                        <div class="img-box">
                            <img src="../uploaded_files/<?= $fetch_products['image']; ?>" alt="Hình ảnh sản phẩm">
                        </div>
                        <div class="detail">
                            <?php if ($fetch_products['stock'] > 9) { ?>
                                <span class="stock" style="color:green;">Còn hàng</span>
                            <?php } elseif ($fetch_products['stock'] == 0) { ?>
                                <span class="stock" style="color:red;">Hết hàng</span>
                            <?php } else { ?>
                                <span class="stock" style="color:red;">Nhanh lên, chỉ còn <?= $fetch_products['stock']; ?> sản phẩm</span>
                            <?php } ?>
                            <p class="price">$<?= $fetch_products['price']; ?>/-</p>
                            <div class="name"><?= $fetch_products['name']; ?></div>
                            <p class="product-detail"><?= $fetch_products['product_detail']; ?></p>
                            <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                            <div class="button">
                                <button type="submit" name="add_to_wishlist" class="btn">Thêm vào danh sách yêu thích <i class="bx bx-heart">
                                <input type="hidden" name="qty" value="1" min="6" class="quantity">
                                <button type="submit" name="add_to_cart" class="btn">Thêm vào giỏ hàng <i class="bx bx-cartf"></i> </button>
                            </div>
                        </div>
                    </form>
                            
                    <?php
                }
            }
        }
        ?>
    </section>
    <div class="products">

        <div class="heading">
            <h1>Sản phẩm tương tự</h1>
            <img src="../image/separator-img.png" alt="Hình ảnh phân cách">
        </div>

        <?php include '../components/shop.php'; ?>

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
