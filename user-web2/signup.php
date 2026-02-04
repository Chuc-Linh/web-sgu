<?php
if (isset($_POST['btnRegister'])) {
    // 1. Lấy dữ liệu từ form
    $username = $_POST['username'];
    $phone    = $_POST['phone'];
    $address  = $_POST['address'];
    $city     = $_POST['city'];
    $district = $_POST['district'];
    $pass     = $_POST['password'];
    $repass   = $_POST['re-password'];

    // Tạo một mảng chứa lỗi
    $errors = [];

    // 2. Kiểm tra các điều kiện
    
    // Kiểm tra trống
    if (empty($username) || empty($phone) || empty($address) || empty($city) || empty($district) || empty($pass) || empty($repass)) {
         $_SESSION['error'] = "❌ Vui lòng nhập đầy đủ thông tin.";
        header("Location: signup.php");
        exit();
    }

    // Kiểm tra định dạng số điện thoại (Ví dụ: phải là số và có 10 chữ số)
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
       $_SESSION['error'] = "❌ Số điện thoại phải có 10 chữ số.";
        header("Location: signup.php");
        exit();
    }

    // Kiểm tra mật khẩu khớp nhau
    if ($pass !== $repass) {
        $_SESSION['error'] = "❌ Mật khẩu nhập lại không khớp.";
        header("Location: signup.php");
        exit();
    }

     
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }

    if (isset($_SESSION['success'])) {
        echo '<p style="color:green">' . $_SESSION['success'] . '</p>';
        unset($_SESSION['success']);
    }
    

    $_SESSION['success'] = "🎉 Đăng ký thành công! Đang chuyển sang trang đăng nhập...";

    header("Refresh:2; url=login.html");
    exit();
}
?>