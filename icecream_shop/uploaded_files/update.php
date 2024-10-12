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
if (isset($_POST['submit'])) {
    // Lấy và xử lý dữ liệu từ form
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $old_pass = htmlspecialchars($_POST['old_pass'], ENT_QUOTES, 'UTF-8');
    $new_pass = htmlspecialchars($_POST['new_pass'], ENT_QUOTES, 'UTF-8');
    $cpass = htmlspecialchars($_POST['cpass'], ENT_QUOTES, 'UTF-8');

    // Lấy thông tin người dùng từ cơ sở dữ liệu
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
    $select_user->execute([$user_id]);
    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

    $prev_pass = $fetch_user['password'];
    $prev_image = $fetch_user['image'];

    // Cập nhật tên
    if (!empty($name)) {
        $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
        $update_name->execute([$name, $user_id]);
        $success_msg[] = 'Cập nhật tên thành công';
    }

    // Cập nhật email
    if (!empty($email)) {
        $select_email = $conn->prepare("SELECT * FROM `users` WHERE id != ? AND email = ?");
        $select_email->execute([$user_id, $email]);
        if ($select_email->rowCount() > 0) {
            $warning_msg[] = 'Email đã tồn tại';
        } else {
            $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
            $update_email->execute([$email, $user_id]);
            $success_msg[] = 'Cập nhật email thành công';
        }
    }

    // Cập nhật hình ảnh
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = uniqid() . '.' . $ext;
        $image_folder = '../uploaded_files/' . $rename;

        if ($image_size > 2 * 1024 * 1024) {
            $warning_msg[] = 'Kích thước hình ảnh quá lớn';
        } else {
            $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
            $update_image->execute([$rename, $user_id]);

            if (move_uploaded_file($image_tmp_name, $image_folder)) {
                if (!empty($prev_image) && $prev_image !== $rename) {
                    unlink('../uploaded_files/' . $prev_image);
                }
                $success_msg[] = 'Cập nhật hình ảnh thành công';
            } else {
                $warning_msg[] = 'Không thể tải lên hình ảnh';
            }
        }
    }

    // Cập nhật mật khẩu
    if (!empty($old_pass) && !empty($new_pass) && !empty($cpass)) {
        // So sánh mật khẩu cũ với mật khẩu trong cơ sở dữ liệu
        if ($old_pass === $prev_pass) {
            if ($new_pass !== $cpass) {
                $warning_msg[] = 'Mật khẩu xác nhận không khớp';
            } else {
                // Cập nhật mật khẩu mới (không mã hóa)
                $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
                if ($update_pass->execute([$new_pass, $user_id])) {
                    $success_msg[] = 'Cập nhật mật khẩu thành công!';
                } else {
                    $error_info = $update_pass->errorInfo();
                    $warning_msg[] = 'Không thể cập nhật mật khẩu: ' . $error_info[2];
                }
            }
        } else {
            $warning_msg[] = 'Mật khẩu cũ không đúng';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Cập nhật trang cá nhân</title>
    <link rel="stylesheet" type="text/css" href="../css/user_style.css">
</head>
<body>
    <?php include '../components/user_header.php'; ?>
    <!-- slider section start -->
    <section class="form-container">
        <div class="heading">
            <h1> Cập nhật thông tin cá nhân</h1>
            <img src="../image/separator-img.png" alt="Separator">
        </div>
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <div class="img-box">
                <img src="../uploaded_files/<?= htmlspecialchars($fetch_profile['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Hình ảnh cá nhân">
            </div>
            <div class="flex">
                <div class="col">
                    <div class="input-field">
                        <p>Tên của bạn <span>*</span></p>
                        <input type="text" name="name" placeholder="<?= htmlspecialchars($fetch_profile['name'], ENT_QUOTES, 'UTF-8'); ?>" class="box">
                    </div>
                    <div class="input-field">
                        <p>Email của bạn <span>*</span></p>
                        <input type="email" name="email" placeholder="<?= htmlspecialchars($fetch_profile['email'], ENT_QUOTES, 'UTF-8'); ?>" class="box">
                    </div>
                    <div class="input-field">
                        <p>Chọn hình ảnh <span>*</span></p>
                        <input type="file" name="image" accept="image/*" class="box">
                    </div>
                </div>
                <div class="col">
                    <div class="input-field">
                        <p>Mật khẩu cũ <span>*</span></p>
                        <input type="password" name="old_pass" placeholder="Nhập mật khẩu cũ của bạn" class="box">
                    </div>
                    <div class="input-field">
                        <p>Mật khẩu mới <span>*</span></p>
                        <input type="password" name="new_pass" placeholder="Nhập mật khẩu mới của bạn" class="box">
                    </div>
                    <div class="input-field">
                        <p>Xác nhận mật khẩu <span>*</span></p>
                        <input type="password" name="cpass" placeholder="Xác nhận mật khẩu của bạn" class="box">
                    </div>
                </div>
            </div>
            <button type="submit" name="submit" value="Cập nhật trang cá nhân" class="btn">Cập nhật trang cá nhân</button>
        </form>
    </section>
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
