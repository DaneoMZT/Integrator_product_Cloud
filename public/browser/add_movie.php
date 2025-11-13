<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $year = $_POST['year'] ?? 0;
    $image = $_POST['image'] ?? '';
    $director = $_POST['director'] ?? '';

    // Preparar el INSERT incluyendo director
    $stmt = $conn->prepare("INSERT INTO movies (title, description, year, image, director) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $title, $description, $year, $image, $director);
    $stmt->execute();
    $stmt->close();

    // Redirigir de nuevo a movies.php
    header("Location: movies.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Agregar Película</title>
<style>
body { background:#111; color:white; font-family:Arial; text-align:center; }
form { margin:50px auto; background:#222; padding:20px; width:400px; border-radius:8px; }
input, textarea { width:90%; padding:8px; margin:10px; border-radius:5px; border:none; }
button { padding:10px 20px; background:#28a745; color:white; border:none; border-radius:5px; cursor:pointer; }
</style>
</head>
<body>
<h1>➕ Agregar Película</h1>
<form method="POST">
<input type="text" name="title" placeholder="Título" required><br>
<textarea name="description" placeholder="Descripción"></textarea><br>
<input type="number" name="year" placeholder="Año"><br>
<input type="text" name="image" placeholder="URL Imagen"><br>
<input type="text" name="director" placeholder="Director" required><br>
<button type="submit">Agregar</button>
</form>
<a href="movies.php" style="color:#00f;">⬅ Volver al catálogo</a>
</body>
</html>
