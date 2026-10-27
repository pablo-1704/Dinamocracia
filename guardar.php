<?php

$servidor = "localhost";
$base_datos = "dinamocracia";
$usuario = "root";
$clave = "";

// Verificar que los datos lleguen desde el formulario
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Debes enviar el formulario de registro.");
}

// Recibir los datos
$nombre = trim($_POST["nombre"] ?? "");
$correo = trim($_POST["correo"] ?? "");
$contrasena = $_POST["contrasena"] ?? "";

// Validar los datos
if (
    $nombre === "" ||
    strlen($nombre) > 100 ||
    !filter_var($correo, FILTER_VALIDATE_EMAIL) ||
    strlen($correo) > 150 ||
    strlen($contrasena) < 8
) {
    exit("Verifica los datos y vuelve a intentarlo.");
}

try {
    // Conectar con la base de datos
    $conexion = new PDO(
        "mysql:host=$servidor;dbname=$base_datos;charset=utf8mb4",
        $usuario,
        $clave
    );

    $conexion->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    // Proteger la contraseña antes de guardarla
    $contrasena_segura = password_hash(
        $contrasena,
        PASSWORD_DEFAULT
    );

    // Insertar el usuario en la tabla
    $sql = "INSERT INTO usuarios (nombre, correo, contrasena)
            VALUES (:nombre, :correo, :contrasena)";

    $consulta = $conexion->prepare($sql);

    $consulta->execute([
        ":nombre" => $nombre,
        ":correo" => $correo,
        ":contrasena" => $contrasena_segura
    ]);
       header("Location: index.html?registro=exitoso");
exit;

// Redirigir a la página principal después de registrar
    header("Location: index.html");
    exit;

} catch (PDOException $error) {

    // Verificar si el correo ya está registrado
    if ($error->getCode() == "23000") {
        echo "Este correo ya está registrado. Utiliza otro correo.";
    } else {
        error_log($error->getMessage());
        http_response_code(500);
        echo "Ocurrió un error al guardar el registro.";
    }
}

?>