<?php
require 'db.php';

// Consultar todas las columnas de la tabla movies
$sql = "SELECT * FROM movies ORDER BY id ASC";
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
    background: #111 url('/assets/fondo_rick_morty.webp') no-repeat center center fixed;
    background-size: cover;
    color: #fff;
    text-align: center;
    margin: 0;
    padding: 20px;
}

h1 { text-shadow: 2px 2px 4px #000; margin-bottom: 20px; }

.btn {
    display: inline-block;
    padding: 8px 16px;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    margin: 5px;
    transition: 0.3s;
    cursor: pointer;
    font-size: 0.9em;
}
.btn:hover { background-color: #0056b3; }

.cards-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}

.card {
    background: rgba(0,0,0,0.75);
    border-radius: 10px;
    padding: 15px;
    width: 250px;
    box-shadow: 0 0 10px rgba(0,0,0,0.5);
    text-align: left;
    transition: transform 0.3s;
}

.card:hover { transform: scale(1.03); }

.card img {
    width: 100%;
    border-radius: 8px;
    margin-bottom: 10px;
}

.card h2 {
    font-size: 1.2em;
    margin: 5px 0;
}

.card p {
    font-size: 0.9em;
    margin: 5px 0;
}

.card .actions {
    margin-top: 10px;
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    justify-content: center;
}

#trailerModal {
    display:none; position:fixed; z-index:9999; padding-top:60px; left:0; top:0;
    width:100%; height:100%; overflow:auto; background:rgba(0,0,0,0.85);
}
#trailerContent { margin:auto; background:#000; width:90%; max-width:800px; padding:10px; border-radius:10px; position:relative; }
#closeTrailer { position:absolute; top:-25px; right:-25px; background:red; color:#fff; padding:10px 15px; border-radius:50%; cursor:pointer; font-size:20px; }
iframe { width:100%; height:450px; border-radius:10px; }

@media (max-width: 600px) {
    .card { width: 90%; }
    iframe { height:250px; }
}
</style>
</head>
<body>

<h1>🎥 Catálogo de Películas</h1>
<a href="add_movie.php" class="btn">➕ Agregar Película</a>
<a href="index.php" class="btn" style="background:#17a2b8;">🏠 Inicio</a>

<div class="cards-container">
<?php if ($result && $result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
    <div class="card">
        <?php if(!empty($row['image'])): ?>
            <img src="/assets/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
        <?php endif; ?>
        <h2><?= htmlspecialchars($row['title']) ?></h2>
        <p><strong>Director:</strong> <?= htmlspecialchars($row['director']) ?></p>
        <p><strong>Año:</strong> <?= htmlspecialchars($row['year']) ?></p>
        <p><?= htmlspecialchars($row['description']) ?></p>
        <div class="actions">
            <?php if(!empty($row['trailer_url'])): ?>
                <a class="btn" href="#" onclick="openTrailer('<?= htmlspecialchars($row['trailer_url']) ?>')">🎬 Tráiler</a>
            <?php else: ?>
                <span style="color:#bbb; font-size:0.8em;">Sin tráiler</span>
            <?php endif; ?>
            <a class="btn" href="edit_movie.php?id=<?= $row['id'] ?>" style="background:#ffc107; color:#000;">✏️ Editar</a>
            <a class="btn" href="delete_movie.php?id=<?= $row['id'] ?>" style="background:#dc3545;" onclick="return confirm('¿Seguro que quieres eliminar esta película?');">🗑️ Borrar</a>
        </div>
    </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No hay películas registradas.</p>
<?php endif; ?>
</div>

<div id="trailerModal">
<div id="trailerContent">
<span id="closeTrailer" onclick="closeTrailer()">✖</span>
<iframe id="trailerFrame" src="" allowfullscreen></iframe>
</div>
</div>

<script>
function openTrailer(url){
    document.getElementById("trailerModal").style.display="block";
    if(url.includes("watch?v=")) url=url.replace("watch?v=","embed/");
    document.getElementById("trailerFrame").src=url;
}
function closeTrailer(){
    document.getElementById("trailerModal").style.display="none";
    document.getElementById("trailerFrame").src="";
}
window.onclick=function(event){
    if(event.target===document.getElementById("trailerModal")) closeTrailer();
}
</script>

</body>
</html>

<?php $conn->close(); ?>