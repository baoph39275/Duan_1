<?php

class HomeController
{
    public $modelSanPham;

    public function __construct()
    {
        $this->modelSanPham = new SanPham();
    }
    function home()
    {
        echo "Welcome to the Home Page!";
    }
    function trangchu()
    {
        echo "This is the Trang Chu Page!";
    }
    public function danhSachSanPham()
    {
        // echo "This is the Product List Page!";
        $listProducts = $this->modelSanPham->getAllProducts();
        // var_dump($listProducts);die();
        require_once './views/listProduct.php';
    }
}
