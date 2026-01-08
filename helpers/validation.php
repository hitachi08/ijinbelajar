<?php
function required($value)
{
    return isset($value) && trim($value) !== '';
}

function valid_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function valid_file($file, $allowed, $maxKB)
{
    if ($file['error'] !== 0) return false;
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) return false;
    if ($file['size'] > ($maxKB * 1024)) return false;
    return true;
}
