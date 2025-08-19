<?php 
class AdminTaiKhoanController
{
    public $modelTaiKhoan;
    public $modelDonHang;
    public $modelSanPham;
    public function __construct()
    {

        $this->modelTaiKhoan = new AdminTaiKhoan();
        $this->modelDonHang = new AdminDonHang();
        $this->modelSanPham = new AdminSanPham();
    }
    public function danhSachQuanTri()
    {
        $listQuanTri = $this->modelTaiKhoan->getAllTaiKhoan(1);
        // var_dump($listQuanTri);die();
        require_once './views/taikhoan/quantri/listQuanTri.php';
    }
    public function formAddQuanTri()
    {

        require_once "./views/taikhoan/quantri/addQuanTri.php";

        deleteSessionError();
    }
        public function postAddQuanTri()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $chuc_vu_id = $_POST['chuc_vu_id'] ?? 1;
            $ho_ten = $_POST['ho_ten'] ?? '';
            $email = $_POST['email'] ?? '';



            $errors = [];
            if (empty($ho_ten)) {
                $errors['ho_ten'] = 'Họ tên không trống';
            }
            if (empty($email)) {
                $errors['email'] = 'Email không trống';
            }

            $_SESSION['error'] = $errors;

            if (empty($errors)) {

                $password = password_hash('123@123ab', PASSWORD_BCRYPT);
                $chuc_vu_id = 1;
                $this->modelTaiKhoan->insertTaiKhoan($ho_ten, $email, $password, $chuc_vu_id);
                header("Location:" . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
                exit();
            } else {
                $_SESSION['flash'] = true;
                header("location:" . BASE_URL_ADMIN . '?act=form-them-quan-tri');
                exit();
            }
        }
    }
}