
<?php
class AdminSanPhamController
{

    public $modelSanPham;
    public $modelDanhMuc;
    public function __construct()
    {
        $this->modelSanPham = new AdminSanPham();
        $this->modelDanhMuc = new AdminDanhMuc();
    }

    public function danhSachSanPham()
    {

        $listSanPham = $this->modelSanPham->getAllSanPham();

        require_once './views/sanpham/listSanPham.php';
    }

    public function formAddSanPham()
    {
        // ham nay dung de hien thi form nhap
        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();

        require_once './views/sanpham/addSanPham.php';
        deleteSessionError();
    }

    public function postAddSanPham()
    {
        // ham nay dung de xu li them du lieu 

        // KIEM TRA XEM DU LIEU CO PHAI DUOC SUBMIT LEN KO 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // lay ra du lieu 
            $ten_san_pham = $_POST['ten_san_pham'] ?? '';
            $gia_san_pham = $_POST['gia_san_pham'] ?? '';
            $gia_khuyen_mai = $_POST['gia_khuyen_mai'] ?? '';
            $so_luong = $_POST['so_luong'] ?? '';
            $ngay_nhap = $_POST['ngay_nhap'] ?? '';
            $danh_muc_id = $_POST['danh_muc_id'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? '';
            $mo_ta = $_POST['mo_ta'] ?? '';

            $hinh_anh = $_FILES['hinh_anh'] ?? null;

            // luu hinh anh vao 
            $file_thumb = uploadFile($hinh_anh, './uploads/');

            // mang hinh anh
            $img_array = $_FILES['img_array'];


            //tao 1 mang trong de chua du lieu 
            $errors = [];
            if (empty($ten_san_pham)) {
                $errors['ten_san_pham'] = 'tên sản phẩm không được để trống';
            }

            if (empty($gia_san_pham)) {
                $errors['gia_san_pham'] = 'giá sản phẩm không được để trống';
            }

            if (empty($gia_khuyen_mai)) {
                $errors['ten_san_pham'] = 'giá khuyến mãi sản phẩm không được để trống';
            }

            if (empty($so_luong)) {
                $errors['so_luong'] = 'số lượng sản phẩm không được để trống';
            }

            if (empty($ngay_nhap)) {
                $errors['ngay_nhap'] = 'ngày nhập sản phẩm không được để trống';
            }

            if (empty($danh_muc_id)) {
                $errors['danh_muc_id'] = 'danh mục sản phẩm phải chọn';
            }

            if (empty($trang_thai)) {
                $errors['trang_thai'] = 'trạng thái sản phẩm phải chọn';
            }

            if ($hinh_anh['error'] !== 0) {
                $errors['hinh_anh'] = 'phải chọn ảnh sản phẩm';
            }

            $_SESSION['error'] = $errors;

            // nếu ko có lỗi thì tiến hành thêm sản phẩm
            if (empty($errors)) {
                // nếu ko có lỗi thì tiến hành thêm sản phẩm

                $san_pham_id = $this->modelSanPham->insertSanPham(
                    $ten_san_pham,
                    $gia_san_pham,
                    $gia_khuyen_mai,
                    $so_luong,
                    $ngay_nhap,
                    $danh_muc_id,
                    $trang_thai,
                    $mo_ta,
                    $file_thumb
                );
                if (!empty($img_array['name'])) {
                    foreach ($img_array['name'] as $key => $value) {
                        $file = [
                            'name' => $img_array['name'][$key],
                            'type' => $img_array['type'][$key],
                            'tmp_name' => $img_array['tmp_name'][$key],
                            'error' => $img_array['error'][$key],
                            'size' => $img_array['size'][$key],
                        ];
                        $link_hinh_anh = uploadFile($file, './uploads/');
                        $this->modelSanPham->insertAlbumAnhSanPham($san_pham_id, $link_hinh_anh);
                    }
                }
                header("Location: " . BASE_URL_ADMIN . '?act=san-pham');
                exit();
            } else {
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-them-san-pham');
                exit();
            }
        }
    }

    public function formEditSanPham()
    {
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);

        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);

        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();

        if ($sanPham) {
            require_once './views/sanpham/editSanPham.php';
            deleteSessionError();
        } else {
            header("Location: " . BASE_URL_ADMIN . '?act=san-pham');
            exit();
        }
    }

        public function detailSanPham() 
        {  
            $id = $_GET['id_san_pham'];
            $sanPham = $this->modelSanPham->getDetailSanPham($id);
            // var_dump($sanPham);die;
            $listAnhSanPham =$this->modelSanPham->getListAnhSanPham($id);
            $listBinhLuan = $this->modelSanPham->getBinhLuanFromSanPham($id);
            // var_dump($listAnhSanPham);die;
            if($sanPham){
                require_once "./views/sanpham/detailSanPham.php";
                
            }else{
                header("location:".BASE_URL_ADMIN .'?act=san-pham');
                    exit();
            }
        
        }

    public function postEditSanPham()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $san_pham_id = $_POST['san_pham_id'] ?? '';

            $sanPhamOld = $this->modelSanPham->getDetailSanPham($san_pham_id);
            $old_file = $sanPhamOld['hinh_anh'];

            $ten_san_pham = $_POST['ten_san_pham'] ?? '';
            $gia_san_pham = $_POST['gia_san_pham'] ?? '';
            $gia_khuyen_mai = $_POST['gia_khuyen_mai'] ?? '';
            $so_luong = $_POST['so_luong'] ?? '';
            $ngay_nhap = $_POST['ngay_nhap'] ?? '';
            $danh_muc_id = $_POST['danh_muc_id'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? '';
            $mo_ta = $_POST['mo_ta'] ?? '';

            $hinh_anh = $_FILES['hinh_anh'] ?? null;

            $errors = [];
            if (isset($hinh_anh) && $hinh_anh['error'] == UPLOAD_ERR_OK) {
                $new_file = uploadFile($hinh_anh, './uploads/');
                if (!empty($old_file)) {
                    deleteFile($old_file);
                }
            } else {
                $new_file = $old_file;
            }

            if (empty($ten_san_pham)) {
                $errors['ten_san_pham'] = 'Tên sản phẩm không được để trống';
            }
            if (empty($gia_san_pham)) {
                $errors['gia_san_pham'] = 'Giá sản phẩm không được để trống';
            }
            if (empty($gia_khuyen_mai)) {
                $errors['gia_khuyen_mai'] = 'Giá khuyến mãi không được để trống';
            }
            if (empty($so_luong)) {
                $errors['so_luong'] = 'Số lượng sản phẩm không được để trống';
            }
            if (empty($ngay_nhap)) {
                $errors['ngay_nhap'] = 'Ngày nhập sản phẩm không được để trống';
            }
            if (empty($danh_muc_id)) {
                $errors['danh_muc_id'] = 'Danh mục sản phẩm phải được chọn';
            }
            if (empty($trang_thai)) {
                $errors['trang_thai'] = 'Trạng thái sản phẩm không được để trống';
            }

            $_SESSION['error'] = $errors;

            if (empty($errors)) {
                // Gọi hàm update sản phẩm và chuyển hướng về trang "san-pham"
                $this->modelSanPham->updateSanPham($san_pham_id, $ten_san_pham, $gia_san_pham, $gia_khuyen_mai, $so_luong, $ngay_nhap, $danh_muc_id, $trang_thai, $mo_ta, $new_file);

                // Chuyển hướng về trang san-pham sau khi cập nhật thành công
                header("Location: " . BASE_URL_ADMIN . "?act=san-pham");
                exit();
            } else {
                // Nếu có lỗi, chuyển về form sửa sản phẩm với ID của sản phẩm
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . "?act=from-sua-san-pham&id_san_pham=" . $san_pham_id);
                exit();
            }
        }
    }

        public function postEditAnhSanPham(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $san_pham_id= $_POST['san_pham_id'] ?? '';
            $listAnhSanPhamCurent = $this->modelSanPham->getListAnhSanPham($san_pham_id);
            $img_array = $_FILES['img_array'];
            $img_delete = isset($_POST['img_delete']) ? explode(',',$_POST['img_delete']) : [];
            $current_img_ids = $_POST['current_img_ids'] ?? [];


            $upload_file = [];

            foreach($img_array['name'] as $key=>$value){
                if($img_array['error'][$key] == UPLOAD_ERR_OK){
                    $new_file = uploadFileAlbum($img_array, './uploads',$key);
                    if($new_file){
                        $upload_file[] = [
                            'id' => $current_img_ids[$key] ?? null,
                            'file'=> $new_file
                        ];
                    }
                }
            }
            foreach($upload_file as $file_info){
                if($file_info['id']){
                    $old_file = $this->modelSanPham->getDetailAnhSanPham($file_info['id'])['link_hinh_anh'];
                    $this->modelSanPham->updateAnhSanPham($file_info['id'],$file_info['file']);
                    deleteFile($old_file);
                }else{
                    $this->modelSanPham->insertAlbumAnhSanPham($san_pham_id,$file_info['file']);
                }
            }
            foreach($listAnhSanPhamCurent as $anhSP) {
                $anh_id = $anhSP['id'];
                if(in_array($anh_id,$img_delete)){
                    $this->modelSanPham->destroyAnhSanPham($anh_id);
                    deleteFile($anhSP['link_hinh_anh']);
                }
            }
            header("Location: ".BASE_URL_ADMIN."?act=form-sua-san-pham&id_san_pham=".$san_pham_id);
                exit();
        }
    }
    public function deleteSanPham (){
        $id = $_GET['id_san_pham'];
        $sanPham =  $this->modelSanPham->getDetailSanPham($id);
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);

        if ($sanPham) {
            deleteFile($sanPham['hinh_anh']);
            $this->modelSanPham->destroySanPham($id);
        }
        if($listAnhSanPham) {
            foreach($listAnhSanPham as $anhSP){
                deleteFile($anhSP['link_hinh_anh']);
                $this->modelSanPham->destroyAnhSanPham($anhSP['id']);
            }
        }

        header("Location: " . BASE_URL_ADMIN . '?act=san-pham');
         exit();
    }

    public function updateTrangThaiBinhLuan(){
        $id_binh_luan = $_POST['id_binh_luan'];
        $name_view = $_POST['name_view'];
        $binhLuan = $this->modelSanPham->getDetailBinhLuan($id_binh_luan);
        if($binhLuan){
            $trang_thai_update = '';
            if ($binhLuan['trang_thai'] == 1){
                $trang_thai_update = 2;
            } else{
                $trang_thai_update = 1;
            }
            $status = $this->modelSanPham->updateTrangThaiBinhLuan($id_binh_luan, $trang_thai_update);
            if($status){
                if ($name_view == 'detail_khach') {
                    header("location:" . BASE_URL_ADMIN . '?act=chi-tiet-khach-hang&id_khach_hang=' . $binhLuan['tai_khoan_id'] );
                } else {
                    header("location:" . BASE_URL_ADMIN . '?act=chi-tiet-san-pham&id_san_pham=' . $binhLuan['san_pham_id'] );
                }
            }
        }
    }
}
