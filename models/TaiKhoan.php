<?php

class TaiKhoan
{
     public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }
           public function checkLogin($email, $password)
    {
        try {
            $sql = "SELECT * FROM tai_khoans WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();
            
            // Kiểm tra tài khoản có tồn tại không
            if($user['mat_khau'] !== $password && $user['email'] == $email){
                return "Thông tin mật khẩu bị sai";
            }
            if ($user['mat_khau'] == $password && $user['email'] == $email) {
                if ($user['chuc_vu_id'] == 2) {
                    if ($user['trang_thai'] == 1) {
                        return $user['email'];
                    } else {
                        return "Tài khoản đã bị cấm";
                    }
                } else {
                    return "Tài khoản không có quyền đăng nhập";
                }
            }
        } catch (\Exception $e) {
            echo "Lỗi" . $e->getMessage();
            return false;
        }
    }
     public function getTaiKhoanFromEmail($email)
    {
        try {
            $sql = 'SELECT * FROM tai_khoans WHERE email = :email';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':email' => $email
            ]);

            return $stmt->fetch();
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }
}    