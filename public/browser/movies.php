<?php
// 🔹 Conexión a la base de datos (Railway)
require 'db.php';

// ---------------------------------------------
// 🔹 CONSULTAR TODAS LAS COLUMNAS DE LA TABLA movies
// ---------------------------------------------
$sql = "SELECT * FROM movies";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Catálogo de Películas 🎬</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #111 url('assets/fondo_rick_morty.webp') no-repeat center center fixed;
        background-size: cover;
        color: #fff;
        text-align: center;
        padding: 20px;
    }

    h1 {
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px #000;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        margin: 10px;
        transition: background 0.3s;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    table {
        width: 90%;
        margin: 20px auto;
        border-collapse: collapse;
        background: rgba(0, 0, 0, 0.75);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.5);
    }

    th, td {
        padding: 12px;
        border-bottom: 1px solid #444;
    }

    th {
        background-color: #222;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    tr:nth-child(even) {
        background-color: #1a1a1a;
    }

    tr:hover {
        background-color: #333;
        transition: 0.3s;
    }

    img {
        border-radius: 6px;
        max-width: 100px;
        height: auto;
    }
</style>
</head>
<body>

<h1>🎥 Catálogo de Películas</h1>
<a href="add_movie.php" class="btn">➕ Agregar Película</a>

<?php if ($result && $result->num_rows > 0): ?>
<table>
    <thead>
        <tr>
            <?php
            // 🔹 Generar dinámicamente los encabezados según las columnas
            $fields = $result->fetch_fields();
            foreach ($fields as $field) {
                echo "<th>" . htmlspecialchars($field->name) . "</th>";
            }
            ?>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <?php foreach ($row as $key => $value): ?>
            <td>
                <?php if ($key === 'image' && !empty($value)): ?>
                    <img src="assets/<?= htmlspecialchars($value) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                <?php else: ?>
                    <?= htmlspecialchars($value) ?>
                <?php endif; ?>
            </td>
            <?php endforeach; ?>
            <td>
                <a href="edit_movie.php?id=<?= $row['id'] ?>" class="btn" style="background:#ffc107; color:#000;">✏️ Editar</a>
                <a href="delete_movie.php?id=<?= $row['id'] ?>" class="btn" style="background:#dc3545;" onclick="return confirm('¿Seguro que quieres eliminar esta película?');">🗑️ Borrar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
<p>No hay películas registradas.</p>
<?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
