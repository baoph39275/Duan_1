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
              <input type="hidden" name="don_hang_id" value="<?= $donHang['id'] ?>">
              <div class="card-body">
                  <div class="form-group">
                    <label >Tên Người Nhận</label>
                    <input type="text" class="form-control" name="ten_nguoi_nhan" value="<?= $donHang['ten_nguoi_nhan'] ?>" placeholder="Nhập tên danh mục">
                    <?php if (isset($errors['ten_nguoi_nhan'])){ ?>
                       <p class="text-danger"><?= $errors['ten_nguoi_nhan'] ?></p>
                  <?php }?>  

                </div>

                 <div class="form-group">
                    <label >Số Điện Thoại</label>
                    <input type="text" class="form-control" name="sdt_nguoi_nhan" value="<?= $donHang['sdt_nguoi_nhan'] ?>" placeholder="Nhập tên danh mục">
                    <?php if (isset($errors['sdt_nguoi_nhan'])){ ?>
                       <p class="text-danger"><?= $errors['sdt_nguoi_nhan'] ?></p>
                  <?php }?>  

                </div>
                 <div class="form-group">
                    <label >Email</label>
                    <input type="text" class="form-control" name="email_nguoi_nhan" value="<?= $donHang['email_nguoi_nhan'] ?>" placeholder="Nhập tên danh mục">
                    <?php if (isset($errors['email_nguoi_nhan'])){ ?>
                       <p class="text-danger"><?= $errors['temail_nguoi_nhan'] ?></p>
                  <?php }?>  

                </div>
                 <div class="form-group">
                    <label >Địa Chỉ</label>
                    <input type="text" class="form-control" name="dia_chi_nguoi_nhan" value="<?= $donHang['dia_chi_nguoi_nhan'] ?>" placeholder="Nhập tên danh mục">
                    <?php if (isset($errors['dia_chi_nguoi_nhan'])){ ?>
                       <p class="text-danger"><?= $errors['dia_chi_nguoi_nhan'] ?></p>
                  <?php }?>  

                </div>
                <div class="form-group">
                    <label >Ghi Chú</label>
                    <textarea name="ghi_chu" id="" class="form-control" placeholder="Nhập mô tả "><?= $donHang['ghi_chu'] ?></textarea>
                  </div>

                  <hr>
                  <div class="form-group">
                <label for="inpusStatus">Trạng Thái Đơn Hàng</label>
                <select name="trang_thai_id" id="" class="form-control custon-select">
                  <?php
                  foreach ($listTrangThaiDonHang as $trangThai) :
                  ?>
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
              <div class="card-footer text-right">
                <button type="submit" class="btn btn-success">
                  <i class="fas fa-save"></i> Lưu thay đổi
                </button>
                <a href="<?= BASE_URL_ADMIN . '?act=don-hang' ?>" class="btn btn-secondary">
                  <i class="fas fa-arrow-left"></i> Quay lại
                </a>
              </div>
            </form>

<!-- footer -->
<?php include './views/layout/footer.php'; ?>
<!-- endfooter -->
