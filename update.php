<?php

session_start();

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Method is not allowed');
}

require_once 'variable.php';
require_once 'function.php';

$data = json_decode(file_get_contents('php://input'), true);

$field = $data['field'] ?? null;
$value = $data['value'] ?? null;

$result = updateUserInfo($field, $value, $regex, $regexError);
if ($result !== true) {
    echo json_encode(['message' => $result]);
    exit;
}

echo json_encode(['success' => 'User information updated successfully']);
