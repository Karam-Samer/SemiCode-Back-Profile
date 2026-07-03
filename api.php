<?php

session_start();

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Credentials: true");

echo json_encode([
    'old' => $_SESSION['old'] ?? [],
    'errors' => $_SESSION['errors'] ?? [],
]);

exit;