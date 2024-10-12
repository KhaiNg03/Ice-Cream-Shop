<?php 
include '../components/connect.php';
// Khởi tạo biến thông báo
$warning_msg = [];
$success_msg = [];

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = 'location:login.php';
}
include '../components/add_cart.php'; 

if (isset($_POST['delete_item'])) {
    // Sanitize the wishlist ID
    $wishlist_id = filter_var($_POST['wishlist_id'], FILTER_SANITIZE_STRING);

    // Verify if the wishlist item exists
    $verify_delete = $conn->prepare("SELECT * FROM `wishlist` WHERE id = ?");
    $verify_delete->execute([$wishlist_id]);

    if ($verify_delete->rowCount() > 0) {
        // Delete the wishlist item
        $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
        $delete_wishlist_item->execute([$wishlist_id]);

        // Success message
        $success_msg[] = 'Sản phẩm đã được xóa khỏi danh sách yêu thích';
    } else {
        // Warning message if item does not exist
        $warning_msg[] = 'Sản phẩm đã được xóa trước đó';
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - trang danh sách yêu thích của tôi</title>
    <link rel="stylesheet" type="text/css" href="../css/user_style.css">
</head>
<body>
    <?php include '../components/user_header.php'; ?>
    <!-- slider section start -->
    <div class="products">
        <div class="heading">
            <h1>Danh sách yêu thích của tôi</h1>
            <img src="../image/separator-img.png" alt="Hình ảnh Hương Vị">
        </div>
        <div class="box-container">
        <?php 
        $grand_total = 0; 
        
        $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
        $select_wishlist->execute([$user_id]);
        
        if ($select_wishlist->rowCount() > 0) { 
            while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
                $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                $select_products->execute([$fetch_wishlist['product_id']]);
                
                if ($select_products->rowCount() > 0) { 
                    $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <form action="" method="post" class="box <?php if($fetch_products['stock'] == 0){echo 'disabled';} ?>">
                        <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
                        <img src="../uploaded_files/<?= $fetch_products['image']; ?>" alt="Hình ảnh sản phẩm" class="image">
                        <?php 
                        if($fetch_products['stock'] > 9){ 
                        ?>
                            <span class="stock" style="color: green;">Còn hàng</span>
                        <?php 
                        } elseif($fetch_products['stock'] == 0) { 
                        ?>
                            <span class="stock" style="color: red;">Hết hàng</span>
                        <?php 
                        } else { 
                        ?>
                            <span class="stock" style="color: red;">Nhanh lên, chỉ còn <?= $fetch_products['stock']; ?> sản phẩm!</span>
                        <?php 
                        } 
                        ?>
                        <div class="content">
                            <img src="../image/shape-19.png" class="shap">
                            <div class="button">
                                <div><h3><?= htmlspecialchars($fetch_products['name'], ENT_QUOTES, 'UTF-8'); ?></h3></div>
                                <div>
                                    <button type="submit" name="add_to_cart">
                                        <img src="../image/cart.webp" alt="Thêm vào giỏ hàng" width="30px" height="30px">
                                    </button>
                                    <a href="view_page.php?pid=<?= htmlspecialchars($fetch_products['id'], ENT_QUOTES, 'UTF-8'); ?>" class="bx bxs-show">
                                        <img src="../image/pokemon.webp" alt="Thêm vào giỏ hàng" width="30px" height="30px">
                                    </a>
                                    <button type="submit" name="delete_item" onclick="return confirm('Bạn có chắc chắn muốn xóa khỏi danh sách yêu thích không?');">
                                        <img src="../image/delete.png" alt="Thêm vào giỏ hàng" width="30px" height="30px">
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id'], ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="flex">
                                <p class="price">Giá <?= htmlspecialchars($fetch_products['price'], ENT_QUOTES, 'UTF-8'); ?>đ</p>
                            </div>
                            <div class="flex">
                                <input type="hidden" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
                                <a href="checkout.php?get_id=<?= htmlspecialchars($fetch_products['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn">Mua ngay</a>
                            </div>
                        </div>

                    </form>
                    <?php 
                    $grand_total += $fetch_wishlist['price'];
                } 
            } 
        } else { 
            echo '<div class="empty"><p>Chưa có sản phẩm nào được thêm vào!</p></div>';
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
