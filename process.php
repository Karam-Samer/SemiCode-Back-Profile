<?php

session_start();

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Post method required');
}

$errors = [];
$old = [];
$values = ['Name', 'Email', 'Language', 'Password', 'CPassword'];

// Get
$id = $_GET['id'] ?? null;
$old['id'] = $id;
if(empty($id)) {
    $errors['id'] = '* ID is required';
}

// Post

foreach($values as $value) {
    $old[$value] = $_POST[$value] ?? null;
    if(empty($old[$value])) {
        $errors[$value] = "* $value is required";
    }
}

if(!empty($old['Password']) && !empty($old['CPassword']) && $old['Password'] !== $old['CPassword']) {
    $errors['CPassword'] = '* Passwords do not match';
    $old['CPassword'] = '';
}

if (isset($_FILES['Image']) && $_FILES['Image']['error'] !== UPLOAD_ERR_NO_FILE) {
    $file = $_FILES['Image'];
    $fileName = $file['name'];
    $originalName = pathinfo($fileName, PATHINFO_FILENAME);
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    $tmpPath = $file['tmp_name'];

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($extension, $allowedExtensions)) {
        $errors['Image'] = "* Invalid file type. ";
    } else {
        $time = time();
        $newFileName = "{$originalName}-{$time}.{$extension}";
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir);
        }
        $uploadPath = $uploadDir . "{$newFileName}";
        if (move_uploaded_file($tmpPath, $uploadPath)) {
            $old['Image'] = "http://localhost/EX2/backend/uploads/{$newFileName}";
        } else {
            $errors['Image'] = '* Failed to upload image';
        }
    }
} else {
    $errors['Image'] = '* Image is required';
}


$_SESSION['old'] = $old;
if(!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: http://localhost:4200/");
    exit;
}else {
    header("Location: http://localhost:4200/profile");
    exit;
}