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
    if (isset($_POST['update'])) {
        $product_id = $_POST['product_id'];
    
        // Kiểm tra nếu product_id là một số nguyên hợp lệ
        if (!empty($product_id) && is_numeric($product_id) && (int)$product_id == $product_id) {
            $product_id = (int)$product_id; // Chuyển đổi về kiểu số nguyên an toàn
    
            // Tiếp tục xử lý các thông tin khác từ form và thực hiện cập nhật cơ sở dữ liệu
        } else {
            // Xử lý trường hợp dữ liệu không hợp lệ
            echo "ID sản phẩm không hợp lệ.";
        }            
        // Lấy và xử lý các giá trị khác từ form
        $name = trim($_POST['name']);
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    
        $price = trim($_POST['price']);
        $price = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    
        $description = trim($_POST['description']);
        $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
    
        $stock = trim($_POST['stock']);
        $stock = filter_var($stock, FILTER_SANITIZE_NUMBER_INT);
    
        $status = $_POST['status']; // Trạng thái mặc định của sản phẩm
        $status = htmlspecialchars($status, ENT_QUOTES, 'UTF-8');

        $update_product = $conn->prepare("UPDATE `products` SET `name` = ?, `price` = ?, `product_detail` = ?, `stock` = ?, `status` = ? WHERE `id` = ?");
        $update_product->execute([$name, $price, $description, $stock, $status, $product_id]);
    
        $success_msg[] = 'Sản phẩm đã được cập nhật';
    
        // Xử lý hình ảnh cũ nếu có
        $old_image = $_POST['old_image'];
    
        // Xử lý hình ảnh sản phẩm
        $image = $_FILES['image']['name'];
        $image = htmlspecialchars($image, ENT_QUOTES, 'UTF-8');
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../uploaded_files/' . $image;
        if (!empty($image)) {
            // Kiểm tra xem ảnh có trùng tên với ảnh đã có không
            $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ? AND seller_id = ?");
            $select_image->execute([$image, $seller_id]);
            
            if ($image_size > 2000000) {
                $warning_msg[] = 'Kích thước ảnh quá lớn';
            } elseif ($select_image->rowCount() > 0) {
                $warning_msg[] = 'Vui lòng đổi tên ảnh của bạn';
            } else {
                $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
                $update_image->execute([$image, $product_id]);
                move_uploaded_file($image_tmp_name, $image_folder);
        
                if ($old_image != $image && $old_image != '') {
                    unlink("../uploaded_files/" . $old_image);
                }
        
                $success_msg[] = 'Ảnh đã được cập nhật!';
            }
        } else {
            $warning_msg[] = 'Không có ảnh nào được tải lên';
        }
    } else {
        echo "ID sản phẩm không hợp lệ.";
    }
    // Xóa hình ảnh
    if (isset($_POST['delete_image'])) {
        $empty_image = ''; // Biến để lưu giá trị trống cho ảnh
        $product_id = $_POST['product_id'];
        $product_id = htmlspecialchars($product_id, ENT_QUOTES, 'UTF-8'); // Làm sạch dữ liệu đầu vào

        $delete_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
        $delete_image->execute([$product_id]);
        $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

        if ($fetch_delete_image && $fetch_delete_image['image'] != '') {
            // Xóa hình ảnh từ thư mục
            unlink("../uploaded_files/" . $fetch_delete_image['image']);

            // Cập nhật trường 'image' của sản phẩm trong cơ sở dữ liệu
            $unset_image = $conn->prepare("UPDATE `products` SET `image` = ? WHERE `id` = ?");
            $unset_image->execute([$empty_image, $product_id]);

            $success_msg[] = 'Ảnh đã được xóa thành công';
        } else {
            $warning_msg[] = 'Không tìm thấy ảnh hoặc ảnh đã được xóa.';
        }
    }
    // Delete product
    if (isset($_POST['delete_product'])) {
        $product_id = $_POST['product_id'];
        $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);
    
        // Fetch the product to get the image
        $delete_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
        $delete_image->execute([$product_id]);
        $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
    
        if ($fetch_delete_image && !empty($fetch_delete_image['image'])) {
            unlink("../uploaded_files/" . $fetch_delete_image['image']);
        }
    
        // Delete the product from the database
        $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
        $delete_product->execute([$product_id]);
    
        $success_msg[] = 'Sản phẩm đã được xóa thành công!';
        header('location:view_product.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Seller Registration Page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
</head>
<body>    
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="post-editor">
            <div class="heading">
                <h1>Chỉnh sửa sản phẩm</h1>
                <img src="../image/separator-img.png" alt="Separator">
            </div>
            <div class="box-container">
                <?php 
                    $product_id = $_GET['id']; 
                    $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? AND seller_id = ?");
                    $select_product->execute([$product_id, $seller_id]);
                    if ($select_product->rowCount() > 0) { 
                        while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){ 
                ?>
                <div class="form-container">
                    <form action="" method="post" enctype="multipart/form-data" class="register">
                        <input type="hidden" name="old_image" value="<?= htmlspecialchars($fetch_product['image']); ?>">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_product['id']); ?>">

                        <div class="input-field">
                            <p>Trạng thái sản phẩm <span>*</span></p>
                            <select name="status" class="box">
                                <option value="<?= $fetch_product['status']; ?>" selected><?= $fetch_product['status']; ?></option>
                                <option value="Đang bán">Đang bán</option>
                                <option value="Ngưng bán">Ngưng bán</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <p>Tên sản phẩm<span>*</span></p>
                            <input type="text" name="name" value="<?= htmlspecialchars($fetch_product['name']); ?>" class="box">
                        </div>

                        <div class="input-field">
                            <p>Giá sản phẩm <span>*</span></p>
                            <input type="number" name="price" value="<?= htmlspecialchars($fetch_product['price']); ?>" class="box">
                        </div>
                        <div class="input-field">
                            <p>Mô tả sản phẩm <span>*</span></p>
                            <textarea name="description" class="box"><?= htmlspecialchars($fetch_product['product_detail']); ?></textarea>
                        </div>
                        <div class="input-field">
                            <p>Tồn kho sản phẩm <span>*</span></p>
                            <input type="number" name="stock" value="<?= htmlspecialchars($fetch_product['stock']); ?>" class="box" min="0" max="9999999999" maxlength="10">
                        </div>
                        <div class="input-field">
                            <p>Cập nhật hình ảnh <span>*</span></p>
                            <input type="file" name="image" accept="image/*" class="box">
                            <?php if ($fetch_product['image'] != '') { ?>
                                <img src="../uploaded_files/<?= htmlspecialchars($fetch_product['image']); ?>" class="image">
                            <?php } ?>
                        </div>
                            
                        <div class="flex-btn">
                            <button type="submit" name="delete_image"  value="Xóa hình" class="btn">Xóa hình</button>
                            <a href="view_product.php" class="btn" style=" width: 50%; text-align: center; height: 3rem; margin-top:.7rem;">Xem sản phẩm</a>
                        </div>
                        <div class="flex-btn">
                            <button type="submit" name="update" value="Cập nhật sản phẩm" class="btn">Cập nhật sản phẩm</button>
                            <button type="submit" name="delete_product" value="Xóa sản phẩm" class="btn">Xóa Sản Phẩm</button>
                        </div>
                   </form>
                </div>
                    <?php
                            }
                        }else{ 
                            echo '
                                <div class="empty">
                                    <p>Chưa có sản phẩm nào được thêm!</p>
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
    <!-- Custom JS link -->
    <script src="../js/admin_script.js"></script>
    
    <?php include '../components/alert.php'; ?>
</body>
</html>
