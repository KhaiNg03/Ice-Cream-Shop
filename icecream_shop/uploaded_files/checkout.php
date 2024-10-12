<?php 
include '../components/connect.php';
// Khởi tạo biến thông báo
$warning_msg = [];
$success_msg = [];
// Khởi tạo biến thông báo
$warning_msg = [];
$success_msg = [];
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location:login.php');
}
if (isset($_POST['place_order'])) {
    // Sanitize user inputs
    $name = filter_var($_POST["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Safer for displaying in HTML
    $number = filter_var($_POST["number"], FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    // Construct address
    $address = trim(
        filter_var(
            $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ', ' . $_POST['pin'],
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        )
    );
    
    $address_type = filter_var($_POST['address_type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $method = filter_var($_POST['method'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Verify if the cart exists for the user
    $verify_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $verify_cart->execute([$user_id]);

    // Check if a product is being added
    if (isset($_GET['get_id'])) {
        $get_product = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $get_product->execute([$_GET['get_id']]);

        if ($get_product->rowCount() > 0) {
            while ($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)) {
                $seller_id = $fetch_p['seller_id'];
                
                // Insert order into the database
                $insert_order = $conn->prepare("INSERT INTO orders (id, user_id, seller_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insert_order->execute([
                    uniqid(),
                    $user_id,
                    $seller_id,
                    $name,
                    $number,
                    $email,
                    $address,
                    $address_type,
                    $method,
                    $fetch_p['id'],
                    $fetch_p['price'],
                    1 // Assuming quantity is always 1; modify if needed
                ]);

                // Redirect to the order page
                header("Location: order.php");
                exit(); // Ensure no further code is executed after redirect
            }
        } else {
            // If no product found, show warning
            $warning_msg[] = 'Đã xảy ra lỗi';
        }
    } elseif ($verify_cart->rowCount() > 0) {
        // Process orders for items in the cart
        while ($f_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)) {
            $s_products = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
            $s_products->execute([$f_cart['product_id']]);
            $f_product = $s_products->fetch(PDO::FETCH_ASSOC);

            if ($f_product) {
                $seller_id = $f_product['seller_id'];

                // Insert order into the database
                $insert_order = $conn->prepare("INSERT INTO orders (id, user_id, seller_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insert_order->execute([
                    uniqid(),
                    $user_id,
                    $seller_id,
                    $name,
                    $number,
                    $email,
                    $address,
                    $address_type,
                    $method,
                    $f_cart['product_id'],
                    $f_cart['price'],
                    $f_cart['qty']
                ]);
            }
        }
    } else {
        // If cart is empty or something went wrong
        $warning_msg[] = 'Giỏ hàng của bạn trống hoặc đã xảy ra lỗi';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Trang Thanh Toán</title>
    <link rel="stylesheet" type="text/css" href="../css/user_style.css">
</head>
<body>
    <?php include '../components/user_header.php'; ?>
    <!-- Slider Section Start -->
    <div class="checkout">
        <div class="heading">
            <h1>Tóm Tắt Thanh Toán</h1>
            <img src="../image/separator-img.png" alt="Hình Ảnh Phân Cách">
        </div>
        <div class="row">
            <form action="" method="post" class="register">
                <input type="hidden" name="p_id" value="<?= htmlspecialchars($get_id); ?>">
                <h3>Thông Tin Thanh Toán</h3>
                <div class="flex">
                    <div class="box">
                        <div class="input-field">
                            <p>Tên Của Bạn <span>*</span></p>
                            <input type="text" name="name" required maxlength="56" placeholder="Nhập tên của bạn" class="input">
                        </div>
                        <div class="input-field">
                            <p>Số Điện Thoại <span>*</span></p>
                            <input type="number" name="number" required maxlength="16" placeholder="Nhập số điện thoại của bạn" class="input">
                        </div>
                        <div class="input-field">
                            <p>Email Của Bạn <span>*</span></p>
                            <input type="email" name="email" required maxlength="50" placeholder="Nhập email của bạn" class="input">
                        </div>
                        <div class="input-field">
                            <p>Phương Thức Thanh Toán <span>*</span></p>
                            <select name="method" class="input">
                                <option value="cash on delivery">Thanh Toán Khi Nhận Hàng</option>
                                <option value="credit or debit card">Thẻ Tín Dụng Hoặc Thẻ Ghi Nợ</option>
                                <option value="net banking">Ngân Hàng Trực Tuyến</option>
                                <option value="UPI or RuPay">UPI Hoặc RuPay</option>
                                <option value="paytm">Paytm</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <p>Loại Địa Chỉ <span>*</span></p>
                            <select name="address_type" class="input">
                                <option value="home">Nhà</option>
                                <option value="office">Văn Phòng</option>
                            </select>
                        </div>
                    </div>
                    <div class="box">
                        <div class="input-field">
                            <p>Địa Chỉ Dòng 01 <span>*</span></p>
                            <input type="text" name="flat" required maxlength="50" placeholder="VD: Tên Chung Cư hoặc Tòa Nhà" class="input">
                        </div>
                        <div class="input-field">
                            <p>Địa Chỉ Dòng 02 <span>*</span></p>
                            <input type="text" name="street" required maxlength="50" placeholder="VD: Tên Đường" class="input">
                        </div>
                        <div class="input-field">
                            <p>Tên Thành Phố <span>*</span></p>
                            <input type="text" name="city" required maxlength="50" placeholder="VD: Tên Thành Phố" class="input">
                        </div>
                        <div class="input-field">
                            <p>Tên Quốc Gia <span>*</span></p>
                            <input type="text" name="country" required maxlength="50" placeholder="VD: Tên Quốc Gia" class="input">
                        </div>
                        <div class="input-field">
                            <p>Mã Bưu Chính <span>*</span></p>
                            <input type="number" name="pin" required maxlength="6" min="0" placeholder="VD: 116011" class="input">
                        </div>
                    </div>
                </div>
                <button type="submit" name="place_order" class="btn">Đặt Hàng</button>

            </form>
            <div class="checkout-summary">
                <h3>Túi Của Tôi</h3>
                <div class="box-container">
                    <?php
                    $grand_total = 0;

                    // Check if 'get_id' is set in the URL
                    if (isset($_GET['get_id'])) {
                        $select_get = $conn->prepare("SELECT * FROM products WHERE id = ?");
                        $select_get->execute([$_GET['get_id']]);
                        while ($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)) {
                            $sub_total = $fetch_get['price'];
                            $grand_total += $sub_total;
                            ?>
                            <div class="flex">
                                <img src="../uploaded_files/<?= htmlspecialchars($fetch_get['image']); ?>" class="image">
                                <div>
                                    <h3 class="name"><?= htmlspecialchars($fetch_get['name']); ?></h3>
                                    <p class="price"><?= htmlspecialchars($fetch_get['price']); ?>đ</p>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        // Get user ID from cookies or other source
                        $user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : '';
                    
                        $select_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
                        $select_cart->execute([$user_id]);
                    
                        if ($select_cart->rowCount() > 0) {
                            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                                $select_products = $conn->prepare("SELECT * FROM products WHERE id = ?");
                                $select_products->execute([$fetch_cart['product_id']]);
                                $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                                $sub_total = $fetch_cart['qty'] * $fetch_products['price'];
                                $grand_total += $sub_total;
                                ?>
                                <div class="flex">
                                    <img src="../uploaded_files/<?= htmlspecialchars($fetch_products['image']); ?>" class="image">
                                    <div>
                                        <h3 class="name"><?= htmlspecialchars($fetch_products['name']); ?></h3>
                                        <p class="price"><?= htmlspecialchars($fetch_products['price']); ?> x <?= htmlspecialchars($fetch_cart['qty']); ?>đ</p>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<p class="empty">Giỏ hàng của bạn trống</p>';
                        }
                    }
                    ?>
                </div>
                <div class="grand-total">
                    <span>Tổng Số Tiền Phải Thanh Toán:</span>
                    <p><?= htmlspecialchars($grand_total); ?>đ</p>
                </div>              
            </div>
        </div>
    </div>

    <?php include '../components/footer.php'; ?>
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
