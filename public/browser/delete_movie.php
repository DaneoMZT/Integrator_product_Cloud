<?php
require 'db.php';

$id = $_GET['id'] ?? null;
$protected_ids = [2, 3, 5, 8, 10];
$correct_password = "abc123";

// Validar que exista un ID
if (!$id) {
    die("ID no válido");
}

// Si la película es protegida
if (in_array($id, $protected_ids)) {
    // Si se envió el formulario con contraseña
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = $_POST['password'] ?? '';
        if ($password === $correct_password) {
            $stmt = $conn->prepare("DELETE FROM movies WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            header("Location: movies.php");
            exit();
        } else {
            $error = "Contraseña incorrecta";
        }
    }

    // Mostrar formulario de contraseña
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Eliminar Película Protegida</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #111 url('/browser/assets/fondo_rick_morty.webp') no-repeat center center fixed;
                background-size: cover;
                color: #fff;
                text-align: center;
                padding: 20px;
            }
            form {
                background: rgba(0,0,0,0.75);
                display: inline-block;
                padding: 20px;
                border-radius: 8px;
                margin-top: 20px;
            }
            input, button {
                padding: 10px;
                margin: 10px 0;
                border-radius: 5px;
                border: none;
                width: 80%;
            }
            button {
                background: #dc3545;
                color: #fff;
                cursor: pointer;
            }
            button:hover {
                background: #a71d2a;
            }
            img {
                max-width: 150px;
                margin-bottom: 15px;
                border-radius: 8px;
            }
            .error { color: #ff5555; margin-top: 10px; }
        </style>
    </head>
    <body>
        <h1>⚠️ Película Protegida</h1>
        <p>Esta película requiere contraseña para ser eliminada.</p>
        <img src="/assets/fondo_rick_morty.webp" alt="Rick y Morty">
        <form method="POST">
            <input type="password" name="password" placeholder="Ingrese la contraseña" required><br>
            <button type="submit">Borrar</button>
            <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
        </form>
        <a href="movies.php" style="display:inline-block; margin-top:15px; color:#fff; text-decoration:none; background:#007bff; padding:8px 16px; border-radius:5px;">⬅ Volver</a>
    </body>
    </html>
    <?php
    exit();
} else {
    // Películas no protegidas se borran directamente
    $stmt = $conn->prepare("DELETE FROM movies WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: movies.php");
    exit();
}
?>
