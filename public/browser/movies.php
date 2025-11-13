<?php
require 'db.php';
$sql = "SELECT * FROM movies";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Catálogo de Películas 🎬</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #111 url('https://wallpapercave.com/wp/wp6616084.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      text-align: center;
      padding: 20px;
    }
    table {
      width: 90%;
      margin: 20px auto;
      border-collapse: collapse;
      background: rgba(0,0,0,0.7);
      border-radius: 10px;
      overflow: hidden;
    }
    th, td {
      padding: 10px;
      border-bottom: 1px solid #444;
    }
    th {
      background-color: #222;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    tr:nth-child(even) { background-color: #1a1a1a; }
    tr:hover { background-color: #333; }
    a.button {
      color: white;
      text-decoration: none;
      background: #007BFF;
      padding: 6px 12px;
      border-radius: 5px;
      transition: 0.2s;
    }
    a.button:hover { background: #0056b3; }
  </style>
</head>
<body>
  <h1>🎥 Catálogo de Películas</h1>
  <a href="add_movie.php" class="button">➕ Agregar Película</a>

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
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <?php foreach ($row as $value): ?>
              <td><?= htmlspecialchars($value) ?></td>
            <?php endforeach; ?>
            <td>
              <a class="button" href="edit_movie.php?id=<?= $row['id'] ?>">✏️ Editar</a>
              <a class="button" href="delete_movie.php?id=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar esta película?')">🗑️ Borrar</a>
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

<?php $conn->close(); ?>
