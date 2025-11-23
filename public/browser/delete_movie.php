<?php
require 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: movies.php");
    exit();
}

// IDs protegidos
$protected_ids = [2, 3, 5, 8, 10];

if (in_array($id, $protected_ids)) {
    // Obtener información de la película
    $stmt = $conn->prepare("SELECT title, image FROM movies WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $movie = $result->fetch_assoc();

    // Verificar contraseña
    $password = $_POST['password'] ?? null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($password === 'abc123') {
            $stmt = $conn->prepare("DELETE FROM movies WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            header("Location: movies.php");
            exit();
        } else {
            $error = "Contraseña incorrecta. No se puede borrar esta película.";
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Eliminar Película Protegida</title>
        <style>
            body { font-family: Arial, sans-serif; background:#111; color:#fff; text-align:center; padding:20px; }
            form { background: rgba(0,0,0,0.75); padding:20px; width:300px; margin:20px auto; border-radius:8px; }
            input { width:90%; padding:8px; margin:10px 0; border-radius:5px; border:none; }
            button { padding:10px 20px; background:#dc3545; color:white; border:none; border-radius:5px; cursor:pointer; }
            button:hover { background:#b52b2b; }
            .error { color:#ff4d4d; margin-bottom:10px; }
            .movie-image { max-width:200px; border-radius:10px; margin-bottom:15px; }
        </style>
    </head>
    <body>
        <h1>⚠️ Película Protegida</h1>
        <?php if(!empty($error)) echo "<div class='error'>{$error}</div>"; ?>
        <p>Ingresa la contraseña para borrar la película:</p>

        <?php if (!empty($movie['image'])): ?>
            <img src="/browser/assets/<?= htmlspecialchars($movie['image']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>" class="movie-image">
        <?php endif; ?>

        <form method="POST">
            <input type="password" name="password" placeholder="Contraseña" required><br>
            <button type="submit">Borrar</button>
        </form>

        <a href="movies.php" style="color:#007bff;">⬅ Volver al catálogo</a>
    </body>
    </html>
    <?php
} else {
    // Para IDs no protegidos, borrar directamente
    $stmt = $conn->prepare("DELETE FROM movies WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: movies.php");
    exit();
}

$conn->close();
?>
