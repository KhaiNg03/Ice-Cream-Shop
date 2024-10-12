<?php 
include '../components/connect.php'; 
// Khởi tạo biến thông báo
$warning_msg = [];
$success_msg = [];

// Khởi tạo biến thông báo
$warning_msg = [];
$success_msg = [];

if (isset($_POST['submit'])) {
    $id = unique_id();
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];

    // Kiểm tra email đã tồn tại chưa
    $select_seller = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_seller->execute([$email]);

    if ($select_seller->rowCount() > 0) {
        $warning_msg[] = 'Email đã tồn tại!';
    } else {
        if ($pass != $cpass) {
            $warning_msg[] = 'Mật khẩu xác nhận không khớp';
        } else {
            $image = $_FILES['image']['name'];
            $image = htmlspecialchars($image);
            $ext = pathinfo($image, PATHINFO_EXTENSION);
            $rename = unique_id() . '.' . $ext;
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_folder = '../uploaded_files/' . $rename;
            
            $insert_seller = $conn->prepare("INSERT INTO `users` (id, name, email, password, image) VALUES (?, ?, ?, ?, ?)");
            $insert_seller->execute([$id, $name, $email, $pass, $rename]);
            move_uploaded_file($image_tmp_name, $image_folder);
            $success_msg[] = "Người dùng mới đã được đăng ký! Vui lòng đăng nhập ngay";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Trang đăng ký người dùng</title>
    <link rel="stylesheet" type="text/css" href="../css/user_style.css">
</head>
<body>
    <?php include '../components/user_header.php'; ?>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <h3>Đăng Ký Ngay</h3>
            <div class="flex">
                <div class="col">
                    <div class="input-field">
                        <p>Họ Tên Của Bạn <span>*</span></p>
                        <input type="text" name="name" placeholder="Nhập tên của bạn" maxlength="50" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Email Của Bạn <span>*</span></p>
                        <input type="email" name="email" placeholder="Nhập email của bạn" maxlength="50" required class="box">
                    </div>
                </div>                
                <div class="col">
                    <div class="input-field">
                        <p>Mật Khẩu Của Bạn <span>*</span></p>
                        <input type="password" name="pass" placeholder="Nhập mật khẩu của bạn" maxlength="50" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Xác Nhận Mật Khẩu <span>*</span></p>
                        <input type="password" name="cpass" placeholder="Xác nhận mật khẩu của bạn" maxlength="50" required class="box">
                    </div>
                </div>
            </div>
            <div class="input-field">
                <p>Ảnh Hồ Sơ Của Bạn <span>*</span></p>
                <input type="file" name="image" accept="image/*" required class="box">
            </div>
            <p class="link">Bạn đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>           
            <button type="submit" name="submit" value="Đăng Ký Ngay" class="btn">Đăng Ký Ngay</button>
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

    <?php include '../components/footer.php'; ?>
    <?php include '../components/alert.php'; ?>
</body>
</html>
