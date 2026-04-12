<!DOCTYPE html>
<html lang="es">
<head >
    <meta charset="UTF-8">
    <title>Registro-Enerkoi</title>
</head>

    <body>
        <h1>Crea tu cuenta en Enerkoi</h1>
        @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="/registro" method="POST">
        @csrf
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Apellido Paterno:</label><br>
        <input type="text" name="apellido_p" required><br><br>

        <label>Apellido Materno:</label><br>
        <input type="text" name="apellido_m" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Confirmar Contraseña:</label><br>
        <input type="password" name="password_confirmation" required><br><br>


        <button type="submit">Registrarme</button>
        </form>
        <p>¿Ya tienes una cuenta?<a href="/login">Inicia sesion</a></p>
    </body>
    

</html>