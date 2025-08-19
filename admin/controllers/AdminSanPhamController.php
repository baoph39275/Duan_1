
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

        //xóa session sau khi load trang 
        deleteSessionError();
    }

     public function postAddSanPham(){
        // ham nay dung de xu li them du lieu 
        
        // KIEM TRA XEM DU LIEU CO PHAI DUOC SUBMIT LEN KO 
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // lay ra du lieu 
            $ten_san_pham = $_POST['ten_san_pham'] ?? '';
            $gia_san_pham = $_POST['gia_san_pham']?? '';
            $gia_khuyen_mai = $_POST['gia_khuyen_mai']?? '';
            $so_luong = $_POST['so_luong']?? '';
            $ngay_nhap = $_POST['ngay_nhap']?? '';
            $danh_muc_id = $_POST['danh_muc_id']?? '';
            $trang_thai = $_POST['trang_thai']?? '';
            $mo_ta = $_POST['mo_ta']?? '';

            $hinh_anh = $_FILES['hinh_anh'] ?? null;

            // luu hinh anh vao 
            $file_thumb = uploadFile($hinh_anh, './uploads/');

            // mang hinh anh
            $img_array = $_FILES['img_array'];


            //tao 1 mang trong de chua du lieu 
            $errors = [];
           if(empty($ten_san_pham)){
                $errors['ten_san_pham'] = 'Tên san pham không trống';
            }
            if(empty($gia_san_pham )){
                $errors['gia_san_pham '] = 'Gia san pham không trống';
            }
            if(empty($gia_khuyen_mai)){
                $errors['gia_khuyen_mai'] = 'gia khuyen mai không trống';
            }
            if(empty($so_luong)){
                $errors['so_luong'] = 'Số lượng san pham không trống';
            }
            if(empty($ngay_nhap)){
                $errors['ngay_nhap'] = 'ngay nhap san pham không trống';
            }
            if(empty($danh_muc_id)){
                $errors['danh_muc_id'] = 'Danh muc san pham phải chọn';
            }
            if(empty($trang_thai)){
                $errors['trang_thai'] = 'trang thai san pham không trống';
            }
            if($hinh_anh['error'] !== 0){
                $errors['hinh_anh'] = 'hinh anh san pham không trống';
            }

            $_SESSION['error'] = $errors;
            

            // nếu ko có lỗi thì tiến hành thêm sản phẩm
            if (empty($errors)){
                // nếu ko có lỗi thì tiến hành thêm sản phẩm

                $san_pham_id = $this->modelSanPham->insertSanPham($ten_san_pham,
                                                    $gia_san_pham,
                                                    $gia_khuyen_mai,
                                                    $so_luong,
                                                    $ngay_nhap,
                                                    $danh_muc_id,
                                                    $trang_thai,
                                                    $mo_ta,
                                                    $file_thumb
                                                );
                //xử lý thêm album ảnh sản phẩm img_array
                if(!empty($img_array['name'])){
                    foreach($img_array['name'] as $key =>$value){
                        $file = [
                            'name' => $img_array['name'][$key],
                            'type' => $img_array['type'][$key],
                            'tmp_name' => $img_array['tmp_name'][$key],
                            'error' => $img_array['error'][$key],
                            'size' => $img_array['size'][$key],
                        ];
                        $link_hinh_anh = uploadFile($file, './uploads/');
                        $this->modelSanPham->insertAlbumAnhSanPham($san_pham_id,$link_hinh_anh);
                    }
                }
                
                header("Location: " . BASE_URL_ADMIN . '?act=san-pham');
                exit();

            }else {
                // trả về form và lỗi 
                // đặt chỉ thị xóa session sau khi hiển thị form
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-them-san-pham');
                exit();
            }
        }
    }

      public function formEditSanPham() {
     
    
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        // var_dump($sanPham);die;
        $listAnhSanPham =$this->modelSanPham->getListAnhSanPham($id);
        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
        if($sanPham){
            require_once "./views/sanpham/editSanPham.php";
            deleteSessionError();
        }else{
            header("location:".BASE_URL_ADMIN .'?act=san-pham');
                exit();
        }
       

    }

     public function postEditAddSanPham(){
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
