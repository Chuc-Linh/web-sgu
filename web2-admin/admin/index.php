<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . "/inc/header.php";
?>

<h3 class="mb-4"> Xin chào Admin</h3>



   
<?php require_once __DIR__ . "/inc/footer.php"; ?> 



        