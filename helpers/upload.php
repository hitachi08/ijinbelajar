<?php
function uploadFile($file, $folder)
{
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $name = uniqid() . '.' . $ext;
    $path = "../uploads/$folder/$name";

    if (!is_dir("../uploads/$folder")) {
        mkdir("../uploads/$folder", 0777, true);
    }

    move_uploaded_file($file['tmp_name'], $path);
    return "uploads/$folder/$name";
}
