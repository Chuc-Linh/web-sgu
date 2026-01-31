<?php
header('Content-Type: application/json');
$host = "localhost";
$user = "root";
$pass = "";
$db   = "test";
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    echo json_encode([]);
    exit;
}


$trangthai = $_GET['trangthai'] ?? '';
$order     = $_GET['order'] ?? '';

$sql = "SELECT * FROM hoadon WHERE 1=1";

if ($trangthai !== '') {
    $sql .= " AND trangthai = '" . mysqli_real_escape_string($conn, $trangthai) . "'";
}

if ($phuong !== '') {
    $sql .= " AND phuonghd = '" . mysqli_real_escape_string($conn, $phuong) . "'";
}

if ($order === 'asc') {
    $sql .= " ORDER BY phuonghd ASC";
} elseif ($order === 'desc') {
    $sql .= " ORDER BY phuonghd DESC";
} else {
    $sql .= " ORDER BY ngaydat DESC";
}

$rs = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($rs)) {
    $data[] = $row;
}

echo json_encode($data);
