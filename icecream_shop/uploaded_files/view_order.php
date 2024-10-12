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
if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = 3;
    header("location: order.php");
}
if (isset($_POST['Hủy'])) {
    $update_order = $conn->prepare("UPDATE orders SET status = 'Đã hủy' WHERE id = ?");
    $update_order->execute([$get_id]);
    header("location: order.php");
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Trang chi tiết đơn hàng</title>
    <link rel="stylesheet" type="text/css" href="../css/user_style.css">
</head>
<body>
    <?php include '../components/user_header.php'; ?>
    <!-- slider section start -->
    <div class="order-detail">
        <div class="heading">
            <h1>Chi tiết đơn hàng của tôi</h1>
            <img src="../image/separator-img.png">
        </div>
        <div class="box-container">
            <?php 
            $grand_total = 0;
            $select_order = $conn->prepare("SELECT * FROM `orders` WHERE id = ? LIMIT 1");
            $select_order->execute([$get_id]);
            if ($select_order->rowCount() > 0) {
                while ($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)) {
                    $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
                    $select_product->execute([$fetch_order['product_id']]);
                    if ($select_product->rowCount() > 0) {
                        while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                            $sub_total = ($fetch_order['price'] * $fetch_order['qty']);
                            $grand_total += $sub_total;

                            // Format the date to Vietnamese format
                            $date = new DateTime($fetch_order['date']);
                            $formatted_date = $date->format('d/m/Y');
            ?>
                            <div class="box">
                                <div class="col">
                                    <p class="title"><i class="bx bxs-calendar-alt"></i><?= htmlspecialchars($formatted_date); ?></p>
                                    <img src="../uploaded_files/<?= htmlspecialchars($fetch_product['image']); ?>" class="image" alt="Hình ảnh sản phẩm">
                                    <p class="price">$<?= htmlspecialchars($fetch_product['price']); ?>/-</p>
                                    <h3 class="name"><?= htmlspecialchars($fetch_product['name']); ?></h3>
                                    <p class="grand-total">Tổng số tiền phải trả: <span>$<?= htmlspecialchars($grand_total); ?>/-</span></p>
                                </div>
                                <div class="col">
                                    <p class="title">Địa chỉ thanh toán</p>
                                    <p class="user"><i class="bi bi-person-bounding-box"></i><?= htmlspecialchars($fetch_order['name']); ?></p>
                                    <p class="user"><i class="bi bi-phone"></i><?= htmlspecialchars($fetch_order['number']); ?></p>
                                    <p class="user"><i class="bi bi-envelope"></i><?= htmlspecialchars($fetch_order['email']); ?></p>
                                    <p class="user"><i class="bi bi-pin-map-fill"></i><?= htmlspecialchars($fetch_order['address']); ?></p>
                                    <p class="status" style="color:<?php 
                                        if ($fetch_order['status'] == 'Đã giao hàng') { 
                                            echo 'green'; 
                                        } elseif ($fetch_order['status'] == 'Đã hủy') { 
                                            echo 'red'; 
                                        } else { 
                                            echo 'orange'; 
                                        } 
                                    ?>"><?= htmlspecialchars($fetch_order['status']); ?></p>
                                    <?php if ($fetch_order['status'] == 'Đã hủy') { ?>
                                        <a href="checkout.php?get_id=<?= htmlspecialchars($fetch_product['id']); ?>" class="btn" style="Line-height: 3;">Đặt hàng lại</a>
                                    <?php } else { ?>
                                        <form action="" method="post">
                                            <button type="submit" name="Hủy" class="btn" onclick="return confirm('Bạn có muốn hủy sản phẩm này không?');">Hủy</button>
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
            <?php 
                        }
                    }
                }
            } else { 
                echo '<p class="empty">Chưa có đơn hàng nào được đặt</p>';
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
