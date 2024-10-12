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
    <title>Blue Sky Summer - Trang Chủ</title>
    <link rel="stylesheet" type="text/css" href="../css/user_style.css">
</head>
<body>
    <?php include '../components/user_header.php'; ?>
    <!-- slider section start -->
    <div class="slider-container">
        <div class="slider">
            <div class="slideBox active">
                <div class="textBox">
                    <h1>Chúng tôi tự hào về <br> hương vị tuyệt vời</h1>
                    <a href="menu.php" class="btn">Mua Ngay</a>
                </div>
                <div class="imageBox">
                    <img src="../image/slider.jpg">
                </div>
            </div>
            <div class="slideBox">
                <div class="textBox">
                    <h1>Những món lạnh là <br> món ăn an ủi của tôi</h1>
                    <a href="menu.php" class="btn">Mua Ngay</a>
                </div>
                <div class="imgBox">
                    <img src="../image/slider0.jpg" alt="Slider Image">
                </div>
            </div>
        </div>
        <ul class="controls">
            <li onclick="nextSlide();" class="next">
                <i class="bx bx-right-arrow-alt"></i>
            </li>
            <li onclick="prevSlide();" class="prev">
                <i class="bx bx-left-arrow-alt"></i>
            </li>
        </ul>
    </div>
    <!-- slider section end -->
    <div class="service">
        <div class="box-container">
            <!-- service item box 1 -->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="../image/services.png" class="img1" alt="Hình Ảnh Dịch Vụ 1">
                        <img src="../image/services (1).png" class="img2" alt="Hình Ảnh Dịch Vụ 1">
                    </div>
                </div>
                <div class="detail">
                    <h3>Giao Hàng</h3>
                    <span>100% an toàn</span>
                </div>
            </div>
            <!-- service item box 2 -->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="../image/services (2).png" class="img1" alt="Hình Ảnh Dịch Vụ 2">
                        <img src="../image/services (3).png" class="img2" alt="Hình Ảnh Dịch Vụ 2">
                    </div>
                </div>
                <div class="detail">
                    <h3>Thanh Toán</h3>
                    <span>100% an toàn</span>
                </div>
            </div>
            <!-- service item box 3 -->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="../image/services (5).png" class="img1" alt="Hình Ảnh Dịch Vụ 3">
                        <img src="../image/services (6).png" class="img2" alt="Hình Ảnh Dịch Vụ 3">
                    </div>
                </div>
                <div class="detail">
                    <h4>Hỗ Trợ</h4>
                    <span>24/7</span>
                </div>
            </div>
        </div>
        <!-- first box-container end -->
        <div class="box-container">
            <!-- service item box 4 -->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="../image/services (7).png" class="img1" alt="Hình Ảnh Dịch Vụ 4">
                        <img src="../image/services (8).png" class="img2" alt="Hình Ảnh Dịch Vụ 4">
                    </div>
                </div>
                <div class="detail">
                    <h4>Tặng cho bạn</h4>
                    <span>Hỗ trợ dịch vụ quà tặng</span>
                </div>
            </div>
            <!-- service item box 5 -->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="../image/service.png" class="img1" alt="Hình Ảnh Dịch Vụ 5">
                        <img src="../image/service (1).png" class="img2" alt="Hình Ảnh Dịch Vụ 5">
                    </div>
                </div>
                <div class="detail">
                    <h4>Trả Hàng</h4>
                    <span>Trả hàng miễn phí 24/7</span>
                </div>
            </div>
            <!-- service item box 6 -->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="../image/services.png" class="img1" alt="Hình Ảnh Dịch Vụ 6">
                        <img src="../image/services (1).png" class="img2" alt="Hình Ảnh Dịch Vụ 6">
                    </div>
                </div>
                <div class="detail">
                    <h4>Giao Hàng</h4>
                    <span>100% an toàn</span>
                </div>
            </div>
        </div>
        <!-- second box-container end -->
    </div>
    <!-- service section end -->
    <div class="categories">
        <div class="heading">
            <h1>Danh Mục Nổi Bật</h1>
            <img src="../image/separator-img.png" alt="Hình Ảnh Phân Cách">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="../image/categories.jpg" alt="Dừa">
                <a href="menu.php" class="btn">Dừa</a>
            </div>
            <div class="box">
                <img src="../image/categories0.jpg" alt="Sô-cô-la">
                <a href="menu.php" class="btn">Sô-cô-la</a>
            </div>
            <div class="box">
                <img src="../image/categories2.jpg" alt="Dâu Tây">
                <a href="menu.php" class="btn">Dâu Tây</a>
            </div>
            <div class="box">
                <img src="../image/categories1.jpg" alt="Ngô">
                <a href="menu.php" class="btn">Ngô</a>
            </div>
        </div>
    </div>
    <!-- Categories section end -->
    <img src="../image/menu-banner.jpg" class="menu-banner">
    <div class="taste">
        <div class="heading">
            <span>Hương Vị</span>
            <h1>Mua bất kỳ kem nào & nhận một cái miễn phí</h1>
            <img src="../image/separator-img.png" alt="Phân Cách">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="../image/taste.webp" alt="Ngọt Ngào Tự Nhiên - Vanila">
                <div class="detail">
                    <h2>Ngọt Ngào Tự Nhiên</h2>
                    <h1>Vanila</h1>
                </div>
            </div>
            <div class="box">
                <img src="../image/taste0.webp" alt="Ngọt Ngào Tự Nhiên - Matcha">
                <div class="detail">
                    <h2>Ngọt Ngào Tự Nhiên</h2>
                    <h1>Matcha</h1>
                </div>
            </div>
            <div class="box">
                <img src="../image/taste1.webp" alt="Ngọt Ngào Tự Nhiên - Việt Quất">
                <div class="detail">
                    <h2>Ngọt Ngào Tự Nhiên</h2>
                    <h1>Việt Quất</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- container section end -->
    <div class="ice-container">
        <div class="overlay"></div>
        <div class="detail">
        <h1>Kem rẻ hơn <br> liệu pháp giảm căng thẳng</h1>
        <p>
            Hãy thưởng thức một ly kem ngon tuyệt, <br>
            một cách đơn giản để xua tan mọi căng thẳng trong ngày. <br>
            Với vị ngọt mát lạnh, kem sẽ giúp bạn thư giãn <br>
            và tận hưởng những khoảnh khắc thật sự thoải mái.
        </p>        
            <a href="menu.php" class="btn">Mua Ngay</a>
        </div>
    </div>
    <!-- container section end -->
    <!-- taste2 section -->
    <div class="taste2">
        <div class="t-banner">
            <div class="overlay"></div>
            <div class="detail">
                <h1>Tìm Kiếm Hương Vị Món Tráng Miệng Của Bạn</h1>
                <p>Đối xử với họ bằng một món ăn ngon và gửi cho họ một chút may mắn!</p>
                <a href="menu.php" class="btn">Mua Ngay</a>
            </div>
        </div>
        <div class="box-container">
            <div class="box">
                <div class="box-overlay"></div>
                <img src="../image/type4.jpg">
                <div class="box-details fadeIn-bottom">
                    <h1>Dâu Tây</h1>
                    <p>Tìm kiếm hương vị món tráng miệng của bạn</p>
                    <a href="menu.php" class="btn">Khám Phá Thêm</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src="../image/type.avif">
                <div class="box-details fadeIn-bottom">
                    <h1>Sô-cô-la</h1>
                    <p>Tìm kiếm hương vị món tráng miệng của bạn</p>
                    <a href="menu.php" class="btn">Khám Phá Thêm</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src="../image/type1.png">
                <div class="box-details fadeIn-bottom">
                    <h1>Vanila</h1>
                    <p>Tìm kiếm hương vị món tráng miệng của bạn</p>
                    <a href="menu.php" class="btn">Khám Phá Thêm</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src="../image/type2.png">
                <div class="box-details fadeIn-bottom">
                    <h1>Dâu Tây</h1>
                    <p>Tìm kiếm hương vị món tráng miệng của bạn</p>
                    <a href="menu.php" class="btn">Khám Phá Thêm</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src="../image/type0.avif">
                <div class="box-details fadeIn-bottom">
                    <h1>Dâu Tây</h1>
                    <p>Tìm kiếm hương vị món tráng miệng của bạn</p>
                    <a href="menu.php" class="btn">Khám Phá Thêm</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src="../image/type4.jpg">
                <div class="box-details fadeIn-bottom">
                    <h1>Dâu Tây</h1>
                    <p>Tìm kiếm hương vị món tráng miệng của bạn</p>
                    <a href="menu.php" class="btn">Khám Phá Thêm</a>
                </div>
            </div>
        </div>
    </div>
    <!-- taste2 section end -->
    <div class="flavor">
      <div class="box-container">
        <img src="../image/left-banner2.webp" alt="Hình Ảnh Banner">
        <div class="detail">
          <h1>Ưu Đãi Nóng! Giảm Giá Lên Đến <span>20%</span></h1>
          <p>Ưu đãi sẽ hết hạn sớm!</p>
          <a href="menu.php" class="btn">Mua Ngay</a>
        </div>
      </div>
    </div>
    <!-- flavor section end -->
    <div class="usage">
    <div class="heading">
        <h1>Cách Thức Hoạt Động</h1>
        <img src="../image/separator-img.png" alt="Phân Cách">
    </div>
    <div class="row">
        <div class="box-container">
            <div class="box">   
                <img src="../image/icon.avif" alt="Biểu Tượng">
                <div class="detail">
                    <h3>Kem Ly Vành Hoa</h3>
                    <p>Thưởng thức hương vị độc đáo của kem ly với vành hoa tinh tế, mang đến trải nghiệm đầy quyến rũ.</p>
                </div>
            </div>
            <div class="box">
                <img src="../image/icon0.avif">
                <div class="detail">
                    <h3>Kem Ốc Quế</h3>
                    <p>Hãy tận hưởng một cây kem ốc quế giòn tan, hòa quyện cùng lớp kem mịn màng đầy hấp dẫn.</p>
                </div>
            </div>
            <div class="box">
                <img src="../image/icon1.avif">
                <div class="detail">
                    <h3>Kem Que Dưa Hấu</h3>
                    <p>Kem que dưa hấu mát lạnh, giải nhiệt cho những ngày hè nắng nóng, đem lại sự tươi mát.</p>
                </div>
            </div>
        </div>
        <img src="../image/sub-banner.png" class="divider">
        <div class="box-container">
            <div class="box">   
                <img src="../image/icon2.avif" alt="Biểu Tượng">
                <div class="detail">
                    <h3>Kem Ly Tròn Hoàng Gia</h3>
                    <p>Trải nghiệm sự sang trọng với kem ly tròn hoàng gia, hương vị đẳng cấp cho những phút giây thư giãn.</p>
                </div>
            </div>
            <div class="box">
                <img src="../image/icon3.avif">
                <div class="detail">
                    <h3>Kem Que Truyền Thống</h3>
                    <p>Hương vị truyền thống vẫn mãi mãi giữ nguyên, kem que mang lại cảm giác quen thuộc, ấm áp.</p>
                </div>
            </div>
            <div class="box">
                <img src="../image/icon4.avif">
                <div class="detail">
                    <h3>Kem Ly Hoa Quả</h3>
                    <p>Thưởng thức sự tươi mới của kem ly hoa quả, với hương vị tự nhiên từ trái cây tươi ngon.</p>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- usage section end -->
    <div class="pride">
        <div class="detail">
        <h1>Chúng Tôi Tự Hào Về Hương Vị Tuyệt Vời.</h1>
        <p>Chúng tôi luôn đặt chất lượng và hương vị lên hàng đầu, <br>
        để mang đến cho bạn trải nghiệm kem tuyệt hảo và đáng nhớ.</p>
            <a href="menu.php" class="btn">Mua Ngay</a>
        </div>
    </div>
    <!-- Pride section end -->
    <?php include '../components/footer.php'; ?>
    <!-- Your content goes here -->
    <!-- Link to Boxicons CDN -->
    <script src="../js/user_script.js"></script>
    
    <?php include '../components/alert.php'; ?>
</body>
</html>
