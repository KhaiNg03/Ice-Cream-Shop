<?php
include '../components/connect.php';
// Khởi tạo biến thông báo
$warning_msg = [];
$success_msg = [];
if (isset($_POST['submit'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = $_POST['pass'];

    $select_seller = $conn->prepare("SELECT * FROM `sellers` WHERE email = ?");
    $select_seller->execute([$email]);
    $row = $select_seller->fetch(PDO::FETCH_ASSOC);

    // So sánh trực tiếp mật khẩu không mã hóa
    if ($row && $pass === $row['password']) {
        setcookie('seller_id', $row['id'], time() + (60*60*24*30), '/');
        header('location:dashboard.php');
        exit;
    } else {
        $warning_msg[] = 'Email hoặc mật khẩu không đúng';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Trang Đăng Nhập Người Bán</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
</head>
<body>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="login">
            <h3>Đăng Nhập Ngay</h3>
            <div class="input-field">
                <p>Email của bạn <span>*</span></p>
                <input type="email" name="email" placeholder="Nhập email của bạn" maxlength="50" required class="box">
            </div>              
            <div class="input-field">
                <p>Mật Khẩu của bạn <span>*</span></p>
                <input type="password" name="pass" placeholder="Nhập mật khẩu của bạn" maxlength="50" required class="box">
            </div>
            <p class="link">Bạn chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
            <button type="submit" name="submit" value="Đăng Ký Ngay" class="btn">Đăng Nhập Ngay</button>
            
        </form>
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
    
    <?php include '../components/alert.php'; ?>
</body>
</html>
