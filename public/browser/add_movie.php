<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $director = $_POST['director'];
    $year = $_POST['year'];
    $description = $_POST['description'];
    $image = $_POST['image']; // nombre del archivo seleccionado en assets/
    $trailer_url = $_POST['trailer_url']; // enlace del tráiler

    $stmt = $conn->prepare("INSERT INTO movies (title, director, year, description, image, trailer_url) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", $title, $director, $year, $description, $image, $trailer_url);
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
        margin: 0;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
    }

    h1 {
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px #000;
    }

    form {
        margin: 20px auto;
        background: rgba(0,0,0,0.75);
        padding: 20px;
        width: 100%;
        max-width: 400px;
        border-radius: 8px;
        box-sizing: border-box;
        text-align: left;
    }

    input, textarea, select, button {
        width: 100%;
        box-sizing: border-box;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: none;
    }

    button {
        background: #007bff;
        color: white;
        cursor: pointer;
        transition: background 0.3s;
    }

    button:hover {
        background: #0056b3;
    }

    .info-blanca {
        color: white;
        text-align: center;
        margin-bottom: 10px;
        font-weight: bold;
        text-shadow: 1px 1px 3px #000;
    }

    a.btn {
        display: inline-block;
        margin-top: 10px;
        background: #ffc107;
        color: #000;
        text-decoration: none;
        padding: 8px 16px;
        border-radius: 5px;
        text-align: center;
    }

    @media (max-width: 480px) {
        form { 
            width: 95%; 
            padding: 15px; 
        }
    }
</style>
</head>
<body>

<div>
    <h1>➕ Agregar Película</h1>

    <p class="info-blanca">Esta película requiere contraseña para ser eliminada.</p>

    <form method="POST">
        <input type="text" name="title" placeholder="Título" required>
        <input type="text" name="director" placeholder="Director" required>
        <input type="number" name="year" placeholder="Año">
        <textarea name="description" placeholder="Descripción"></textarea>

        <!-- Select para elegir imagen -->
        <select name="image" required>
            <option value="">-- Selecciona una imagen --</option>
            <?php foreach ($images as $img): ?>
                <option value="<?= htmlspecialchars($img) ?>"><?= htmlspecialchars($img) ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Campo para trailer_url -->
        <input type="url" name="trailer_url" placeholder="URL del tráiler (YouTube)">

        <button type="submit">Agregar</button>
    </form>

    <a href="movies.php" class="btn">⬅ Volver</a>
</div>

</body>
</html>
