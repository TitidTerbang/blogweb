<?php

require_once '../config/db.php';
require_once '../config/jwt.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['email'], $data['password'])) {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':email' => $data['email']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($data['password'], $user['password'])) {
                $jwt = new JwtHandler();
                $token = $jwt->generateToken([
                    'id' => $user['id'],
                    'email' => $user['email']
                ]);

                // Pastikan token tidak ada di blacklist
                if ($jwt->isTokenBlacklisted($token)) {
                    http_response_code(401);
                    echo json_encode(['error' => 'Token tidak valid, silakan coba login kembali']);
                    exit;
                }

                http_response_code(200);
                echo json_encode(['message' => 'Login berhasil', 'token' => $token]);
            } else {
                http_response_code(401);
                echo json_encode(['error' => 'Email atau password salah']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Gagal mengambil data pengguna', 'details' => $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Email dan password harus dimasukkan']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Metode yang diizinkan adalah POST']);
}
?>
