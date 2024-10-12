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
    exit;
}

// Thêm sản phẩm vào cơ sở dữ liệu
if (isset($_POST['publish'])) {
    // Tạo một ID duy nhất cho sản phẩm
    $product_id = uniqid();

    // Lấy và làm sạch các đầu vào từ biểu mẫu
    $name = trim($_POST['name']);
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

    $price = trim($_POST['price']);
    $price = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    $description = trim($_POST['description']);
    $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

    $stock = trim($_POST['stock']);
    $stock = filter_var($stock, FILTER_SANITIZE_NUMBER_INT);

    $status = 'Đang bán'; // Trạng thái mặc định

    // Xử lý hình ảnh
    $image = $_FILES['image']['name'];
    $image = htmlspecialchars($image, ENT_QUOTES, 'UTF-8');
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $image;

    // Kiểm tra hình ảnh trùng lặp
    $select_image = $conn->prepare("SELECT * FROM `products` WHERE `image` = ?");
    $select_image->execute([$image]);

    $warning_msg = [];

    if ($select_image->rowCount() > 0) {
        $warning_msg[] = 'Tên hình ảnh đã tồn tại';
    } elseif ($image_size > 2000000) {
        $warning_msg[] = 'Kích thước hình ảnh quá lớn';
    } else {
        move_uploaded_file($image_tmp_name, $image_folder);
    }

    // Kiểm tra lại hình ảnh trùng lặp
    if ($select_image->rowCount() > 0 && $image != '') {
        $warning_msg[] = 'Vui lòng đổi tên hình ảnh của bạn';
    } else {
        // Chèn sản phẩm vào cơ sở dữ liệu
        $insert_product = $conn->prepare("INSERT INTO `products` (id, seller_id, name, price, image, stock, product_detail, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_product->execute([$product_id, $seller_id, $name, $price, $image, $stock, $description, $status]);
        $success_msg[] = 'Sản phẩm đã được thêm thành công';
    }
}

// Thêm sản phẩm vào cơ sở dữ liệu
if (isset($_POST['draft'])) {
    // Tạo một ID duy nhất cho sản phẩm
    $product_id = uniqid();

    // Lấy và làm sạch các đầu vào từ biểu mẫu
    $name = trim($_POST['name']);
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

    $price = trim($_POST['price']);
    $price = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    $description = trim($_POST['description']);
    $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

    $stock = trim($_POST['stock']);
    $stock = filter_var($stock, FILTER_SANITIZE_NUMBER_INT);

    $status = 'Ngưng bán'; // Trạng thái mặc định

    // Xử lý hình ảnh
    $image = $_FILES['image']['name'];
    $image = htmlspecialchars($image, ENT_QUOTES, 'UTF-8');
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $image;

    // Kiểm tra hình ảnh trùng lặp
    $select_image = $conn->prepare("SELECT * FROM `products` WHERE `image` = ?");
    $select_image->execute([$image]);

    $warning_msg = [];

    if ($select_image->rowCount() > 0) {
        $warning_msg[] = 'Tên hình ảnh đã tồn tại';
    } elseif ($image_size > 2000000) {
        $warning_msg[] = 'Kích thước hình ảnh quá lớn';
    } else {
        move_uploaded_file($image_tmp_name, $image_folder);
    }

    // Kiểm tra lại hình ảnh trùng lặp
    if ($select_image->rowCount() > 0 && $image != '') {
        $warning_msg[] = 'Vui lòng đổi tên hình ảnh của bạn';
    } else {
        // Chèn sản phẩm vào cơ sở dữ liệu
        $insert_product = $conn->prepare("INSERT INTO `products` (id, seller_id, name, price, image, stock, product_detail, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_product->execute([$product_id, $seller_id, $name, $price, $image, $stock, $description, $status]);
        $success_msg[] = 'Sản phẩm đã được lưu dưới dạng nháp thành công';
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Trang Thêm Sản Phẩm Quản Trị</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
</head>
<body>    

    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="post-editor">
            <div class="heading">
                <h1>Thêm Sản Phẩm</h1>
                <img src="../image/separator-img.png" alt="Separator">
            </div>
            <div class="form-container">
                <form action="" method="post" enctype="multipart/form-data" class="register">
                    <div class="input-field">
                        <p>Tên sản phẩm <span>*</span></p>
                        <input type="text" name="name" maxlength="100" placeholder="Thêm tên sản phẩm" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Giá sản phẩm <span>*</span></p>
                        <input type="number" name="price" maxlength="10" placeholder="Thêm giá sản phẩm" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Chi tiết sản phẩm <span>*</span></p>
                        <textarea name="description" required maxlength="1000" placeholder="Thêm chi tiết sản phẩm" class="box"></textarea>
                    </div>
                    <div class="input-field">
                        <p>Tồn kho sản phẩm <span>*</span></p>
                        <input type="number" name="stock" min="0" max="9999999999" placeholder="Thêm tồn kho sản phẩm" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Hình ảnh sản phẩm <span>*</span></p>
                        <input type="file" name="image" accept="image/*" required class="box">
                    </div>
                    <div class="flex-btn">
                        <button type="submit" name="publish" value="Thêm sản phẩm" class="btn">Thêm sản phẩm</button>
                        <button type="submit" name="draft" value="Lưu dưới dạng nháp" class="btn">Lưu dưới dạng nháp</button>
                    </div>

                </form>
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
