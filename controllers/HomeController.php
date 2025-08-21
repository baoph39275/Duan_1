<?php

class HomeController
{
    public $modelSanPham;
    public $modelTaiKhoan;
    public $modelGioHang;
    public $modelDonHang;


    public function __construct()
    {
        $this->modelSanPham = new SanPham();
        $this->modelTaiKhoan = new TaiKhoan();
        $this->modelGioHang = new GioHang();
        $this->modelDonHang = new DonHang();
    }
    public function home()
    {
        $listSanPham = $this->modelSanPham->getAllSanPham();
        require_once './views/home.php';
    }
    public function chiTietSanPham()
    {
        // Hàm này dùng để hiển thị form nhập
        // Lấy ra thông tin của sản phẩm cần sửa
        $id = $_GET['id_san_pham'];

        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        // var_dump($sanPham);die;
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        // var_dump($listAnhSanPham);die;
        $listBinhLuan = $this->modelSanPham->getBinhLuanFromSanPham($id);

        $listSanPhamCungDanhMuc = $this->modelSanPham->getListSanPhamDanhMuc($sanPham['danh_muc_id']);
        // var_dump($listSanPhamCungDanhMuc);die;

        if ($sanPham) {
            require_once './views/detailSanPham.php';
        } else {
            header("Location: " . BASE_URL);
            exit();
        }
    }
    public function formLogin()
    {
        require_once './views/auth/formLogin.php';

        deleteSessionError();
    }

    public function postLogin()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // lấy mail và pass gửi từ form 

            $email = $_POST['email'];
            $password = $_POST['password'];

            // var_dump($password);die;


            // xử lý kiểm tra thông tin đăng nhập 

            $user = $this->modelTaiKhoan->checkLogin($email, $password);

            if ($user == $email) { // trường hợp đăng nhập thành công
                // lưu thông tin vào session 
                $_SESSION['user_client'] = $user;
                header("Location:" . BASE_URL);
                exit;
            } else {
                // lỗi thì lưu lỗi vào session
                $_SESSION['error'] = $user;
                // var_dump($_SESSION['error']); die;

                $_SESSION['flash'] = true;

                header("Location:" . BASE_URL . '?act=login');

                exit;
            }
        }
    }

        public function addGioHang()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_SESSION['user_client'])) {
                $mail = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);

                // Lấy dữ liệu giỏ hàng của người dùng
                // var_dump($mail['id']);die;
                $gioHang = $this->modelGioHang->getGioHangFromUser($mail['id']);
                if (!$gioHang) {
                    $gioHangId = $this->modelGioHang->addGioHang($mail['id']);
                    $gioHang = ['id' => $gioHangId];
                    $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
                } else {
                    $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
                }
                $san_pham_id = $_POST['san_pham_id'];
                $so_luong = $_POST['so_luong'];

                $checkSanPham = false;
                foreach ($chiTietGioHang as $detail) {
                    if ($detail['san_pham_id'] == $san_pham_id) {
                        $newSoLuong = $detail['so_luong'] + $so_luong;
                        $this->modelGioHang->updateSoLuong($gioHang['id'], $san_pham_id, $newSoLuong);
                        $checkSanPham = true;
                        break;
                    }
                }
                if (!$checkSanPham) {
                    $this->modelGioHang->addDetailGioHang($gioHang['id'], $san_pham_id, $so_luong);
                }
                // var_dump('Thêm giỏ hàng thành công');die;
                header("Location: " . BASE_URL . '?act=gio-hang');
            } else {
                var_dump('Chưa đăng nhập');
                die;
            }
        }
    }

    public function gioHang()
    {
        if (isset($_SESSION['user_client'])) {
            $mail = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);

            // Lấy dữ liệu giỏ hàng của người dùng
            // var_dump($mail['id']);die;
            $gioHang = $this->modelGioHang->getGioHangFromUser($mail['id']);
            if (!$gioHang) {
                $gioHangId = $this->modelGioHang->addGioHang($mail['id']);
                $gioHang = ['id' => $gioHangId];
                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
            } else {
                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
            }
            // var_dump($chiTietGioHang);die;

            require_once './views/gioHang.php';
        } else {
            header("Location: " . BASE_URL . '?act=login');
        }
    }

    public function thanhToan(){
        if (isset($_SESSION['user_client'])) {
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);

            // Lấy dữ liệu giỏ hàng của người dùng
            // var_dump($mail['id']);die;
            $gioHang = $this->modelGioHang->getGioHangFromUser($user['id']);
            if (!$gioHang) {
                $gioHangId = $this->modelGioHang->addGioHang($user['id']);
                $gioHang = ['id' => $gioHangId];
                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
            } else {
                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
            }
            // var_dump($chiTietGioHang);die;

             require_once './views/thanhToan.php';
        } else {
            header("Location: " . BASE_URL . '?act=login');
        }
       
    }

    public function postThanhToan(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // var_dump($_POST);die;

            // Lấy ra dữ liệu
            $ten_nguoi_nhan = $_POST['ten_nguoi_nhan'];
            $email_nguoi_nhan = $_POST['email_nguoi_nhan'];
            $sdt_nguoi_nhan = $_POST['sdt_nguoi_nhan'];
            $dia_chi_nguoi_nhan = $_POST['dia_chi_nguoi_nhan'];
            $ghi_chu = $_POST['ghi_chu'];
            $tong_tien = $_POST['tong_tien'];
            $phuong_thuc_thanh_toan_id = $_POST['phuong_thuc_thanh_toan_id'];

            $ngay_dat = date('Y-m-d');
            $trang_thai_id = 1;

            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
            $tai_khoan_id = $user['id'];

            $ma_don_hang = 'DH' . rand(1000,9999);

            // Thêm thông tin vào db
            $donHang = $this->modelDonHang->adDonHang(
                $tai_khoan_id,
                $ten_nguoi_nhan,
                $email_nguoi_nhan,
                $sdt_nguoi_nhan,
                $dia_chi_nguoi_nhan,
                $ghi_chu,
                $tong_tien,
                $phuong_thuc_thanh_toan_id,
                $ngay_dat,
                $ma_don_hang,
                $trang_thai_id
            );
            // var_dump('Thêm thành công');die;
            // lay thong tin gio hang cua nguoi dung
            $gioHang = $this->modelGioHang->getGioHangFromUser($tai_khoan_id);

            // luu san pham vao chi tiet don hang
            if ($donHang) {
                // lay toan bo san pham trong gio hang
                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
                // them tung san pham tu gio hang vao bang chi tiet don hang
                foreach ($chiTietGioHang as $item) {
                    $donGia = $item['gia_khuyen_mai'] ?? $item['gia_san_pham']; // uu tien don gia se lay gia khuyen mai

                    $this->modelDonHang->addChiTietDonHang(
                        $donHang, // id_don_hang
                        $item['san_pham_id'], // id_san_pham
                        $donGia, // đơn giá lấy từ sản phẩm
                        $item['so_luong'], // số lượng
                        $donGia * $item['so_luong'] // tổng tiền

                    );
                }
                // sau khi them xong thi phai tien hanh xoa san pham trong gio hang
                // xoa toan bo san pham trong chi tiet gio hang 
                $this->modelGioHang->clearDetailGioHang($gioHang['id']);
                // xoa thong tin gio hang nguoi dung 
                $this->modelGioHang->clearGioHang($tai_khoan_id);
                // chuyen huong ve trang lich su mua hang 
                // header("Location: " . BASE_URL . '?act=lich-su-mua-hang');
                exit();
            } else{
                var_dump('lỗi đặt hàng thất bại. Vui lòng thử lại sau');
                die;
            }
        }
    
    }
}
