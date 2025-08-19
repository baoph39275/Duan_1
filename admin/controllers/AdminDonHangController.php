
<?php
class AdminDonHangController
{

    public $modelDonHang;

    public function __construct()
    {
        $this->modelDonHang = new AdminDonHang();
        
    }

    public function danhSachDonHang()
    {

        $listDonHang = $this->modelDonHang->getAllDonHang();

        require_once './views/donhang/listDonHang.php';
    }

    public function detailDonHang() {
        $don_hang_id=$_GET['id_don_hang'];

        $donHang=$this->modelDonHang->getDetailDonHang($don_hang_id);
        $sanPhamDonHang = $this->modelDonHang->getListSpDonHang($don_hang_id);
        $listTrangThaiDonHang= $this->modelDonHang->getAllTrangThaiDonHang();
        require_once './views/donhang/detailDonHang.php';
    }
    
    public function formEditDonHang()
    {
        $id = $_GET['id_don_hang'];
        $donHang = $this->modelDonHang->getDetailDonHang($id);
        $listTrangThaiDonHang = $this->modelDonHang->getAllTrangThaiDonHang();
        if ($donHang) {
            require_once './views/donhang/editDonHang.php';
            deleteSessionError();
        } else {
            header("Location: " . BASE_URL_ADMIN . '?act=don-hang');
            exit();
        }
    }

    //     public function detailSanPham() 
    //     {  
    //         $id = $_GET['id_san_pham'];
    //         $sanPham = $this->modelSanPham->getDetailSanPham($id);
    //         // var_dump($sanPham);die;
    //         $listAnhSanPham =$this->modelSanPham->getListAnhSanPham($id);
    //         $listBinhLuan = $this->modelSanPham->getBinhLuanFromSanPham($id);
    //         // var_dump($listAnhSanPham);die;
    //         if($sanPham){
    //             require_once "./views/sanpham/detailSanPham.php";
                
    //         }else{
    //             header("location:".BASE_URL_ADMIN .'?act=san-pham');
    //                 exit();
    //         }
        
    //     }

    public function postEditDonHang()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $don_hang_id = $_POST['don_hang_id'] ?? '';


            $ten_nguoi_nhan = $_POST['ten_nguoi_nhan'] ?? '';
            $sdt_nguoi_nhan = $_POST['sdt_nguoi_nhan'] ?? '';
            $email_nguoi_nhan = $_POST['email_nguoi_nhan'] ?? '';
            $dia_chi_nguoi_nhan = $_POST['dia_chi_nguoi_nhan'] ?? '';
            $ghi_chu = $_POST['ghi_chu'] ?? '';
            $trang_thai_id = $_POST['trang_thai_id'] ?? '';
      

            

            $errors = [];
            if (empty($ten_nguoi_nhan)) {
                $errors['ten_nguoi_nhan'] = 'Tên người nhận không được để trống';
            }
            if (empty($sdt_nguoi_nhan)) {
                $errors['sdt_nguoi_nhan'] = 'Số điện thoại người nhận không được để trống';
            }
            if (empty($email_nguoi_nhan)) {
                $errors['email_nguoi_nhan'] = 'email người nhận không được để trống';
            }
            if (empty($dia_chi_nguoi_nhan)) {
                $errors['dia_chi_nguoi_nhan'] = 'Địa chị người nhận không được để trống';
            }
            if (empty($trang_thai_id)) {
                $errors['trang_thai_id'] = 'Trạng thái đơn hàng';
            }
            

            $_SESSION['error'] = $errors;
             //var_dump($errors);die;
            if (empty($errors)) {
                // Gọi hàm update sản phẩm và chuyển hướng về trang "san-pham"
             $abc =   $this->modelDonHang->updateDonHang($don_hang_id,
                    $ten_nguoi_nhan, 
                    $sdt_nguoi_nhan, 
                    $email_nguoi_nhan, 
                    $dia_chi_nguoi_nhan, 
                    $ghi_chu, 
                    $trang_thai_id,
                    
                );       
         // var_dump($abc);die;
                // Chuyển hướng về trang san-pham sau khi cập nhật thành công
                header("Location: " . BASE_URL_ADMIN . "?act=don-hang");
                exit();
            } else {
                // Nếu có lỗi, chuyển về form sửa sản phẩm với ID của sản phẩm
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . "?act=form-sua-don-hang&id_don_hang=" . $don_hang_id);
                exit();
            }
        }
    }

}    
