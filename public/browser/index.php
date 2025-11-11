<?php
require 'db.php';
$sql = "SELECT id, title, description, year, image FROM movies";
$result = $conn->query($sql);
?>
<div id="movies-container" style="width:80%; margin:20px auto; color:#fff;">
  <h2>🎥 Catálogo de Películas</h2>
  <?php if ($result && $result->num_rows > 0): ?>
    <table style="width:100%; border-collapse: collapse; color:#fff; margin-top: 10px;">
      <tr style="background-color:#333;">
        <th>ID</th>
        <th>Imagen</th>
        <th>Título</th>
        <th>Descripción</th>
        <th>Año</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr style="background-color:#222;">
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td>
            <img src="assets/<?= htmlspecialchars($row['image']) ?>" 
                alt="<?= htmlspecialchars($row['title']) ?>" 
                style="width:80px; height:auto; border-radius:5px;">
          </td>
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
