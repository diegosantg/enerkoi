<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Completar Perfil - Enerkoi</title>
    </head>

    <body>
        <h1>¡Ya casi estamos, {{auth()->user()->nombre}}!</h1>
        <p>Necesito unos datos para darte la mejor experiencia posible.</p>

        @if($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="/completar-perfil" method="POST">
            @csrf

            <label>Estatura (cm)</label><br>
            <input type="number" name="estatura" placeholder="La altura se mide de la cabeza al cielo!" required><br><br>

            <label>Peso Inicial (kg)</label><br>
            <input type="number" step="0.1" name="peso_inicial" placeholder="Peso pluma..."><br><br>

            <label>Fecha de nacimiento:</label><br>
            <input type="date" name="fecha_nacimiento" required><br><br>

            <label>¿Cual es tu objetivo?</label>
            <select name="objetivo" required>
                <option value="" disabled selected>Selecciona un objetivo....</option>
                <option value="Ganar masa muscular">Ganar masa muscular(Hipertrofia)</option>
                <option value="Perder grasa">Perder procentaje de grasa(Definicion)</option>
                <option value="Recompocision corporal">Recompocision corporal</option>
                <option value="Mantenimiento">Mantenimiento/Salud</option>
            </select><br><br>

            <button type="submit">Guardar perfil y empezar en Enerkoi</button>
        </form>
    </body>

</html>