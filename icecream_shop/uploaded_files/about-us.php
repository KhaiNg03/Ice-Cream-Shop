<?php 
include '../components/connect.php'; 

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Sky Summer - Trang Giới Thiệu</title>
    <link rel="stylesheet" type="text/css" href="../css/user_style.css">
</head>
<body>
    <?php include '../components/user_header.php'; ?>
    <!-- slider section start -->
    <div class="chef">
        <div class="box-container">
            <div class="box">
                <div class="heading">
                    <span>Alex Doe</span>
                    <h1>Đầu Bếp Chính</h1>
                    <img src="../image/separator-img.png" alt="Separator">
                </div>
                <p>
                    Maria là một đầu bếp bánh sinh ra ở Rome, người đã dành 15 năm ở thành phố Rome để hoàn thiện tay nghề và những sáng tạo xuất sắc của mình. Vestibulum rhoncus ornare tincidunt. Etiam pretium metus sit amet est aliquet vulputate. Fusce et cursus ligula. Sed accumsan dictum porta. Aliquam rutrum ullamcorper velit hendrerit convallis.
                </p>
                <div class="flex-btn">
                    <a href="menu.php" class="btn">Khám Phá Thực Đơn Của Chúng Tôi</a>
                    <a href="menu.php" class="btn">Thăm Cửa Hàng Của Chúng Tôi</a>
                </div>
            </div>
            <div class="box">
                <img src="../image/ceaf.png" class="img">
            </div>
        </div>
    </div>
    <!-- Cheat section start -->
    <div class="story">
        <div class="heading">
            <h1>Câu Chuyện Của Chúng Tôi</h1>
            <img src="../image/separator-img.png" alt="Separator">
        </div>
        <p>Câu chuyện của chúng tôi bắt đầu với niềm đam mê mãnh liệt dành cho kem. <br>
        Từ những ngày đầu, chúng tôi đã khao khát mang đến cho mọi người những hương vị kem độc đáo. <br>
        Mỗi sản phẩm đều được chế biến từ nguyên liệu tươi ngon nhất, <br>
        đảm bảo mang lại trải nghiệm tuyệt vời cho khách hàng. <br>
        Chúng tôi luôn lắng nghe ý kiến và mong muốn của khách hàng để cải thiện từng ngày.</p>

        <a href="menu.php" class="btn">Dịch Vụ Của Chúng Tôi</a>
    </div>
    <div class="container">
        <div class="box-container">
            <div class="img-box">
                <img src="../image/about.png" alt="Giới Thiệu">
            </div>
            <div class="box">
                <div class="heading">
                    <h1>Nâng Cao Trải Nghiệm Kem</h1>
                    <img src="../image/separator-img.png" alt="Separator">
                </div>
                <p>
                Để nâng cao trải nghiệm thưởng thức kem, các cửa hàng nên tạo không gian thân thiện và thoải mái cho khách hàng. Cung cấp đa dạng hương vị độc đáo và cho phép khách tự chọn nguyên liệu sẽ thu hút thực khách. Ngoài ra, tổ chức các sự kiện nhỏ hoặc hoạt động tương tác như thử nghiệm vị mới cũng giúp tạo ra những kỷ niệm đáng nhớ cho khách hàng.
                </p>
                <a href="" class="btn">Tìm Hiểu Thêm</a>
            </div>
        </div>
    </div>
    <!-- team section start -->
    <div class="team">
        <div class="heading">
            <span>Đội Ngũ Của Chúng Tôi</span>
            <h1>Chất Lượng & Đam Mê Trong Dịch Vụ Của Chúng Tôi</h1>
            <img src="../image/separator-img.png" alt="">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="../image/team-1.jpg" class="img" alt="Thành Viên Đội Ngũ">
                <div class="content">
                    <img src="../image/shape-19.png" class="shap">
                    <h2>Ralph Johnson</h2>
                    <p>Đầu Bếp Cà Phê</p>
                </div>
            </div>
            <div class="box">
                <img src="../image/team-2.jpg" class="img" alt="Fiona Johnson">
                <div class="content">
                    <img src="../image/shape-19.png" alt="" class="shap">
                    <h2>Fiona Johnson</h2>
                    <p>Đầu Bếp Bánh</p>
                </div>
            </div>
            <div class="box">
                <img src="../image/team-3.jpg" class="img" alt="Tom Knellton">
                <div class="content">
                    <img src="../image/shape-19.png" alt="" class="shap">
                    <h2>Tom Knellton</h2>
                    <p>Đầu Bếp Cà Phê</p>
                </div>
            </div>
        </div>
    </div>
    <!-- team section end -->
    <!-- standards section start -->
    <div class="standers">
        <div class="detail">
            <div class="heading">
                <h1>Tiêu Chuẩn Của Chúng Tôi</h1>
                <img src="../image/separator-img.png" alt="Separator">
            </div>
            <p>TCVN 5165 – 90, Sản phẩm thực phẩm. Phương pháp xác định tổng số vi khuẩn hiếu khí.</p>
            <i class="bx bxs-heart"></i>
            <p>TCVN 5779 : 1994, Sữa bột và sữa đặc có đường. Phương pháp xác định hàm lượng chì.</p>
            <i class="bx bxs-heart"></i>
            <p>TCVN 5780 : 1994, Sữa bột và sữa đặc có đường. Phương pháp xác định hàm lượng asen.</p>
            <i class="bx bxs-heart"></i>
            <p>TCVN 6400 : 1998 (ISO 707 : 1997), Sữa và sản phẩm sữa. Hướng dẫn lấy mẫu.</p>
            <i class="bx bxs-heart"></i>
            <p>TCVN 6402 : 1998 (ISO 6785 : 1985), Sữa và sản phẩm sữa - Phát hiện Salmonella.</p>
            <i class="bx bxs-heart"></i>
        </div>
    </div>
    <!-- standards section end -->
    <!-- testimonial section start -->
    <div class="testimonial">
        <div class="heading">
            <h1>Nhận Xét</h1>
            <img src="../image/separator-img.png" alt="Separator">
        </div>
        <div class="testimonial-container">
            <!-- Slide 1 -->
            <div class="slide-col" id="slide">
                <div class="user-text">
                    <p>Zen Doan là một nhà phân tích kinh doanh, doanh nhân và chủ sở hữu phương tiện truyền thông, cũng như nhà đầu tư. Cô cũng được biết đến như là tác giả của nhiều cuốn sách bán chạy.</p>
                    <h2>Zen Doan</h2>
                    <p>Tác Giả</p>
                </div>
                <div class="user-img">
                    <img src="../image/testimonial (1).jpg" alt="Zen Doan">
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="slide-col" id="slide">
                <div class="user-text">
                    <p>Jane Smith là một nhà thiết kế và nghệ sĩ nổi tiếng với niềm đam mê sáng tạo và đổi mới. Công việc của cô đã giành được nhiều giải thưởng.</p>
                    <h2>Jane Smith</h2>
                    <p>Nhà Thiết Kế</p>
                </div>
                <div class="user-img">
                    <img src="../image/testimonial (2).jpg" alt="Jane Smith">
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="slide-col" id="slide">
                <div class="user-text">
                    <p>John Doe là một doanh nhân công nghệ và nhà đổi mới. Ông đã được giới thiệu trên nhiều tạp chí công nghệ vì những đóng góp của mình cho ngành.</p>
                    <h2>Emily Johnson</h2>
                    <p>Doanh Nhân Công Nghệ</p>
                </div>
                <div class="user-img">
                    <img src="../image/testimonial (3).jpg" alt="John Doe">
                </div>
            </div>
            <!-- Slide 4 -->
            <div class="slide-col" id="slide">
                <div class="user-text">
                    <p>Emily Johnson là một đầu bếp chuyên nghiệp nổi tiếng với kỹ năng nấu ăn và công thức độc đáo của mình. Cô đã xuất hiện trên nhiều chương trình nấu ăn.</p>
                    <h2>Selena Ansari</h2>
                    <p>Đầu Bếp</p>
                </div>
                <div class="user-img">
                    <img src="../image/testimonial (4).jpg" alt="Emily Johnson">
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial section end -->
    <!-- Mission section start -->
    <div class="mission">
        <div class="box-container">
            <div class="box">
                <div class="heading">
                    <h1>Sứ Mệnh Của Chúng Tôi</h1>
                    <img src="../image/separator-img.png" alt="Separator">
                </div>
                <div class="detail">
                    <div class="img-box">
                        <img src="../image/mission.webp" alt="Hình Ảnh Sứ Mệnh">
                    </div>
                    <div>
                        <h2>Sô-cô-la Mexico</h2>
                        <p>Các lớp kẹo marshmallow hình thù — thỏ, gà con và hoa đơn giản — tạo nên một món quà đáng nhớ trong hộp có ruy băng</p>
                    </div>
                </div>
                <div class="detail">
                    <div class="img-box">
                        <img src="../image/mission1.webp" alt="Vanila với Mật Ong">
                    </div>
                    <div>
                        <h2>Vanila với Mật Ong</h2>
                        <p>Các lớp kẹo marshmallow hình thù — thỏ, gà con và hoa đơn giản — tạo nên một món quà đáng nhớ trong hộp có ruy băng</p>
                    </div>
                </div>
                <div class="detail">
                    <div class="img-box">
                        <img src="../image/mission0.jpg" alt="Chip Bạc Hà">
                    </div>
                    <div>
                        <h2>Chip Bạc Hà</h2>
                        <p>Các lớp kẹo marshmallow hình thù — thỏ, gà con và hoa đơn giản — tạo nên một món quà đáng nhớ trong hộp có ruy băng</p>
                    </div>
                </div>
                <div class="detail">
                    <div class="img-box">
                        <img src="../image/mission2.webp" alt="Sorbet Dâu Tây">
                    </div>
                    <div>
                        <h2>Sorbet Dâu Tây</h2>
                        <p>Các lớp kẹo marshmallow hình thù — thỏ, gà con và hoa đơn giản — tạo nên một món quà đáng nhớ trong hộp có ruy băng</p>
                    </div>
                </div>
            </div>
            <div class="box">
                <img src="../image/form.png" alt="Hình Ảnh Đơn" class="img">
            </div>
        </div>
    </div>
    <!-- Mission section end -->

    <?php include '../components/footer.php'; ?>
    <!-- Your content goes here -->
    <!-- Link to Boxicons CDN -->
    <!-- Custom JS link -->
    <script src="../js/user_script.js"></script>
    
    <?php include '../components/alert.php'; ?>
</body>
</html>
