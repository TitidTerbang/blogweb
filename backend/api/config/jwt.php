<?php

require_once '../../../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

#[AllowDynamicProperties] class JwtHandler {
    private $secretKey;
    private $algorithm;

    public function __construct() {
        $this->secretKey = 'cemas';
        $this->algorithm = 'HS256';

        // Hubungkan ke database
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=blog_database', 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // Generate JWT token
    public function generateToken($data) {
        $issuedAt = time();
        $expiration = $issuedAt + 3600; // Token berlaku selama 1 jam

        $payload = [
            'iss' => 'http://example.com',
            'aud' => 'http://example.com',
            'iat' => $issuedAt,
            'exp' => $expiration,
            'data' => $data
        ];

        return JWT::encode($payload, $this->secretKey, $this->algorithm);
    }

    // Decode JWT token
    public function decodeToken($token) {
        try {
            return JWT::decode($token, new Key($this->secretKey, $this->algorithm));
        } catch (\Exception $e) {
            return null;
        }
    }

    // Tambahkan token ke blacklist
    public function blacklistToken($token) {
        $sql = "INSERT INTO jwt_blacklist (token) VALUES (:token)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':token' => $token]);
    }

    // Periksa apakah token ada di blacklist
    public function isTokenBlacklisted($token) {
        $sql = "SELECT id FROM jwt_blacklist WHERE token = :token";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':token' => $token]);
        return $stmt->fetch() ? true : false;
    }
}
