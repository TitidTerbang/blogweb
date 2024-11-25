<?php

require_once '../api/config/db.php';

// Memeriksa apakah data telah dikirim melalui PUT
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id'], $data['title'], $data['content'])) {
        $sql = "UPDATE articles SET title = :title, content = :content WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id' => $data['id'],
            ':title' => $data['title'],
            ':content' => $data['content']
        ]);

        if ($stmt->rowCount() > 0) {
            http_response_code(200);
            echo json_encode(['message' => 'Artikel berhasil diperbarui']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Artikel tidak ditemukan']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Data tidak lengkap']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Metode yang diizinkan adalah PUT']);
}
?>
