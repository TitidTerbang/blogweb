<?php

require_once '../config/jwt.php';
use Firebase\JWT\JWT;

$headers = getallheaders();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($headers['Authorization'])) {

        $authHeader = $headers['Authorization'];
        list(, $token) = explode(' ', $authHeader);

        $jwt = new JwtHandler();
        if ($jwt->isTokenBlacklisted($token)) {
            http_response_code(401);
            echo json_encode(['error' => 'Token sudah tidak valid. Silakan login kembali.']);
            exit;
        }
        // Tambahkan token ke blacklist
        $jwt->blacklistToken($token);

        http_response_code(200);
        echo json_encode(['message' => 'Logout berhasil. Silakan login kembali untuk melanjutkan.']);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Token tidak ditemukan']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Metode yang diizinkan adalah POST']);
}
