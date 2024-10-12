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
    <title>Blue Sky Summer - Cửa Hàng Của Chúng Tôi</title>
    <link rel="stylesheet" type="text/css" href="../css/user_style.css">
</head>
<body>
    <?php include '../components/user_header.php'; ?>
    <!-- Phần sản phẩm bắt đầu -->
    <div class="products">
        <div class="heading">
            <h1>Hương Vị Mới Nhất</h1>
            <img src="../image/separator-img.png" alt="Hình ảnh Hương Vị">
        </div>
        <div class="box-container">
        <?php
            // Kiểm tra nếu có danh mục được chọn
            if (isset($_GET['category'])) {
                $category = htmlspecialchars($_GET['category'], ENT_QUOTES, 'UTF-8');
                // Truy vấn sản phẩm theo danh mục
                $select_products = $conn->prepare("SELECT * FROM products WHERE category = ? AND status = ?");
                $select_products->execute([$category, 'Đang bán']);
            } else {
                // Nếu không có danh mục, thực hiện tìm kiếm sản phẩm
                if (isset($_POST['search_product']) || isset($_POST['search_product_btn'])) {
                    $search_products = $_POST['search_product'];
                    $search_products = htmlspecialchars($search_products, ENT_QUOTES, 'UTF-8');

                    $select_products = $conn->prepare("SELECT * FROM products WHERE name LIKE ? AND status = ?");
                    $search_term = "%{$search_products}%";
                    $select_products->execute([$search_term, 'Đang bán']);
                } else {
                    $select_products = $conn->prepare("SELECT * FROM products WHERE status = 'Đang bán'");
                    $select_products->execute();
                }
            }

            if ($select_products->rowCount() > 0) {
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                    $product_id = htmlspecialchars($fetch_products['id'], ENT_QUOTES, 'UTF-8');
                    $product_name = htmlspecialchars($fetch_products['name'], ENT_QUOTES, 'UTF-8');
                    $product_price = htmlspecialchars($fetch_products['price'], ENT_QUOTES, 'UTF-8');
                    $product_image = htmlspecialchars($fetch_products['image'], ENT_QUOTES, 'UTF-8');
                    $product_stock = htmlspecialchars($fetch_products['stock'], ENT_QUOTES, 'UTF-8');
        ?>
                    <form action="" method="post" class="box <?= $product_stock == 0 ? 'disabled' : ''; ?>">
                        <?php if (!empty($product_image)) { ?>
                            <img src="../uploaded_files/<?= $product_image; ?>" alt="Product Image" class="image">
                            <?php if ($product_stock > 9) { ?>
                                <span class="stock" style="color: green;">Còn hàng</span>
                            <?php } elseif ($product_stock == 0) { ?>
                                <span class="stock" style="color: red;">Hết hàng</span>
                            <?php } else { ?>
                                <span class="stock" style="color: red;">Nhanh lên chỉ còn <?= $product_stock; ?> cái!</span>
                            <?php } ?>
                        <?php } ?>
                        <div class="content">
                            <img src="../image/shape-19.png" alt="" class="shap">
                            <div class="button">
                                <div>
                                    <h3 class="name"><?= $product_name; ?></h3>
                                </div>
                                <div>
                                    <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                                    <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                                    <a href="view_page.php?pid=<?= $product_id; ?>" class="bx bxs-show"></a>
                                </div>
                            </div>
                            <p class="price">Giá: <?= $product_price; ?>đ</p>
                            <input type="hidden" name="product_id" value="<?= $product_id; ?>">

                            <div class="flex-btn">
                                <a href="checkout.php?get_id=<?= $product_id; ?>" class="btn">Mua Ngay</a>
                                <input type="number" name="qty" required min="1" value="1" max="99" class="qty box">
                            </div>
                        </div>              
                    </form>
        <?php
                }
            } else {
                echo '
                    <div class="empty">
                        <p>Chưa có sản phẩm nào được thêm vào!</p>
                    </div>
                ';
            }
        ?>
        </div>
    </div>

    <?php include '../components/footer.php'; ?>
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
    <!-- Liên kết JS tùy chỉnh -->
    <script src="../js/user_script.js"></script>
    <?php include '../components/alert.php'; ?>
</body>
</html>
