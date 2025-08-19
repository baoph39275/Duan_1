<?php
class AdminDanhMucController{

    public $modelDanhMuc;
        public function __construct()
        {
            $this->modelDanhMuc = new AdminDanhMuc();
        }

    public function danhSachDanhMuc() {
        
        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
        
        require_once './views/danhmuc/listDanhMuc.php';
    }
    
    public function formAddDanhMuc(){
        // ham nay dung de hien thi form nhap
        require_once './views/danhmuc/addDanhMuc.php';
    }

     public function postAddDanhMuc(){
        // ham nay dung de xu li them du lieu 
        
        // KIEM TRA XEM DU LIEU CO PHAI DUOC SUBMIT LEN KO 
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // lay ra du lieu 
            $ten_danh_muc = $_POST['ten_danh_muc'];
            $mo_ta = $_POST['mo_ta'];
            //tao 1 mang trong de chua du lieu 
            $errors = [];
            if (empty($ten_danh_muc)){
                $errors['ten_danh_muc'] = 'tên danh mục không được để trống';
            }

            // nếu ko có lỗi thì tiến hành thêm danh mục 
            if (empty($errors)){
                // nếu ko có lỗi thì tiến hành thêm danh mục

                $this->modelDanhMuc->insertDanhMuc($ten_danh_muc, $mo_ta);
                header("Location: " . BASE_URL_ADMIN . '?act=danh-muc');
                exit();

            }else {
                // trả về form và lỗi 
                require_once './views/danhmuc/addDanhMuc.php';
            }
        }
    }

     public function formEditDanhMuc(){
        // ham nay dung de hien thi form nhap
        // lấy ra thông tin danh mục cần sửa 
        $id = $_GET['id_danh_muc'];
        $danhMuc =  $this->modelDanhMuc->getDetailDanhMuc($id);
        if ($danhMuc){

            require_once './views/danhmuc/editDanhMuc.php';
        }else {
             header("Location: " . BASE_URL_ADMIN . '?act=danh-muc');
             exit();
        }
        
    }

     public function postEditAddDanhMuc(){
        // ham nay dung de xu li them du lieu 
        
        // KIEM TRA XEM DU LIEU CO PHAI DUOC SUBMIT LEN KO 
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // lay ra du lieu 
            $id = $_POST['id'];
            $ten_danh_muc = $_POST['ten_danh_muc'];
            $mo_ta = $_POST['mo_ta'];
            //tao 1 mang trong de chua du lieu 
            $errors = [];
            if (empty($ten_danh_muc)){
                $errors['ten_danh_muc'] = 'tên danh mục không được để trống';
            }

            // nếu ko có lỗi thì tiến hành sua danh mục 
            if (empty($errors)){
                // nếu ko có lỗi thì tiến hành sua danh mục

                $this->modelDanhMuc->updateDanhMuc($id, $ten_danh_muc, $mo_ta);
                header("Location: " . BASE_URL_ADMIN . '?act=danh-muc');
                exit();
                
            }else {
                // trả về form và lỗi 
                $danhMuc = ['id' => $id, 'ten_danh_muc' => $ten_danh_muc, 'mo_ta' => $mo_ta];
                require_once './views/danhmuc/editDanhMuc.php';
            }
        }
    }

    public function deleteDanhMuc (){
        $id = $_GET['id_danh_muc'];
        $danhMuc =  $this->modelDanhMuc->getDetailDanhMuc($id);

        if ($danhMuc) {
            $this->modelDanhMuc->destroyDanhMuc($id);
        }

        header("Location: " . BASE_URL_ADMIN . '?act=danh-muc');
         exit();
    }
} 