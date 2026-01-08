<?php
session_start();
require '../config/db.php';

header('Content-Type: application/json');

$id = $_SESSION['user_id'];

if (!isset($_FILES['photo'])) {
    echo json_encode(['status' => 'error', 'message' => 'Foto tidak ditemukan']);
    exit;
}

$ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
$filename = uniqid() . '_' . $id . '.' . $ext;

move_uploaded_file(
    $_FILES['photo']['tmp_name'],
    "../uploads/profile/" . $filename
);

$conn->prepare("UPDATE users SET profile_photo=? WHERE id_user=?")
    ->execute([$filename, $id]);

echo json_encode(['status' => 'success']);
