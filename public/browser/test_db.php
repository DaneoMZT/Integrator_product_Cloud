<?php
$host = getenv('MYSQLHOST') ?: 'switchyard.proxy.rlwy.net';
$port = getenv('MYSQLPORT') ?: 12014;
$user = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: 'TaqXGlSrbEExYMYKCrhcvSxSIrMuMbFT';
$database = getenv('MYSQLDATABASE') ?: 'railway';

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
} else {
    echo "✅ Conexión exitosa a MySQL";
}
?>