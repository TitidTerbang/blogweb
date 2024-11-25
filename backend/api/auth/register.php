<?php

require_once '../config/db.php';

// Memeriksa apakah data telah dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['email'], $data['password'], $data['name'])) {
        // Cek apakah email sudah ada dalam database
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':email' => $data['email']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                http_response_code(409);
                echo json_encode(['error' => 'Email sudah terdaftar']);
            } else {
                // Enkripsi password
                $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

                // Simpan data pengguna ke database
                $sql = "INSERT INTO users (email, password, name) VALUES (:email, :password, :name)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':email' => $data['email'],
                    ':password' => $passwordHash,
                    ':name' => $data['name']
                ]);

                if ($stmt->rowCount() > 0) {
                    http_response_code(201);
                    echo json_encode(['message' => 'Pengguna berhasil terdaftar']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'Gagal mendaftarkan pengguna']);
                }
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Gagal mengambil data pengguna']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Email, password, dan nama harus dimasukkan']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Metode yang diizinkan adalah POST']);
}
?>
