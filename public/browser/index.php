<?php
// 🔹 Conexión a la base de datos (Railway)
require 'db.php';

// 🔹 Consultar todas las columnas de la tabla movies
$sql = "SELECT * FROM movies";
$result = $conn->query($sql);
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Catálogo de Películas 🎬</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #111;
      color: #fff;
      text-align: center;
      padding: 20px;
    }
    table {
      width: 90%;
      margin: 20px auto;
      border-collapse: collapse;
      background: #1a1a1a;
      border-radius: 10px;
      overflow: hidden;
    }
    th, td {
      padding: 12px;
      border-bottom: 1px solid #444;
    }
    th {
      background-color: #333;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    tr:nth-child(even) {
      background-color: #222;
    }
    tr:hover {
      background-color: #333;
      transition: 0.3s;
    }
  </style>
</head>
<body>

  <h1>🎥 Catálogo de Películas</h1>

  <?php if ($result && $result->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <?php
          // 🔹 Generar los encabezados automáticamente, excepto 'image'
          $fields = $result->fetch_fields();
          foreach ($fields as $field) {
            if ($field->name !== 'image') {
              echo "<th>" . htmlspecialchars($field->name) . "</th>";
            }
          }
          ?>
        </tr>
      </thead>
      <tbody>
        <?php
        // 🔹 Regresar el puntero al inicio del conjunto de resultados
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()):
        ?>
          <tr>
            <?php foreach ($row as $key => $value): ?>
              <?php if ($key !== 'image'): ?>
                <td><?= htmlspecialchars($value) ?></td>
              <?php endif; ?>
            <?php endforeach; ?>
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
