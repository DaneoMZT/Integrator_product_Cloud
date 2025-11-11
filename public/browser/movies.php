<?php
require 'db.php';

// 🔹 Configurar cabecera para JSON
header('Content-Type: application/json; charset=utf-8');

// 🔹 Consultar las películas
$sql = "SELECT id, title, description, year FROM movies";
$result = $conn->query($sql);

$movies = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }
}

// 🔹 Devolver JSON
echo json_encode($movies, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

$conn->close();
?>
