<?php
    include '../components/connect.php';
    // Khởi tạo biến thông báo
$warning_msg = [];
$success_msg = [];

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

    // Xóa tin nhắn từ cơ sở dữ liệu
    if (isset($_POST['delete_msg'])) {
        $delete_id = $_POST['delete_id'];
        $delete_id = htmlspecialchars($delete_id, ENT_QUOTES, 'UTF-8');

        // Xác minh tin nhắn có tồn tại không
        $verify_delete = $conn->prepare("SELECT * FROM `message` WHERE id = ?");
        $verify_delete->execute([$delete_id]);

        if ($verify_delete->rowCount() > 0) {
            $delete_msg = $conn->prepare("DELETE FROM `message` WHERE id = ?");
            $delete_msg->execute([$delete_id]);

            $success_msg[] = 'Đã xóa tin nhắn thành công';
        } else {
            $warning_msg[] = 'Tin nhắn đã bị xóa hoặc không tồn tại';
        }
    }

    // Cập nhật trạng thái thanh toán của đơn hàng
    if (isset($_POST['update_order'])) {
        // Lấy dữ liệu từ POST và xử lý htmlspecialchars
        $order_id = htmlspecialchars($_POST['order_id'], ENT_QUOTES, 'UTF-8');
        $update_payment = htmlspecialchars($_POST['update_payment'], ENT_QUOTES, 'UTF-8');
    
        // Cập nhật trạng thái thanh toán
        $update_pay = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
        $update_pay->execute([$update_payment, $order_id]);
    
        // Thông báo thành công
        $success_msg[] = 'Đã cập nhật trạng thái thanh toán đơn hàng';
    }

    // Xóa đơn hàng
    if (isset($_POST['delete_order'])) {
        // Lấy dữ liệu từ POST và xử lý htmlspecialchars
        $delete_id = htmlspecialchars($_POST['order_id'], ENT_QUOTES, 'UTF-8');
    
        // Xác minh đơn hàng có tồn tại không
        $verify_delete = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
        $verify_delete->execute([$delete_id]);
    
        if ($verify_delete->rowCount() > 0) {
            // Xóa đơn hàng
            $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
            $delete_order->execute([$delete_id]);
        
            // Thông báo thành công
            $success_msg[] = 'Đã xóa đơn hàng thành công';
        } else {
            // Thông báo cảnh báo
            $warning_msg[] = 'Đơn hàng đã bị xóa hoặc không tồn tại';
        }
    }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Trang đăng ký người bán</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
</head>
<body>    
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="order-container">
            <div class="heading">
                <h1>Tổng số đơn hàng đã đặt</h1>
                <img src="../image/separator-img.png" alt="Separator">
            </div>
            <div class="box-container">
                <?php
                $select_order = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ?");
                $select_order->execute([$seller_id]);

                if ($select_order->rowCount() > 0) {
                    while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)){
                ?>
                <div class="box">
                    <div class="status" style="color: <?php echo ($fetch_order['status'] == "Đã giao hàng") ? "limegreen" : "red"; ?>;">
                        <?= htmlspecialchars($fetch_order['status']); ?>
                    </div>     
                    <div class="details">
                        <p>Tên người dùng: <span><?= htmlspecialchars($fetch_order['name']); ?></span></p>
                        <p>ID người dùng: <span><?= htmlspecialchars($fetch_order['user_id']); ?></span></p>
                        <p>Ngày đặt hàng: <span><?= date('d/m/Y', strtotime($fetch_order['date'])); ?></span></p>

                        <p>Số điện thoại người dùng: <span><?= htmlspecialchars($fetch_order['number']); ?></span></p>
                        <p>Email người dùng: <span><?= htmlspecialchars($fetch_order['email']); ?></span></p>
                        <p>Tổng giá: <span><?= htmlspecialchars($fetch_order['price']); ?>
                    </span></p>
                        <p>Phương thức thanh toán: <span><?= htmlspecialchars($fetch_order['method']); ?></span></p>
                        <p>Địa chỉ người dùng: <span><?= htmlspecialchars($fetch_order['address']); ?></span></p>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">
                        <select name="update_payment" class="box" style="width: 90%;">
                            <option disabled selected><?= htmlspecialchars($fetch_order['payment_status']); ?></option>
                            <option value="Chờ xử lý">Chờ xử lý</option>
                            <option value="Đã giao hàng">Đã giao hàng</option>
                        </select>

                        <div class="flex-btn">
                            <button type="submit" name="update_order" value="Cập nhật đơn" class="btn">Cập nhật đơn</button>
                            <button type="submit" name="delete_order" value="Xóa đơn" class="btn">Xóa đơn</button>
                        </div>
                    </form>
                </div>
                <?php
                    }
                } else {
                    echo '<div class="empty"><p>Không tìm thấy đơn hàng nào cho người bán này.</p></div>';
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
    <!-- Liên kết JS tùy chỉnh -->
    <script src="../js/admin_script.js"></script>
    
    <?php include '../components/alert.php'; ?>
</body>
</html>
