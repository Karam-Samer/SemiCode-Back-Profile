<?php

session_start();

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Method is not allowed');
}

require_once 'variable.php';
require_once 'function.php';



// Get
$id = $_GET['id'] ?? null;
$old['id'] = $id;
if(empty($id)) {
    $errors['id'] = '* ID is required';
    
}

// Post

foreach($values as $value) {

    $old[$value] = $_POST[$value] ?? null;

    if(isInputEmpty($old[$value])) {
        $errors[$value] = "* $value is required";
    }else {
        $result = isValidInputs([$value => $old[$value]], $regex, $regexError);
        if($result !== true) {
            $errors[$value] = $result;
        }

    }
}


if(!empty($old['Password']) && !empty($old['CPassword']) && $old['Password'] !== $old['CPassword']) {
    $errors['CPassword'] = '* Passwords do not match';
}

$img=uploadImg($_FILES['Image'], $allowedExtensions);
if(str_starts_with($img, '*')) {
    $errors['Image'] = $img;
}else {
    $old['Image'] = $img;
}

$_SESSION['old'] = $old;
if(!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: http://localhost:4200/");
    exit;
}else {
    $old['Password'] = passwordEncrypt($old['Password']);
    header("Location: http://localhost:4200/profile");
    exit;
}