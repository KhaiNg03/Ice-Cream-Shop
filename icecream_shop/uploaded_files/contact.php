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
if (isset($_POST['send_message'])) {
    // Kiểm tra nếu người dùng đã đăng nhập
    if (isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
        $id = uniqid(); // Tạo ID duy nhất
        
        // Lấy và làm sạch dữ liệu từ biểu mẫu
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
        $subject = htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8');
        $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
        
        // Kiểm tra nếu tin nhắn đã tồn tại
        $verify_message = $conn->prepare("SELECT * FROM message WHERE user_id = ? AND name = ? AND email = ? AND subject = ? AND message = ?");
        $verify_message->execute([$user_id, $name, $email, $subject, $message]);
        
        if ($verify_message->rowCount() > 0) {
            $warning_msg[] = 'Tin nhắn đã tồn tại';
        } else {
            // Thêm tin nhắn mới vào cơ sở dữ liệu
            $insert_message = $conn->prepare("INSERT INTO message (id, user_id, name, email, subject, message) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_message->execute([$id, $user_id, $name, $email, $subject, $message]);
            $success_msg[] = 'Tin nhắn đã được gửi thành công';
        }
    } else {
        $warning_msg[] = 'Vui lòng đăng nhập trước';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Trang liên hệ</title>
    <link rel="stylesheet" type="text/css" href="../css/user_style.css">
</head>
<body>
    <?php include '../components/user_header.php'; ?>
    <div class="form-container">
        <div class="heading">
            <h1>Gửi cho chúng tôi một dòng</h1>
            <p>Chỉ cần vài cú nhấp chuột để đặt chỗ trực tuyến, tiết kiệm thời gian và tiền bạc.</p>
            <img src="../image/separator-img.png" alt="Hình ảnh phân cách">
        </div>

        <form action="" method="post" class="register">
            <div class="input-field">
                <label for="name">Tên <sup>*</sup></label>
                <input type="text" id="name" name="name" required placeholder="Nhập tên của bạn" class="box">
            </div>

            <div class="input-field">
                <label for="email">Email <sup>*</sup></label>
                <input type="email" id="email" name="email" required placeholder="Nhập email của bạn" class="box">
            </div>

            <div class="input-field">
                <label for="subject">Chủ đề <sup>*</sup></label>
                <input type="text" id="subject" name="subject" required placeholder="Lý do.." class="box">
            </div>

            <div class="input-field">
                <label for="message">Tin nhắn <sup>*</sup></label>
                <textarea id="message" name="message" cols="30" rows="10" required placeholder="Nhập tin nhắn của bạn" class="box"></textarea>
            </div>

            <button type="submit" name="send_message" class="btn">Gửi tin nhắn</button>
        </form>
    </div>
    <!-- slider section start -->
    <div class="services">
        <div class="heading">
            <h1>Dịch vụ của chúng tôi</h1>
            <p>Chỉ cần vài cú nhấp chuột để đặt chỗ trực tuyến, tiết kiệm thời gian và tiền bạc</p>
            <img src="../image/separator-img.png" alt="Hình ảnh phân cách">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="../image/0.png" alt="Miễn phí vận chuyển">
                <div>
                    <h1>Miễn phí vận chuyển nhanh</h1>
                </div>
            </div>
            <div class="box">
                <img src="../image/1.png" alt="Cam kết hoàn tiền">
                <div>
                    <h1>Cam kết hoàn tiền</h1>
                </div>
            </div>
            <div class="box">
                <img src="../image/2.png" alt="Hỗ trợ trực tuyến">
                <div>
                    <h1>Hỗ trợ trực tuyến 24/7</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="address">
        <div class="heading">
            <h1>Thông tin liên hệ của chúng tôi</h1>
            <p>Chỉ cần vài cú nhấp chuột để đặt chỗ trực tuyến, tiết kiệm thời gian và tiền bạc.</p>
            <img src="../image/separator-img.png" alt="Hình ảnh phân cách">
        </div>
        <div class="box-container">
            <div class="box">
                <i class="bx bxs-map-alt"><img src="../image/tracker.webp" width="20px" height="28px"></i>
                <div>
                    <h4>Địa chỉ</h4>
                    <p>Đường Tô Ký, Trung Mỹ Tây, Quận 12,</p>
                    <p>TP Hồ Chí Minh, Việt Nam</p>
                </div>
            </div>
            <div class="box">
                <i class="bx bxs-phone-incoming"><img src="../image/phone.webp" alt="Thêm vào giỏ hàng" width="20px" height="20px"></i>
                <div>
                    <h4>Số điện thoại</h4>
                    <p>0379 20 91 20</p>
                    <p>039 86 68 149</p>
                </div>
            </div>
            <div class="box">
                <i class="bx bxs-envelope"><img src="../image/email.webp"  width="28px" height="19px"></i>
                <div>
                    <h4>Email</h4>
                    <p>qkhai1205@gmail.com</p>
                    <p>2251120418@ut.edu.vn</p>
                </div>
            </div>
        </div>
    </div>

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
