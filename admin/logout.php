<?php
session_start();

// Hapus semua session admin
$_SESSION = [];
session_unset();
session_destroy();

// Redirect ke halaman login admin
header("Location: login.php");
exit;
?>