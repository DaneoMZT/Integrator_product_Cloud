<?php
require 'db.php';

$id = $_GET['id'] ?? null;
$protected_ids = [2, 3, 5, 8, 10];
$correct_password = "abc123";

if (!$id) {
    die("ID no válido");
}

if (in_array($id, $protected_ids)) {
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
                margin: 0;
                padding: 0;
                height: 100vh;
                background: url('/assets/fondo_rick_morty.webp') no-repeat center center fixed;
                background-size: cover;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .overlay {
                background: rgba(0, 0, 0, 0.4);
                backdrop-filter: blur(8px);
                padding: 40px;
                border-radius: 15px;
                text-align: center;
                box-shadow: 0 0 20px rgba(0,0,0,0.6);
            }

            h1 {
                margin-bottom: 20px;
                color: #fff;
                text-shadow: 2px 2px 6px #000;
            }

            input, button {
                padding: 12px;
                margin: 10px 0;
                border-radius: 6px;
                border: none;
                width: 80%;
                font-size: 1em;
            }

            input {
                background: #222;
                color: #fff;
            }

            button {
                background: #dc3545;
                color: #fff;
                cursor: pointer;
                font-weight: bold;
            }

            button:hover {
                background: #a71d2a;
            }

            .error {
                color: #ff5555;
                margin-top: 10px;
            }

            a {
                display: inline-block;
                margin-top: 15px;
                color: #fff;
                text-decoration: none;
                background: #007bff;
                padding: 8px 16px;
                border-radius: 5px;
            }

        </style>
    </head>
    <body>
        <div class="overlay">
            <h1>⚠️ Película Protegida</h1>
            <p>Esta película requiere contraseña para ser eliminada.</p>
            <form method="POST">
                <input type="password" name="password" placeholder="Ingrese la contraseña" required><br>
                <button type="submit">Borrar</button>
                <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
            </form>
            <a href="movies.php">⬅ Volver</a>
        </div>
    </body>
    </html>
    <?php
    exit();
} else {
    $stmt = $conn->prepare("DELETE FROM movies WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: movies.php");
    exit();
}
?>
