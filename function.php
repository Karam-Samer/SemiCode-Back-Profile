<?php
function isInputEmpty($input) {
    return empty($input);
}
function isValidInputs($fields, $regex, $regexError) {
    foreach ($fields as $field => $value) {
        if (!preg_match($regex[$field], $value)) {
            return $regexError[$field];
        }
    }
    return true;
}

function uploadImg($file, $allowedExtensions) {
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return '* Image is required';
    }

    $fileName = $file['name'];
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);

    if (!in_array($extension, $allowedExtensions)) {
        return '* Invalid file type.';
    }

    $originalName = pathinfo($fileName, PATHINFO_FILENAME);
    $time = time();
    $newFileName = "{$originalName}-{$time}.{$extension}";
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir);
    }
    $uploadPath = $uploadDir . "{$newFileName}";
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        return "uploads/{$newFileName}";
    } else {
        return '* Failed to upload image.';
    }
}


function passwordEncrypt($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function updateUserInfo($field, $value, $regex, $regexError) {
    if (!isset($_SESSION['old'])) {
        return '* data not found';
    }
    if(isInputEmpty($value)) {
        return '* Field is required';
    }
    $result = isValidInputs([$field => $value], $regex, $regexError);
    if($result !== true) {
        return $result;
    }
    $_SESSION['old'][$field] = $value;
    return true;
}