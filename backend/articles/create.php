<?php

require_once '../api/config/db.php';

// Memeriksa apakah data telah dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['user_id'], $data['title'], $data['content'])) {
        $slug = strtolower(str_replace(' ', '-', $data['title']));
        $sql = "INSERT INTO articles (user_id, title, slug, content) VALUES (:user_id, :title, :slug, :content)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':title' => $data['title'],
            ':slug' => $slug,
            ':content' => $data['content']
        ]);

        if ($stmt->rowCount() > 0) {
            http_response_code(201);
            echo json_encode(['message' => 'Artikel berhasil ditambahkan']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Gagal menambahkan artikel']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Data tidak lengkap']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Metode yang diizinkan adalah POST']);
}
?>
