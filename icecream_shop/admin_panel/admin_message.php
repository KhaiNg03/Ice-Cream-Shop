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

    // Lấy thông tin người bán
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

        // Kiểm tra tin nhắn có tồn tại không
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
    <title>Blue Sky Summer - Trang đăng ký người bán</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
</head>
<body>    
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="message-container">
            <div class="heading">
                <h1>Tin nhắn chưa đọc</h1>
                <img src="../image/separator-img.png" alt="Separator">
            </div>
            <div class="box-container">
            <?php
                $select_message = $conn->prepare("SELECT * FROM `message`");
                $select_message->execute();
                if ($select_message->rowCount() > 0) {
                    while ($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="box">
                <h3 class="name"><?= htmlspecialchars($fetch_message['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                <h4><?= htmlspecialchars($fetch_message['subject'], ENT_QUOTES, 'UTF-8'); ?></h4>
                <p><?= htmlspecialchars($fetch_message['message'], ENT_QUOTES, 'UTF-8'); ?></p>
                <form action="" method="post">
                    <input type="hidden" name="delete_id" value="<?= htmlspecialchars($fetch_message['id']); ?>">
                    <button type="submit" name="delete_msg" value="Xóa tin nhắn" class="btn" onclick="return confirm('Bạn có chắc chắn muốn xóa tin nhắn này không?');">Xóa tin nhắn</button>
                </form>
                </div>
                <?php
                    }
                } else {
                    echo '
                        <div class="empty">
                            <p>Chưa có tin nhắn nào chưa đọc! <br><a href="admin_message.php" class="btn" style="margin-top: 1.5rem; line-height:2;">Đi tới tin nhắn</a></p>
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
    <script src="../js/admin_script.js"></script>
    
    <?php include '../components/alert.php'; ?>
</body>
</html>
