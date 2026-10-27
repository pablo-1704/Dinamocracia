<?php
// ========================================
// CONEXION CON LA BASE DE DATOS
// ========================================

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "politica_cuento";

$conn = new mysqli(
    $servidor,
    $usuario,
    $contrasena,
    $base_datos
);

$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Error al conectar con la base de datos.");
}

// ========================================
// RECIBIR LOS DATOS DEL FORMULARIO
// ========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contacto.html");
    exit;
}

$nombre = trim($_POST["nombre"] ?? "");
$correo = trim($_POST["email"] ?? "");
$grado = trim($_POST["Grado"] ?? "");
$tema = trim($_POST["tema"] ?? "");
$opinion = trim($_POST["opinion"] ?? "");
$genero = trim($_POST["genero"] ?? "");

$intereses = $_POST["interes"] ?? [];

if (!is_array($intereses)) {
    $intereses = [];
}

$intereses = array_map(
    "trim",
    $intereses
);

$intereses = array_filter(
    $intereses,
    function ($valor) {
        return in_array(
            $valor,
            ["politica", "democracia", "ciudadania"],
            true
        );
    }
);

$intereses = implode(", ", $intereses);

// ========================================
// VALIDAR LOS DATOS
// ========================================

if (
    $nombre === "" ||
    !filter_var($correo, FILTER_VALIDATE_EMAIL) ||
    $opinion === ""
) {
    die(
        "Verifica tu nombre, correo y opinión. " .
        "Son campos obligatorios. " .
        "<a href='contacto.html'>Volver al formulario</a>"
    );
}

// ========================================
// GUARDAR EN MYSQL
// ========================================

$sql = "INSERT INTO mensajes_contacto
        (nombre, correo, grado, tema, opinion, genero, intereses)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("No se pudo preparar el registro.");
}

$stmt->bind_param(
    "sssssss",
    $nombre,
    $correo,
    $grado,
    $tema,
    $opinion,
    $genero,
    $intereses
);

if ($stmt->execute()) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, initial-scale=1.0">

        <title>Mensaje enviado</title>

        <style>
            body {
                margin: 0;
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                background: #f2f5fa;
                font-family: Arial, sans-serif;
            }

            .mensaje {
                width: 85%;
                max-width: 430px;
                padding: 35px 25px;
                background: white;
                border-radius: 20px;
                text-align: center;
                box-shadow: 0 5px 20px #0002;
            }

            .icono {
                font-size: 55px;
            }

            h1 {
                color: #092c70;
                font-size: 25px;
            }

            p {
                color: #555;
                line-height: 1.6;
            }

            a {
                display: inline-block;
                margin-top: 15px;
                padding: 13px 22px;
                color: white;
                background: #164ba0;
                text-decoration: none;
                border-radius: 25px;
                font-weight: bold;
            }

            a:hover {
                background: #092c70;
            }
        </style>
    </head>

    <body>
        <div class="mensaje">
            <div class="icono">✅</div>

            <h1>¡Mensaje enviado!</h1>

            <p>
                Gracias por participar en
                <strong>La política es mi cuento</strong>.
            </p>

            <p>
                Tu pregunta u opinión se guardó
                correctamente.
            </p>

            <a href="contacto.html">
                Volver a la página de contacto
            </a>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "No fue posible guardar el mensaje. Inténtalo nuevamente.";
}

$stmt->close();
$conn->close();
?>