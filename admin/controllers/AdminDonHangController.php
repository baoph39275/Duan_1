
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
    
    public function formEditDonHang() {
            $id = $_GET['id_don_hang'];
            $donHang = $this->modelDonHang->getDetailDonHang($id);
            $sanPhamDonHang = $this->modelDonHang->getListSpDonHang($id);
            $listTrangThaiDonHang= $this->modelDonHang->getAllTrangThaiDonHang();
            if($donHang){
                require_once "./views/donhang/editDonHang.php";
                deleteSessionError();
            }else{
                header("location:".BASE_URL_ADMIN .'?act=don-hang');
                    exit();
            }
        

        }
    
    public function postEditDonHang() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $don_hang_id = $_POST['id_don_hang'] ?? '';
            $trang_thai_id = $_POST['trang_thai_id'];
            $errors = [];     
            if (empty($trang_thai_id)) {
                $errors['trang_thai_id'] = 'Trạng thái đơn hàng';
            }
            $_SESSION['error'] = $errors;
           
             if (empty($errors)) {
                // Gọi hàm update sản phẩm và chuyển hướng về trang "san-pham"
                $this->modelDonHang->updateDonHang($trang_thai_id, $don_hang_id);
                // Chuyển hướng về trang san-pham sau khi cập nhật thành công
                header("Location: ".BASE_URL_ADMIN."?act=don-hang");
                exit();
                // var_dump($abc);die();
    
            } else {
                // Nếu có lỗi, chuyển về form sửa sản phẩm với ID của sản phẩm
                $_SESSION['flash'] = true;
                 header("Location: ".BASE_URL_ADMIN."?act=form-sua-don-hang&id_don_hang=".$don_hang_id);
                 exit();
             }
        }



    }    

}
