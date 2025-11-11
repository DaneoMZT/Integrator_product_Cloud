<?php
// 🔹 Conexión usando variables de entorno de Railway
$host = getenv('MYSQLHOST') ?: 'switchyard.proxy.rlwy.net';
$port = getenv('MYSQLPORT') ?: 12014;
$user = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: 'TaqXGlSrbEExYMYKCrhcvSxSIrMuMbFT';
$database = getenv('MYSQLDATABASE') ?: 'railway';

// Crear conexión
$conn = new mysqli($host, $user, $password, $database, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
} else {
    echo "✅ Conexión exitosa a MySQL<br>";
}

// Consultar los datos de movies
$sql = "SELECT id, title, description, year FROM movies";
$result = $conn->query($sql);

// Mostrar datos
if ($result && $result->num_rows > 0) {
    echo "<h2>🎬 Datos de la tabla movies</h2>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Título</th><th>Descripción</th><th>Año</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".htmlspecialchars($row['id'])."</td>";
        echo "<td>".htmlspecialchars($row['title'])."</td>";
        echo "<td>".htmlspecialchars($row['description'])."</td>";
        echo "<td>".htmlspecialchars($row['year'])."</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay datos en la tabla movies.</p>";
}

// Cerrar conexión
$conn->close();
?>
