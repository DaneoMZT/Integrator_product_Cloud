<?php
require 'db.php';

// Consultar todas las columnas de la tabla movies
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
        margin: 0;
    }

    h1 {
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px #000;
    }

    .btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #007bff;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        margin: 5px;
        transition: background 0.3s;
        font-size: 0.9em;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    table {
        width: 100%;
        max-width: 100%;
        margin: 20px auto;
        border-collapse: collapse;
        background: rgba(0, 0, 0, 0.75);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.5);
    }

    th, td {
        padding: 8px;
        border-bottom: 1px solid #444;
        font-size: 0.9em;
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
        max-width: 80px;
        height: auto;
    }

    /* Modal estilo Netflix */
    #trailerModal {
        display: none;
        position: fixed;
        z-index: 9999;
        padding-top: 60px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background: rgba(0,0,0,0.85);
    }

    #trailerContent {
        margin: auto;
        background: #000;
        width: 90%;
        max-width: 800px;
        padding: 10px;
        border-radius: 10px;
        position: relative;
    }

    #closeTrailer {
        position: absolute;
        top: -25px;
        right: -25px;
        background: red;
        color: #fff;
        padding: 10px 15px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 20px;
    }

    iframe {
        width: 100%;
        height: 450px;
        border-radius: 10px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        iframe {
            height: 250px;
        }
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
            <td data-label="<?= htmlspecialchars($key) ?>">

                <?php if ($key === 'image' && !empty($value)): ?>
                    <img src="assets/<?= htmlspecialchars($value) ?>" alt="<?= htmlspecialchars($row['title']) ?>">

                <?php elseif ($key === 'trailer_url'): ?>
                    <?php if (!empty($value)): ?>
                        <a class="btn" href="#" onclick="openTrailer('<?= htmlspecialchars($value) ?>')">🎬 Ver Tráiler</a>
                    <?php else: ?>
                        <span style="color:#bbb;">Sin tráiler</span>
                    <?php endif; ?>

                <?php else: ?>
                    <?= htmlspecialchars($value) ?>
                <?php endif; ?>

            </td>
            <?php endforeach; ?>

            <td data-label="Acciones">
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

<!-- Modal para ver trailer -->
<div id="trailerModal">
    <div id="trailerContent">
        <span id="closeTrailer" onclick="closeTrailer()">✖</span>
        <iframe id="trailerFrame" src="" allowfullscreen></iframe>
    </div>
</div>

<script>
// Abrir modal y cargar tráiler
function openTrailer(url) {
    document.getElementById("trailerModal").style.display = "block";

    // Si es un link normal de YouTube lo convertimos a embed
    if (url.includes("watch?v=")) {
        url = url.replace("watch?v=", "embed/");
    }

    document.getElementById("trailerFrame").src = url;
}

// Cerrar modal
function closeTrailer() {
    document.getElementById("trailerModal").style.display = "none";
    document.getElementById("trailerFrame").src = ""; // detener el video
}

// Cerrar haciendo clic afuera
window.onclick = function(event) {
    let modal = document.getElementById("trailerModal");
    if (event.target === modal) {
        closeTrailer();
    }
}
</script>

</body>
</html>

<?php
$conn->close();
?>
