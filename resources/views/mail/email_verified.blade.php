<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <div>
        <h1>Verificación de correo electrónico</h1>
        <p>Usario: {{ $user->name }}</p>
        <p>Por favor siga el siguiente enlace:</p>

        <a href="http://laravelinicialapp.test/verify-email?email_verified_token={{ $user->email_verified_token }}">
            Seguir enlace
        </a>
    </div>
</body>
</html>