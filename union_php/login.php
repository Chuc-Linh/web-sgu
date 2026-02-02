<?php
session_start();

if (isset($_POST['login'])) {
    if ($_POST['username'] == 'admin' && $_POST['password'] == '123456') {
        $_SESSION['admin'] = 'admin';
        header("Location: admin.php");
    } else {
        $err = "Sai tài khoản hoặc mật khẩu";
    }
}
?>

<!doctype html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="col-md-4 mx-auto card p-4 shadow">
        <h4 class="text-center mb-3">ADMIN LOGIN</h4>
        <form method="post">
            <input class="form-control mb-2" name="username" placeholder="Username">
            <input class="form-control mb-2" type="password" name="password" placeholder="Password">
            <button class="btn btn-primary w-100" name="login">Đăng nhập</button>
            <p class="text-danger mt-2"><?= $err ?? '' ?></p>
        </form>
    </div>
</div>

</body>
</html>
