<?php
require 'db.php';

// Directorio donde se guardarán las imágenes
$uploadDir = 'assets/';

// Procesar formulario al enviar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $director = $_POST['director'] ?? '';
    $year = $_POST['year'] ?? 0;
    $description = $_POST['description'] ?? '';
    $imageName = '';

    // Subir imagen si se selecciona
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['image']['tmp_name'];
        $originalName = basename($_FILES['image']['name']);
        $imageName = time() . '_' . $originalName; // Evitar nombres duplicados
        move_uploaded_file($tmpName, $uploadDir . $imageName);
    }

    // Insertar en la base de datos
    $stmt = $conn->prepare("INSERT INTO movies (title, director, year, description, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $title, $director, $year, $description, $imageName);
    $stmt->execute();
    $stmt->close();

    // Redirigir a movies.php
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
        button { padding:10px 20px; background:#28a745; color:white; border:none; border-radius:5px; }
        button:hover { background:#218838; }
    </style>
</head>
<body>
    <h1>➕ Agregar Película</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Título" required><br>
        <input type="text" name="director" placeholder="Director" required><br>
        <input type="number" name="year" placeholder="Año"><br>
        <textarea name="description" placeholder="Descripción"></textarea><br>
        <input type="file" name="image" accept="image/*"><br>
        <button type="submit">Agregar Película</button>
    </form>
    <a href="movies.php" class="btn" style="color:#fff; text-decoration:none; display:inline-block; margin-top:10px;">⬅ Volver al catálogo</a>
</body>
</html>
