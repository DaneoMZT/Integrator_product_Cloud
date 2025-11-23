<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inicio - Integrator Product Cloud</title>

<style>
/* Reset básico */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background: url('/assets/fondo_rick_morty.webp') no-repeat center center fixed;
    background-size: cover;
    color: #fff;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    position: relative;
    padding: 20px;
}

/* Overlay oscuro para mejor contraste */
body::before {
    content: "";
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
    z-index: 0;
}

.container {
    position: relative;
    z-index: 1;
    max-width: 700px;
}

h1 {
    font-size: 2.5em;
    margin-bottom: 10px;
    text-shadow: 2px 2px 8px #000;
}

h2 {
    font-size: 1.5em;
    margin-bottom: 20px;
    font-weight: 400;
    text-shadow: 1px 1px 6px #000;
}

p {
    font-size: 1.1em;
    margin-bottom: 15px;
    text-shadow: 1px 1px 4px #000;
}

.btn {
    display: inline-block;
    padding: 14px 28px;
    background-color: #17a2b8;
    color: white;
    border-radius: 10px;
    text-decoration: none;
    font-size: 1.2em;
    margin-top: 25px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.4);
    cursor: pointer;
}

.btn:hover {
    background-color: #138496;
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.5);
}

/* Responsivo */
@media (max-width: 480px) {
    h1 { font-size: 2em; }
    h2 { font-size: 1.2em; }
    p { font-size: 1em; }
    .btn { padding: 12px 22px; font-size: 1em; }
}
</style>
</head>
<body>

<div class="container">
    <h1>🎬 Bienvenido a Producto Integrador</h1>
    <h2>Aplicación web dinámica en un servicio de la nube</h2>
    <p>Desarrollada por Daniel Israel Ruiz Beltrán</p>
    <p>Haz clic en el botón para ver el catálogo de películas con toda la información actualizada.</p>

    <a href="movies.php" class="btn">📚 Catálogo</a>
</div>

</body>
</html>
