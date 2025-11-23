<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $director = $_POST['director'];
    $year = $_POST['year'];
    $description = $_POST['description'];
    $image = $_POST['image']; // nombre del archivo seleccionado en assets/

    $stmt = $conn->prepare("INSERT INTO movies (title, director, year, description, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $title, $director, $year, $description, $image);
    $stmt->execute();

    header("Location: movies.php");
    exit();
}

// Obtener lista de imágenes de la carpeta assets/
$images = [];
$assetDir = __DIR__ . '/assets/';
if (is_dir($assetDir)) {
    $files = scandir($assetDir);
    foreach ($files as $file) {
        if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
            $images[] = $file;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agregar Película</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #111 url('assets/fondo_rick_morty.webp') no-repeat center center fixed;
        background-size: cover;
        color: #fff;
        text-align: center;
        padding: 20px;
        margin: 0;
    }

    h1 { margin-bottom: 20px; text-shadow: 2px 2px 4px #000; }

    form {
        margin: 20px auto;
        background: rgba(0,0,0,0.75);
        padding: 20px;
        width: 400px;
        border-radius: 8px;
    }

    input, textarea, select {
        width: 90%;
        padding: 8px;
        margin: 10px 0;
        border-radius: 5px;
        border: none;
    }

    button {
        padding: 10px 20px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover { background: #0056b3; }

    @media (max-width: 480px) {
        form { width: 90%; padding: 15px; }
        input, textarea, select, button { width: 100%; }
    }
</style>
</head>
<body>

<h1>➕ Agregar Película</h1>

<form method="POST">
    <input type="text" name="title" placeholder="Título" required><br>
    <input type="text" name="director" placeholder="Director" required><br>
    <input type="number" name="year" placeholder="Año"><br>
    <textarea name="description" placeholder="Descripción"></textarea><br>

    <!-- Select para elegir imagen -->
    <select name="image" required>
        <option value="">-- Selecciona una imagen --</option>
        <?php foreach ($images as $img): ?>
            <option value="<?= htmlspecialchars($img) ?>"><?= htmlspecialchars($img) ?></option>
        <?php endforeach; ?>
    </select><br>

    <button type="submit">Agregar</button>
</form>

<a href="movies.php" class="btn" style="display:inline-block; margin-top:10px; background:#ffc107; color:#000; text-decoration:none; padding:8px 16px; border-radius:5px;">⬅ Volver</a>

</body>
</html>
