<header>
    <div class="logo">
        <img src="../image/logo.png" width="150">
    </div>
    <div class="right">
        <div class="bx bxs-user" id="user-btn"></div>
        <div class="toggle-btn"><i class="bx bx-menu"></i></div>
    </div>
    <div class="profile-detail">
        <?php
            if ($conn instanceof PDO) {
                $select_profile = $conn->prepare("SELECT * FROM `sellers` WHERE id = ?");
                $select_profile->execute([$seller_id]);

                if ($select_profile->rowCount() > 0) {
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="profile">
            <img src="../uploaded_files/<?= htmlspecialchars($fetch_profile['image']); ?>" class="logo-img" width="100">
            <p><?= htmlspecialchars($fetch_profile['name']); ?></p>
            <div class="flex-btn">
                <a href="profile.php" class="btn">Hồ sơ</a>
                <a href="../admin_panel/admin_logout.php" onclick="return confirm('Bạn có muốn đăng xuất khỏi trang web này không?');" class="btn">Đăng xuất</a>
            </div>
        </div>
        <?php 
                } else {
                    echo '<p>Không tìm thấy hồ sơ.</p>';
                }
            } else {
                echo '<p>Kết nối cơ sở dữ liệu không khả dụng.</p>';
            }
        ?>
    </div>
</header>
<div class="sidebar-container">
    <div class="sidebar">
        <?php
        if ($conn instanceof PDO) {
            $select_profile = $conn->prepare("SELECT * FROM `sellers` WHERE id = ?");
            $select_profile->execute([$seller_id]);

            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="profile">
            <img src="../uploaded_files/<?= htmlspecialchars($fetch_profile['image']); ?>" class="logo-img" width="100">
            <p><?= htmlspecialchars($fetch_profile['name']); ?></p>
        </div>
        <?php 
            } 
        }
        ?>
        <h5>Menu</h5>
        <div class="navbar">    
            <ul>
                <li><a href="dashboard.php"><i class ="bx bxs-home-smile"></i>Bảng điều khiển</a></li>
                <li><a href="add_products.php"><i class="bx bxs-shopping-bags"></i>Thêm sản phẩm</a></li>
                <li><a href="view_product.php"><i class="bx bxs-food-menu"></i>Xem sản phẩm</a></li>
                <li><a href="user_accounts.php"><i class="bx bxs-user-detail"></i>Tài khoản</a></li>
                <li><a href="../admin_panel/admin_logout.php" onclick="return confirm('Bạn có muốn đăng xuất khỏi trang web này không?');"><i class="bx bx-log-out"></i>Đăng xuất</a></li>
            </ul>
        </div>
    </div>
</div>
