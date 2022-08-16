s<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalabel=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>DataHogar - Cuentas claras, control a la mano.</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3">

            </div>
            <div class="col-md-6 login">
                <img src="img/registro.png" />
                <p>Realiza tu registro para que puedas empezar a administrar tus ingresos y egresos de manera rápida y segura.</p>
                <form action="registro.php" method="post">
                    <input class="form-control" type="text" name="nombres" placeholder="Nombres">
                    <input class="form-control" type="text" name="apellidos" placeholder="Apellidos">
                    <input class="form-control" type="email" name="mail" placeholder="Correo">
                    <input class="form-control" type="password" name="pass" placeholder="Clave">
                    <input class="form-control btn-outline-success" type="submit" name="btnReg" value="¡Registrarme!">
                </form>
                <?php
                if (isset($_POST['btnReg'])) {
                    $nom = $_POST['nombres'];
                    $apel = $_POST['apellidos'];
                    $mail = $_POST['mail'];
                    $pass = $_POST['pass'];

                    include("abrir_conexion.php");
                    $conexion->query("INSERT INTO $tablaUsuarios (nombres,apellidos,correo,clave) values('$nom','$apel','$mail','$pass')");
                    include("cerrar_conexion.php");
                    echo "<p style=\"color:#FF9363;\">Registro Completado con Éxito</p>";
                }
                ?>
                <p><a href="index.php">¡Inicia Sesión!</a></p>
            </div>
            <div class="col-md-3">

            </div>
        </div>
    </div>
</body>

</html>