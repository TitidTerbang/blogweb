<?php

require_once '../api/config/db.php';

// Memeriksa apakah ID telah dikirim melalui DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents('php://input'), $params);

    if (isset($params['id'])) {
        $sql = "DELETE FROM articles WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $params['id']]);

        if ($stmt->rowCount() > 0) {
            http_response_code(200);
            echo json_encode(['message' => 'Artikel berhasil dihapus']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Artikel tidak ditemukan']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'ID artikel tidak dimasukkan']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Metode yang diizinkan adalah DELETE']);
}
?>
