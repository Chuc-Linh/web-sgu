<?php
$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "test",
);

mysqli_set_charset($conn, "utf8mb4");

if (!$conn) {
    die("Lỗi kết nối DB: " . mysqli_connect_error());
}

