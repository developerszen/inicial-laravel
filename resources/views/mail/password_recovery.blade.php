<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <div>
        <h1>Recuperación de Contraseña</h1>
        <p>Usuario: {{ $user->name }}</p>
        <a href="http://laravel-inicial.test/password?reset_token={{ $user->reset_token }}">
            Seguir enlace
        </a>
    </div>
</body>
</html>