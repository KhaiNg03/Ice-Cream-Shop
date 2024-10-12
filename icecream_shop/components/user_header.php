<header class="header">
    <section class="flex">
        <a href="home.php" class="logo">
            <img src="../image/logo.png" width="130px" alt="Logo">
        </a>
        <nav class="navbar">
            <a href="home.php">Trang Chủ</a>
            <a href="about-us.php">Giới Thiệu</a>

            <!-- Menu chính "Cửa Hàng" với dropdown -->
            <div class="dropdown">
                <!-- Điều hướng trực tiếp tới menu.php -->
                <a href="menu.php" class="main-btn">Cửa Hàng</a>
                <div class="dropdown-content">
                    <!-- Dùng form POST để gửi yêu cầu tìm kiếm theo danh mục -->
                    <form action="search_product.php" method="post" class="dropdown-form">
                        <button type="submit" name="search_product" value="Hộp">Hộp</button>
                        <button type="submit" name="search_product" value="Dâu">Dâu</button>
                        <button type="submit" name="search_product" value="Sô">Sô-cô-la</button>
                        <button type="submit" name="search_product" value="Va">Vanila</button>
                    </form>
                </div>
            </div>

            <a href="order.php">Đặt Hàng</a>
            <a href="contact.php">Liên Hệ</a>
        </nav>

        <!-- Phần tìm kiếm sản phẩm -->
        <form action="search_product.php" method="post" class="search-form">
            <input type="text" name="search_product" placeholder="Tìm kiếm sản phẩm..." required maxlength="100">
            <button type="submit" class="bx bx-search-alt-2" id="search_product_btn"><img src="../image/magnifying-glass.png" alt="Tìm kiếm" width="25px" height="25px"></button>
        </form>
        <div class="icons">
            <?php
            include 'connect.php'; 
            if (isset($_COOKIE['user_id'])) {
                $user_id = $_COOKIE['user_id'];
            } else {
                $user_id = '';
            }
            ?>
            <div class="bx bx-list-plus" id="menu-btn"></div>
            <div class="bx bx-search-alt-2" id="search-btn"></div>

            <?php 
            // Đếm số sản phẩm trong danh sách yêu thích
            $count_wishlist_item = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_item->execute([$user_id]);
            $total_wishlist_items = $count_wishlist_item->rowCount();
            ?>

            <a href="wishlist.php">
                <i class="bx bx-heart"><img src="../image/heart.webp" alt="Thêm vào giỏ hàng" width="35px" height="35px"></i>
                <sup><?= $total_wishlist_items; ?></sup>
            </a>

            <?php 
            // Đếm số sản phẩm trong giỏ hàng
            $count_cart_item = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_item->execute([$user_id]);
            $total_cart_items = $count_cart_item->rowCount();
            ?>

            <a href="cart.php">
                <i class="bx bx-cart"><img src="../image/cart.webp" alt="Thêm vào giỏ hàng" width="35px" height="35px"></i>
                <sup><?= $total_cart_items; ?></sup>
            </a>
            <a><i class="bx bxs-user" id="user-btn"><img src="../image/ockphoto.jpg" alt="Hồ sơ người dùng" width="35px" height="35px"></i></a>
        </div>

        <div class="profile-detail">
            <?php
            if (isset($conn) && $conn instanceof PDO) {
                $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_profile->execute([$user_id]);

                if ($select_profile->rowCount() > 0) {
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <img src="../uploaded_files/<?= htmlspecialchars($fetch_profile['image']); ?>" alt="Hình Ảnh Hồ Sơ">
            <h3 style="margin-bottom: 1rem;"><?= htmlspecialchars($fetch_profile['name']); ?></h3>
            <div class="flex-btn">
                <a href="profile.php" class="btn">Hồ Sơ</a>
                <a href="../components/user_logout.php" onclick="return confirm('Bạn có muốn đăng xuất khỏi trang web này không?');" class="btn">Đăng Xuất</a>
            </div>
            <?php
                } else {
            ?>
                <h3 style="margin-bottom: 1rem;">Vui lòng đăng nhập hoặc đăng ký</h3>
                <div class="flex-btn">
                    <a href="login.php" class="btn">Đăng Nhập</a>
                    <a href="register.php" class="btn">Đăng Ký</a>
                </div>
            <?php
            }
            } else {
                echo "<p>Không thể kết nối cơ sở dữ liệu.</p>";
            }
            ?>
        </div>
    </section>
</header>
