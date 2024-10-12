<?php 
include '../components/connect.php'; 
// Khởi tạo biến thông báo
$warning_msg = [];
$success_msg = [];
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    header('location:login.php');
    exit();
}

function formatDate($date) {
    // Chuyển đổi định dạng từ yyyy-mm-dd sang dd/mm/yyyy
    return date('d/m/Y', strtotime($date));
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Trang Đơn Hàng Người Dùng</title>
    <link rel="stylesheet" type="text/css" href="../css/user_style.css">
</head>
<body>
    <?php include '../components/user_header.php'; ?>
    
    <!-- Slider Section Start -->
    <div class="orders">
        <div class="heading">
            <h1>Đơn Hàng Của Tôi</h1>
            <img src="../image/separator-img.png" alt="Separator">
        </div>
        <div class="box-container">
            <?php 
            $select_orders = $conn->prepare("
                SELECT orders.*, products.name, products.price, products.image 
                FROM orders 
                JOIN products ON orders.product_id = products.id 
                WHERE orders.user_id = ? 
                ORDER BY orders.date DESC
            ");
            $select_orders->execute([$user_id]);

            if ($select_orders->rowCount() > 0) {
                while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="box" <?php if ($fetch_orders['status'] == 'canceled') { echo 'style="border: 2px solid red"'; } ?>>
                <a href="view_order.php?get_id=<?= htmlspecialchars($fetch_orders['id']); ?>">
                    <img src="../uploaded_files/<?= htmlspecialchars($fetch_orders['image']); ?>" class="image" alt="<?= htmlspecialchars($fetch_orders['name']); ?>">
                    <p class="date">
                        <i class="bx bxs-calendar-alt"></i> <?= formatDate($fetch_orders['date']); ?>
                    </p>
                </a>
                <div class="content">
                    <img src="../image/shape-19.png" class="shap" alt="Shape">
                    <div class="row">
                        <h3 class="name"><?= htmlspecialchars($fetch_orders['name']); ?></h3>
                        <p class="price">Giá: $<?= htmlspecialchars($fetch_orders['price']); ?>/-</p>
                        <p class="status" style="color: <?= ($fetch_orders['status'] == 'Đã giao hàng') ? 'green' : ($fetch_orders['status'] == 'Đã hủy' ? 'red' : 'orange'); ?>">
                            <?= htmlspecialchars($fetch_orders['status']); ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
                echo '<p class="empty">Chưa có đơn hàng nào được đặt</p>';
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
    <!-- Custom JS link -->
    <script src="../js/user_script.js"></script>
    
    <?php include '../components/alert.php'; ?>
</body>
</html>
