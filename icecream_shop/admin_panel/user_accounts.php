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

    // Fetch seller profile
    $fetch_profile = null;
    if ($conn instanceof PDO) {
        $select_profile = $conn->prepare("SELECT * FROM `sellers` WHERE id = ?");
        $select_profile->execute([$seller_id]);
        if ($select_profile->rowCount() > 0) {
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        }
    }
    // Xóa tin nhắn khỏi cơ sở dữ liệu
    if (isset($_POST['delete_msg'])) {
        $delete_id = $_POST['delete_id'];
        $delete_id = htmlspecialchars($delete_id, ENT_QUOTES, 'UTF-8');

        // Xác minh rằng tin nhắn tồn tại
        $verify_delete = $conn->prepare("SELECT * FROM `message` WHERE id = ?");
        $verify_delete->execute([$delete_id]);

        if ($verify_delete->rowCount() > 0) {
            $delete_msg = $conn->prepare("DELETE FROM `message` WHERE id = ?");
            $delete_msg->execute([$delete_id]);

            $success_msg[] = 'Tin nhắn đã được xóa thành công';
        } else {
            $warning_msg[] = 'Tin nhắn đã bị xóa hoặc không tồn tại';
        }
    }

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Trang người dùng đã đăng ký</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
</head>
<body>    
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="user-container">
            <div class="heading">
                <h1>Người dùng đã đăng ký</h1>
                <img src="../image/separator-img.png" alt="Separator">
            </div>
            <div class="box-container">
                <?php
                    $select_users = $conn->prepare("SELECT * FROM `users`");
                    $select_users->execute();
    
                    if ($select_users->rowCount() > 0) {
                        while ($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)) {
                            $user_id = htmlspecialchars($fetch_users['id'], ENT_QUOTES, 'UTF-8');
                ?>
                <div class="box">
                    <img src="../uploaded_files/<?= htmlspecialchars($fetch_users['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Hình ảnh người dùng">
                    <p>ID người dùng: <span><?= htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8'); ?></span></p>
                    <p>Tên người dùng: <span><?= htmlspecialchars($fetch_users['name'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                    <p>Email người dùng: <span><?= htmlspecialchars($fetch_users['email'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                </div>
                <?php
                        }
                    } else {
                        echo '
                            <div class="empty">
                                <p>Chưa có tin nhắn nào chưa đọc! <br><a href="admin_message.php" class="btn" style="margin-top: 1.5rem; line-height:2;">Đi đến tin nhắn</a></p>
                            </div>
                        ';
                    }
                ?>
            <div>
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
    <!-- Custom JS link -->
    <script src="../js/admin_script.js"></script>

    <!-- Custom JS link -->
    <script src="../js/admin_script.js"></script>
    
    <?php include '../components/alert.php'; ?>
</body>
</html>
