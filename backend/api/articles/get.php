<?php

header("Access-Control-Allow-Origin: *"); // Izinkan semua domain untuk mengakses
header("Content-Type: application/json; charset=UTF-8"); // Format respons JSON
header("Access-Control-Allow-Methods: GET"); // Izinkan metode GET
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

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
