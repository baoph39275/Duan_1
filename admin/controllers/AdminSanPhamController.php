
<?php
class AdminSanPhamController{

    public $modelSanPham;
    public $modelDanhMuc;
        public function __construct()
        {
            $this->modelSanPham = new AdminSanPham();
            $this->modelDanhMuc = new AdminDanhMuc();
        }

    public function danhSachSanPham() {
        
        $listSanPham = $this->modelSanPham->getAllSanPham();
        
        require_once './views/sanpham/listSanPham.php';
    }
    
    public function formAddSanPham(){
        // ham nay dung de hien thi form nhap
        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();

        require_once './views/sanpham/addSanPham.php';
    }

     public function postAddSanPham(){
        // ham nay dung de xu li them du lieu 
        
        // KIEM TRA XEM DU LIEU CO PHAI DUOC SUBMIT LEN KO 
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // lay ra du lieu 
            $ten_san_pham = $_POST['ten_san_pham'];
            $gia_san_pham = $_POST['gia_san_pham'];
            $gia_khuyen_mai = $_POST['gia_khuyen_mai'];
            $so_luong = $_POST['so_luong'];
            $ngay_nhap = $_POST['ngay_nhap'];
            $danh_muc_id = $_POST['danh_muc_id'];
            $trang_thai = $_POST['trang_thai'];
            $mo_ta = $_POST['mo_ta'];

            $hinh_anh = $_FILES['hinh_anh'];

            // luu hinh anh vao 
            $file_thumb = uploadFile($hinh_anh, './uploads/');

            // mang hinh anh
            $img_array = $_FILES['img_array'];


            //tao 1 mang trong de chua du lieu 
            $errors = [];
            if (empty($ten_san_pham)){
                $errors['$ten_san_pham'] = 'tên sản phẩm không được để trống';
            }

            if (empty($gia_san_pham)){
                $errors['$gia_san_pham'] = 'giá sản phẩm không được để trống';
            }

            if (empty($gia_khuyen_mai)){
                $errors['$ten_san_pham'] = 'giá khuyến mãi sản phẩm không được để trống';
            }

            if (empty($so_luong)){
                $errors['$so_luong'] = 'số lượng sản phẩm không được để trống';
            }

            if (empty($ngay_nhap)){
                $errors['$ngay_nhap'] = 'ngày nhập sản phẩm không được để trống';
            }

            if (empty($danh_muc_id)){
                $errors['$danh_muc_id'] = 'danh mục sản phẩm phải chọn';
            }

            if (empty($trang_thai)){
                $errors['$trang_thai'] = 'trạng thái sản phẩm phải chọn';
            }

            

            // nếu ko có lỗi thì tiến hành thêm sản phẩm
            if (empty($errors)){
                // nếu ko có lỗi thì tiến hành thêm sản phẩm

                $this->modelSanPham->insertSanPham($ten_san_pham,
                                                    $gia_san_pham,
                                                    $gia_khuyen_mai,
                                                    $so_luong,
                                                    $ngay_nhap,
                                                    $danh_muc_id,
                                                    $trang_thai,
                                                    $mo_ta,
                                                    $file_thumb
                                                );
                header("Location: " . BASE_URL_ADMIN . '?act=san-pham');
                exit();

            }else {
                // trả về form và lỗi 
                require_once './views/sanpham/addSanPham.php';
            }
        }
    }

    //  public function formEditDanhMuc(){
    //     // ham nay dung de hien thi form nhap
    //     // lấy ra thông tin danh mục cần sửa 
    //     $id = $_GET['id_danh_muc'];
    //     $danhMuc =  $this->modelDanhMuc->getDetailDanhMuc($id);
    //     if ($danhMuc){

    //         require_once './views/danhmuc/editDanhMuc.php';
    //     }else {
    //          header("Location: " . BASE_URL_ADMIN . '?act=danh-muc');
    //          exit();
    //     }
        
    // }

    //  public function postEditAddDanhMuc(){
    //     // ham nay dung de xu li them du lieu 
        
    //     // KIEM TRA XEM DU LIEU CO PHAI DUOC SUBMIT LEN KO 
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    //         // lay ra du lieu 
    //         $id = $_POST['id'];
    //         $ten_danh_muc = $_POST['ten_danh_muc'];
    //         $mo_ta = $_POST['mo_ta'];
    //         //tao 1 mang trong de chua du lieu 
    //         $errors = [];
    //         if (empty($ten_danh_muc)){
    //             $errors['ten_danh_muc'] = 'tên danh mục không được để trống';
    //         }

    //         // nếu ko có lỗi thì tiến hành sua danh mục 
    //         if (empty($errors)){
    //             // nếu ko có lỗi thì tiến hành sua danh mục

    //             $this->modelDanhMuc->updateDanhMuc($id, $ten_danh_muc, $mo_ta);
    //             header("Location: " . BASE_URL_ADMIN . '?act=danh-muc');
    //             exit();
                
    //         }else {
    //             // trả về form và lỗi 
    //             $danhMuc = ['id' => $id, 'ten_danh_muc' => $ten_danh_muc, 'mo_ta' => $mo_ta];
    //             require_once './views/danhmuc/editDanhMuc.php';
    //         }
    //     }
    // }

    // public function deleteDanhMuc (){
    //     $id = $_GET['id_danh_muc'];
    //     $danhMuc =  $this->modelDanhMuc->getDetailDanhMuc($id);

    //     if ($danhMuc) {
    //         $this->modelDanhMuc->destroyDanhMuc($id);
    //     }

    //     header("Location: " . BASE_URL_ADMIN . '?act=danh-muc');
    //      exit();
    // }
} 
