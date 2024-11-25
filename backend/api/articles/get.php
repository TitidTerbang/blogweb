<?php

require_once '../config/db.php';

// Ambil daftar artikel
try {
    $sql = "SELECT * FROM articles";
    $stmt = $pdo->query($sql);
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    http_response_code(200);
    echo json_encode(['data' => $articles]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal mengambil data artikel']);
}
?>
