<!-- header -->
<?php include './views/layout/header.php'; ?>
<!-- endheader -->
<!-- Navbar -->
<?php include './views/layout/navbar.php'; ?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php include './views/layout/sidebar.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="text-primary">Quản lý thông tin đơn hàng</h1>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Order Edit Card -->
          <div class="card shadow">
            <div class="card-header bg-primary text-white">
              <h3 class="card-title">Sửa thông tin đơn hàng: <?= $donHang['ma_don_hang'] ?></h3>
            </div>

            <form action="<?= BASE_URL_ADMIN . '?act=sua-don-hang' ?>" method="POST">
              <input type="hidden" name="id_don_hang" value="<?= $donHang['id'] ?>">
              <div class="card-body">
                <!-- Status Alert -->
                <div class="alert alert-<?= $colorAlerts ?>" role="alert">
                  <b>Đơn hàng:</b> <?= $donHang['ten_trang_thai'] ?>
                  <strong class="float-right">Ngày đặt: <?=formatDate($donHang['ngay_dat'])?></strong>
                </div>
                <!-- Invoice Section -->
                <div class="row">
                  <!-- Order Information -->
                  <div class="col-md-4 mb-3">
                    <h4><b>Thông tin người đặt</b></h4>
                    <p><strong><?= $donHang['ho_ten'] ?></strong></p>
                    <p><b>Email:</b> <?= $donHang['email'] ?></p>
                    <p><b>Số điện thoại:</b> <?= $donHang['so_dien_thoai'] ?></p>
                  </div>

                  <!-- Recipient Information -->
                  <div class="col-md-4 mb-3">
                    <h4><b>Thông tin người nhận</b></h4>
                    <p><strong><?= $donHang['ten_nguoi_nhan'] ?></strong></p>
                    <p><b>Email:</b> <?= $donHang['email_nguoi_nhan'] ?></p>
                    <p><b>Số điện thoại:</b> <?= $donHang['sdt_nguoi_nhan'] ?></p>
                    <p><b>Địa chỉ:</b> <?= $donHang['dia_chi_nguoi_nhan'] ?></p>
                  </div>

                  <!-- General Order Details -->
                  <div class="col-md-4 mb-3">
                    <h4><b>Thông tin đơn hàng</b></h4>
                    <p><strong>Mã đơn hàng: </strong> <?= $donHang['ma_don_hang'] ?></p>
                    <p><strong>Tổng tiền: </strong> <?= $donHang['tong_tien'] ?></p>
                    <p><strong>Ghi chú: </strong> <?= $donHang['ghi_chu'] ?></p>
                    <p><strong>Thanh toán: </strong> <?= $donHang['ten_phuong_thuc'] ?></p>
                  </div>
                </div>

                <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>STT</th>
                      <th>Tên sản phẩm</th>
                      <th>Đơn giá</th>
                      <th>Số lượng</th>
                      <th>Thành tiền</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $tong_tien=0; ?>
                        <?php foreach ($sanPhamDonHang as $key=>$sanPham):?>
                    <tr>
                      <td><?= $key+1 ?></td>
                      <td><?= $sanPham['ten_san_pham'] ?></td>
                      <td><?= $sanPham['don_gia'] ?></td>
                      <td><?= $sanPham['so_luong'] ?></td>
                      <td><?= $sanPham['thanh_tien'] ?></td>
                    </tr>
                    <?php $tong_tien += $sanPham['thanh_tien'];?>
                    <?php endforeach;?>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>

                <!-- Status Update -->
                <div class="form-group">
                  <label for="inpusStatus">Trạng thái đơn hàng</label>
                  <select name="trang_thai_id" id="" class="form-control custon-select">
                    <?php
                    foreach ($listTrangThaiDonHang as $trangThai) : ?>
                      <option
                        <?php
                        if (
                          $donHang['trang_thai_id'] > $trangThai['id']
                          || $donHang['trang_thai_id'] == 9
                          || $donHang['trang_thai_id'] == 10
                          || $donHang['trang_thai_id'] == 11
                        ) {
                          echo 'disabled';
                        }
                        ?>
                        <?= $trangThai['id'] == $donHang['trang_thai_id'] ? 'selected' : '' ?>
                        value="<?= $trangThai['id']; ?>">
                        <?= $trangThai['ten_trang_thai']; ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>

              <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>
</div>

<!-- footer -->
<?php include './views/layout/footer.php'; ?>
<!-- endfooter -->
