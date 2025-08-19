
<?php 

// Biến môi trường, dùng chung toàn hệ thống
// Khai báo dưới dạng HẰNG SỐ để không phải dùng $GLOBALS

// đường dẫn vào phần client
define('BASE_URL'       , 'http://localhost/DuAnnn1/Duan_1/');
// đường dẫn vào phần admin
define('BASE_URL_ADMIN'       , 'http://localhost/DuAnnn1/Duan_1/admin/');

define('DB_HOST'    , 'localhost');
define('DB_PORT'    , 3306);
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME'    , 'du-an1');  // Tên database

define('PATH_ROOT'    , __DIR__ . '/../');