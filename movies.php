<?php
// 🔹 Conexión a la base de datos (usa variables de entorno en Railway)
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
    img {
      border-radius: 6px;
      max-width: 100px;
      height: auto;
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
          // 🔹 Generar dinámicamente los encabezados según las columnas de la base de datos
          $fields = $result->fetch_fields();
          foreach ($fields as $field) {
              echo "<th>" . htmlspecialchars($field->name) . "</th>";
          }
          ?>
        </tr>
      </thead>
      <tbody>
        <?php
        // 🔹 Regresar el puntero al inicio y recorrer todos los registros
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()):
        ?>
          <tr>
            <?php foreach ($row as $key => $value): ?>
              <td>
                <?php if ($key === 'image' && !empty($value)): ?>
                  <img src="<?= htmlspecialchars($value) ?>" alt="Imagen" width="100">
                <?php else: ?>
                  <?= htmlspecialchars($value) ?>
                <?php endif; ?>
              </td>
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
