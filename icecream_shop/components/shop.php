<?php
include '../components/connect.php';
?>
<div class="products">
    <div class="box-container">
        <?php
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE status = 'Đang bán' LIMIT 6");
            $select_products->execute();

            if ($select_products->rowCount() > 0) {
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <form action="" method="post" class="box <?php echo $fetch_products['stock'] == 0 ? 'disabled' : ''; ?>">
                        <?php if (!empty($fetch_products['image'])) { ?>
                            <img src="../uploaded_files/<?= htmlspecialchars($fetch_products['image']); ?>" alt="Hình Ảnh Sản Phẩm" class="image">
                            <?php if ($fetch_products['stock'] > 9) { ?>
                            <span class="stock" style="color: green;">Còn hàng</span>
                        <?php } elseif ($fetch_products['stock'] == 0) { ?>
                            <span class="stock" style="color: red;">Hết hàng</span>
                        <?php } else { ?>
                            <span class="stock" style="color: red;">Nhanh tay, chỉ còn <?= htmlspecialchars($fetch_products['stock']); ?> sản phẩm!</span>
                        <?php } ?>
                        <?php } ?>
                        <div class="content">
                            <img src="../image/shape-19.png" alt="" class="shap">
                            <div class="button">
                                <div>
                                    <h3 class="name"><?= htmlspecialchars($fetch_products['name']); ?></h3>
                                </div>
                                <div>
                                    <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                                    <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                                    <a href="view_page.php?pid=<?= htmlspecialchars($fetch_products['id']); ?>" class="bx bxs-show"></a>
                                </div>
                            </div>
                            <p class="price">Giá: $<?= htmlspecialchars($fetch_products['price']); ?></p>
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">

                            <div class="flex-btn">
                                <a href="checkout.php?get_id=<?= htmlspecialchars($fetch_products['id']); ?>" class="btn">Mua Ngay</a>
                                <input type="number" name="qty" required min="1" value="1" max="99" class="qty box">
                            </div>

                        </div>              
                    </form>
            <?php
                }
            } else {
                echo '
                    <div class="empty">
                        <p>Chưa có sản phẩm nào được thêm!</p>
                    </div>
                ';
            }
        ?>
        </div>
    </div>
