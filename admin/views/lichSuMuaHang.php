<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>

<main>
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="shop.html">shop</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">cart</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->

        <!-- cart main wrapper start -->
        <div class="cart-main-wrapper section-padding">
            <div class="container">
                <div class="section-bg-color">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Cart Table Area -->
                            <div class="cart-table table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Mẫ Đơn Hàng</th>
                                            <th>Ngày Đặt</th>
                                            <th>Tổng tiền</th>
                                            <th>Phương Thức Thanh Toán</th>
                                            <th>Trạng Thái Đơn Hàng</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($donHang as $donHang): 
                                        ?> 
                                        <tr>
                                            <th class="Text-center"><?= $donHang['ma_don_hang'] ?></th>
                                            <td><?= $donHang['ngay_dat'] ?></td>
                                            <td><?= formatPrice($donHang['tong_tien']) ?> đ</td>\
                                            <td><?= $phuongThucThanhToan[$donHang['phuong_thuc_thanh_toan']] ?></td>
                                            <td><?= $trangThaiDonHang[$donHang['trang_thai']] ?></td>
                                            <td>
                                                <?php if ($donHang['trang_thai'] == 1) : ?>
                                                    <a href="<?=BASE_URL?>?act=huy-don-hang&id=<?=$donHang['id']?>"class="btn btn-sqr"
                                                       onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">
                                                        Hủy Đơn Hàng
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
        
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- cart main wrapper end -->
    </main>

<?php require_once 'layout/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>
