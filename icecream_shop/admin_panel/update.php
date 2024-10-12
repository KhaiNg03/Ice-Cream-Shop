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

if (isset($_POST['submit'])) {
    // Lấy và xử lý dữ liệu từ form
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $old_pass = htmlspecialchars($_POST['old_pass'], ENT_QUOTES, 'UTF-8');
    $new_pass = htmlspecialchars($_POST['new_pass'], ENT_QUOTES, 'UTF-8');
    $cpass = htmlspecialchars($_POST['cpass'], ENT_QUOTES, 'UTF-8');

    // Lấy thông tin người bán từ cơ sở dữ liệu
    $select_seller = $conn->prepare("SELECT * FROM `sellers` WHERE id = ? LIMIT 1");
    $select_seller->execute([$seller_id]);
    $fetch_seller = $select_seller->fetch(PDO::FETCH_ASSOC);

    $prev_pass = $fetch_seller['password'];
    $prev_image = $fetch_seller['image'];

    // Cập nhật tên
    if (!empty($name)) {
        $update_name = $conn->prepare("UPDATE `sellers` SET name = ? WHERE id = ?");
        $update_name->execute([$name, $seller_id]);
        $success_msg[] = 'Cập nhật tên người dùng thành công';
    }

    // Cập nhật email
    if (!empty($email)) {
        $select_email = $conn->prepare("SELECT * FROM `sellers` WHERE id != ? AND email = ?");
        $select_email->execute([$seller_id, $email]);
        if ($select_email->rowCount() > 0) {
            $warning_msg[] = 'Email đã tồn tại';
        } else {
            $update_email = $conn->prepare("UPDATE `sellers` SET email = ? WHERE id = ?");
            $update_email->execute([$email, $seller_id]);
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
            $update_image = $conn->prepare("UPDATE `sellers` SET image = ? WHERE id = ?");
            $update_image->execute([$rename, $seller_id]);

            if (move_uploaded_file($image_tmp_name, $image_folder)) {
                if (!empty($prev_image) && $prev_image !== $rename) {
                    unlink('../uploaded_files/' . $prev_image);
                }
                $success_msg[] = 'Cập nhật hình ảnh thành công';
            } else {
                $warning_msg[] = 'Tải lên hình ảnh thất bại';
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
                $update_pass = $conn->prepare("UPDATE `sellers` SET password = ? WHERE id = ?");
                if ($update_pass->execute([$new_pass, $seller_id])) {
                    $success_msg[] = 'Cập nhật mật khẩu thành công!';
                } else {
                    $error_info = $update_pass->errorInfo();
                    $warning_msg[] = 'Cập nhật mật khẩu thất bại: ' . $error_info[2];
                }
            }
        } else {
            $warning_msg[] = 'Mật khẩu cũ không đúng';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Cập nhật trang cá nhân</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
<body>    
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="form-container">
            <div class="heading">
                <h1>Cập nhật thông tin cá nhân</h1>
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
