<?php
require 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) die("ID no válido");

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $director = $_POST['director'];
    $year = $_POST['year'];
    $description = $_POST['description'];

    // Actualizar solo los campos editables
    $stmt = $conn->prepare("UPDATE movies SET title=?, director=?, year=?, description=? WHERE id=?");
    $stmt->bind_param("ssisi", $title, $director, $year, $description, $id);
    $stmt->execute();

    header("Location: movies.php");
    exit();
}

// Obtener datos de la película
$result = $conn->query("SELECT * FROM movies WHERE id=$id");
$movie = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Película</title>
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

    input, textarea {
        width: 90%;
        padding: 8px;
        margin: 10px 0;
        border-radius: 5px;
        border: none;
    }

    input[readonly] {
        background: #333;
        color: #bbb;
        cursor: not-allowed;
    }

    button {
        padding: 10px 20px;
        background: #ffc107;
        color: #000;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover { background: #e0a800; }

    @media (max-width: 480px) {
        form { width: 90%; padding: 15px; }
        input, textarea, button { width: 100%; }
    }
</style>
</head>
<body>

<h1>✏️ Editar Película</h1>

<form method="POST">
    <input type="text" name="title" value="<?= htmlspecialchars($movie['title']) ?>" placeholder="Título" required><br>
    <input type="text" name="director" value="<?= htmlspecialchars($movie['director']) ?>" placeholder="Director" required><br>
    <input type="number" name="year" value="<?= htmlspecialchars($movie['year']) ?>" placeholder="Año"><br>
    <textarea name="description" placeholder="Descripción"><?= htmlspecialchars($movie['description']) ?></textarea><br>
    
    <!-- Campos bloqueados -->
    <input type="text" value="<?= htmlspecialchars($movie['image']) ?>" readonly placeholder="Imagen"><br>
    <input type="text" value="<?= htmlspecialchars($movie['trailer_url']) ?>" readonly placeholder="URL del tráiler"><br>

    <button type="submit">Actualizar</button>
</form>

<a href="movies.php" class="btn" style="display:inline-block; margin-top:10px; background:#007bff; color:white; text-decoration:none; padding:8px 16px; border-radius:5px;">⬅ Volver</a>

</body>
</html>

<?php
$conn->close();
?>
