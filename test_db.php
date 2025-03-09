<?php
$dsn = 'mysql:host=mysql;dbname=prueba_tecnica;charset=utf8mb4';
$username = 'user';
$password = 'password';

try {
    $pdo = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "✅ Conexión a la base de datos exitosa.";
} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage();
}
