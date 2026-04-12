<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesion - Enerkoi</title>
</head>
<body>
    <h1>Ey!, hace tiempo no nos veiamos , bienvenido de vuelta a Enerkoi</h1>

    @if ($errors->any())
    <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px;">
        @foreach($errors->all() as $error)
        <p style="margin: 0;">{{$error}}</p>
        @endforeach
    </div>
    @endif

    <form action="/login" method="POST">
        @csrf
        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email')}}" required><br><br>
        <label>Contraseña:</label><br>
        <input type="password" name="password"  required><br><br>

        <button type="submit">Iniar Sesion</button>
    </form>
    <p>¿QUE?, ¿Aun no tienes cuenta? <a href="/registro">Que esperas?</a></p>
</body>
</html>