<!doctype html>
<html lang="en" data-beasties-container>
<head>
  <meta charset="utf-8">
  <title>Catalogo_Peliculas</title>
  <base href="./">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="#">
<style>
/* ... aquí va todo tu CSS actual sin cambios ... */
</style>
<link rel="stylesheet" href="styles-M6P3YWOE.css" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="styles-M6P3YWOE.css"></noscript>
</head>
<body>
  <app-root></app-root>

  <!-- 🔹 Tabla de películas usando PHP -->
  <?php
  require 'db.php'; // Ajusta la ruta si db.php está en otra carpeta
  $sql = "SELECT id, title, description, year FROM movies";
  $result = $conn->query($sql);
  ?>
  <div id="movies-container" style="width:80%; margin:20px auto; color:#fff;">
    <h2>🎥 Catálogo de Películas</h2>
    <?php if ($result && $result->num_rows > 0): ?>
      <table style="width:100%; border-collapse: collapse; color:#fff; margin-top: 10px;">
        <tr style="background-color:#333;">
          <th>ID</th>
          <th>Título</th>
          <th>Descripción</th>
          <th>Año</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr style="background-color:#222;">
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= htmlspecialchars($row['year']) ?></td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p>No hay películas registradas.</p>
    <?php endif; ?>
  </div>

<script src="polyfills-B6TNHZQ6.js" type="module"></script>
<script src="scripts-SQ7W6IC7.js" defer></script>
<script src="main-E3VRN7CM.js" type="module"></script>
</body>
<footer>
  <div class="footer-content">
    <p>© 2025 Catálogo de Películas 🎬 | Desarrollado por <strong>Daniel Ruiz Beltrán</strong></p>
    <p>Materia: <strong>Conceptualización de entornos de desarrollo de aplicaciones y servicios</strong></p>
    <p>Código: <strong>399426381</strong></p>
    <p>Correo: <a href="mailto:ruizdaneo@gmail.com">ruizdaneo@gmail.com</a></p>
  </div>
</footer>
</html>
