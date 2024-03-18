<?php
include('conexion.php');

if (isset($_POST['lenguaje'])) {
    $buscar = "SELECT * FROM datos WHERE (lenguaje = '{$_POST['lenguaje']}' AND ip = '{$_SERVER['REMOTE_ADDR']}') OR (framework = '{$_POST['frameworks']}' AND ip = '{$_SERVER['REMOTE_ADDR']}')";
    $haydatos = $pdo->prepare($buscar);
    $haydatos->execute();
    $obtenido = $haydatos->fetchAll(PDO::FETCH_ASSOC);

    if ($obtenido) {
        echo '<p style="color: red; font-weight: bold; font-size: 24px; text-align: center; margin-top: 50vh; transform: translateY(-50%);">¡NO SE PERMITEN VOTOS REPETIDOS POR LA MISMA PERSONA!</p>';

        echo '<audio autoplay>
        <source src="peligro.mp3" type="audio/mpeg">
        Tu navegador no soporta el elemento de audio.
      </audio>';
    } else {
        //print_r($_POST);
        $agregar = "INSERT INTO datos(lenguaje,framework,ip) VALUES (?,?,?)";
        $insertar = $pdo->prepare($agregar);
        $insertar->execute(array($_POST['lenguaje'], $_POST['frameworks'], $_SERVER['REMOTE_ADDR']));

        echo '<p style="color: green; font-weight: bold; font-size: 24px; text-align: center; margin-top: 50vh; transform: translateY(-50%);">VOTO AGREGADO</p>';
        echo '<audio autoplay>
        <source src="feliz.mp3" type="audio/mpeg">
        Tu navegador no soporta el elemento de audio.
      </audio>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Tomar decision</title>
</head>

<body>
    <div class="container">
        <form action="#" method="post" class="animated-form">
            <select name="lenguaje" required>
                <!-- Lenguajes de programación -->
                <option value="java">Java</option>
                <option value="python">Python</option>
                <option value="javascript">JavaScript</option>
                <option value="html">HTML</option>
                <option value="css">CSS</option>
                <option value="php">PHP</option>
                <option value="csharp">C#</option>
                <option value="cplusplus">C++</option>
                <option value="c">C</option>
                <option value="ruby">Ruby</option>
                <option value="swift">Swift</option>
                <option value="typescript">TypeScript</option>
                <option value="go">Go</option>
                <option value="rust">Rust</option>
                <option value="scala">Scala</option>
                <option value="kotlin">Kotlin</option>
                <option value="perl">Perl</option>
                <option value="lua">Lua</option>
                <option value="r">R</option>

            </select>
            <select name="frameworks" required>
                <option value="django">Django (Python)</option>
                <option value="flask">Flask (Python)</option>
                <option value="express">Express.js (JavaScript)</option>
                <option value="react">React.js (JavaScript)</option>
                <option value="angular">Angular (JavaScript/TypeScript)</option>
                <option value="vue">Vue.js (JavaScript)</option>
                <option value="laravel">Laravel (PHP)</option>
                <option value="symfony">Symfony (PHP)</option>
                <option value="aspnet">ASP.NET (C#)</option>
                <option value="spring">Spring (Java)</option>
                <option value="rubyonrails">Ruby on Rails (Ruby)</option>
                <option value="express">Express.js (Node.js/JavaScript)</option>
                <option value="laravel">Laravel (PHP)</option>
                <option value="django">Django (Python)</option>
            </select>
            <input type="submit" value="Enviar Opinión">
        </form>
    </div>
    <?php
    $sql = 'SELECT * FROM datos';
    $datos = $pdo->prepare($sql);
    $datos->execute();
    $obtenido = $datos->fetchAll(PDO::FETCH_ASSOC);
if ($obtenido) {
    // Contar las palabras repetidas
    include_once('framework.php');
    ?>
    <hr>
    <?php
    include_once('lenguaje.php');
}
    ?>

</body>

</html>