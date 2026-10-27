<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dinamocracia | Registro</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, Helvetica, sans-serif;
            background: #f0f3f5;
            color: #333;
        }

        .registro {
            width: 100%;
            max-width: 430px;
            margin: 35px auto;
            padding: 25px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px #0002;
        }

        h1 {
            text-align: center;
            color: #286c91;
        }

        p {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 16px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 13px;
            margin-top: 22px;
            border: none;
            border-radius: 6px;
            background: #286c91;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #1d506d;
        }

        .volver {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #286c91;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <main class="registro">

        <h1>Crear una cuenta</h1>

        <p>Regístrate para participar en Dinamocracia.</p>

        <form action="guardar.php" method="POST">

            <label for="nombre">Nombre completo:</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                maxlength="100"
                autocomplete="name"
                required
            >

            <label for="correo">Correo electrónico:</label>
            <input
                type="email"
                id="correo"
                name="correo"
                maxlength="150"
                autocomplete="email"
                required
            >

            <label for="contrasena">Contraseña:</label>
            <input
                type="password"
                id="contrasena"
                name="contrasena"
                minlength="8"
                autocomplete="new-password"
                required
            >

            <button type="submit">Registrarme</button>

        </form>

        <a class="volver" href="index.html">
            Volver a la página principal
        </a>

    </main>

</body>
</html>