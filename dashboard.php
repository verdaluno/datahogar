<?php
session_set_cookie_params(60 * 60 * 24 * 14);
session_start();
ob_start();

if (isset($_POST['btnIni'])) {
    $_SESSION['correcto'] = 0;

    $identi = $_POST['mail'];
    $clavelog = $_POST['pass'];

    if ($identi == "" || $clavelog == "") {
        $_SESSION['correcto'] = 2; //2 sera error de campos vacios
    } else {
        include("abrir_conexion.php");
        $_SESSION['correcto'] = 3; //2 seran datos incorrectos

        $resultados = mysqli_query($conexion, "SELECT * FROM $tablaUsuarios WHERE correo = '$identi' AND clave = '$clavelog'");
        while ($consulta = mysqli_fetch_array($resultados)) {

            $_SESSION['correcto'] = 1;
            $_SESSION['nomo'] = $consulta['nombres'];
            $_SESSION['fnomo'] = $consulta['apellidos'];
            $_SESSION['idusr'] = $consulta['id_usr'];
        }

        header('Location:dashboard.php');

        include("cerrar_conexion.php");
    }
}
if ($_SESSION['correcto'] <> 1) {
    header('Location:salir.php');
}
?>

<html>

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
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="dashboard.php">DataHogar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Inicio</a>
                </li>
                <li class="navbar-nav mr-auto">
                    <a class="nav-link" href="datos.php">Registros</a>
                </li>
                <li>
                    <a class="nav-link" href="edita.php">Editar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="salir.php">Salir</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12"><br />
                <?php $user = $_SESSION['nomo'] . ' ' . $_SESSION['fnomo']; ?>
                <p>Usuario activo: </br><?php echo "<b>" . $user . "</b>"; ?></p>
                <hr>
                <?php
                include("abrir_conexion.php");
                $iduser = $_SESSION['idusr'];
                $resultados = mysqli_query($conexion, "SELECT * FROM $tablaTotal WHERE id_usr = '$iduser' ORDER BY id_total DESC LIMIT 1");
                while ($consulta = mysqli_fetch_array($resultados)) {
                    $mostrar = $consulta['total'];
                    echo "<p class=\"nombro\">$ " . $mostrar . "</p>";
                    include("cerrar_conexion.php");
                }
                ?>
                <hr>
                <h2>Ingresos</h2>
                <form action="dashboard.php" method="post">
                    <input class="form-control" type="text" name="ingreso" placeholder="Valor Ingresos" required>
                    <select class="form-control" type="text" name="fuente" required>
                        <option value="" selected="true" disabled="disabled">Seleccione Motivo</option>
                        <option value="Nómina">Nómina</option>
                        <option value="Independiente">Independiente</option>
                        <option value="Devoluciones">Devoluciones</option>
                        <option value="Otro">Otro</option>
                    </select>
                    <input class="form-control" type="text" name="detalle" placeholder="Detalles">
                    <input class="form-control" type="date" name="fechIn" value="<?php echo date('Y-m-d'); ?>">
                    <input class="form-control btn-outline-success" type="submit" name="btn-in" value="Actualizar">
                    <?php
                    // INSERTAR
                    if (isset($_POST['btn-in'])) {

                        $idusr = $_SESSION['idusr'];
                        $ingreso = $_POST['ingreso'];
                        $fuente = $_POST['fuente'];
                        $detalle = $_POST['detalle'];
                        $fechai = $_POST['fechIn'];

                        if ($ingreso == "" || $fuente == "" || $fechai == "") {
                            echo "Complete todos los campos.";
                        } else {
                            include("abrir_conexion.php");
                            // INSERTO VALORES DE INGRESOS
                            $conexion->query("INSERT INTO $tablaIngresos (id_usr,valor,fuente,detalle_i,fecha) values('$idusr','$ingreso','$fuente','$detalle','$fechai')");
                        }
                        // CONSULTA ÚLTIMO VALOR INGRESADO
                        $resultados = mysqli_query($conexion, "SELECT * FROM $tablaIngresos ORDER BY id_in DESC LIMIT 1");
                        while ($consulta = mysqli_fetch_array($resultados)) {
                            $valuno = $consulta['valor'];
                        }
                        // CONSULTA ÚLTIMO VALOR TOTAL
                        $resultados = mysqli_query($conexion, "SELECT * FROM $tablaTotal WHERE id_usr = '$idusr' ORDER BY id_total DESC LIMIT 1");
                        while ($consulta = mysqli_fetch_array($resultados)) {
                            $valdos = $consulta['total'];
                        }

                        $sum = $valuno + $valdos;

                        $conexion->query("INSERT INTO $tablaTotal (id_usr,total) values('$idusr','$sum')");

                        include("cerrar_conexion.php");
                        header('Location:dashboard.php');
                    }
                    ?>

                </form>
                <h2>Egresos</h2>
                <form action="dashboard.php" method="post">
                    <input class="form-control" type="text" name="gasto" placeholder="Valor Egresos" required>
                    <select class="form-control" type="text" name="fuenteg" required>
                        <option value="" selected="true" disabled="disabled">Seleccione Motivo</option>
                        <option value="Hogar">Hogar</option>
                        <option value="Alimentación">Alimentación</option>
                        <option value="Vestuario">Vestuario</option>
                        <option value="Estudio">Estudio</option>
                        <option value="Inversión">Inversión</option>
                        <option value="Prestamos">Prestamos</option>
                        <option value="Otro">Otro</option>
                    </select>
                    <input class="form-control" type="text" name="razon" placeholder="Detalles">
                    <input class="form-control" type="date" name="fechOut" value="<?php echo date('Y-m-d'); ?>">
                    <input class="form-control btn-outline-danger" type="submit" name="btn-out" value="Actualizar">
                    <?php
                    // ACTUALIZAR
                    if (isset($_POST['btn-out'])) {

                        $idusr = $_SESSION['idusr'];
                        $egreso = $_POST['gasto'];
                        $fuenteg = $_POST['fuenteg'];
                        $razon = $_POST['razon'];
                        $fechae = $_POST['fechOut'];;

                        if ($egreso == "" || $fuenteg == "" || $fechae == "") {
                            echo "Complete todos los campos.";
                        } else {
                            include("abrir_conexion.php");
                            // INSERTAR VALOR A RESTAR
                            $conexion->query("INSERT INTO $tablaEgresos (id_usr,monto,detalle_e,detalles,fecha) values('$idusr','$egreso','$fuenteg','$razon','$fechae')");
                        }
                        // CONSULTA VALOR TOTAL QUE SERÁ DISMINUIDO
                        $resultados = mysqli_query($conexion, "SELECT * FROM $tablaTotal WHERE id_usr = '$idusr' ORDER BY id_total DESC LIMIT 1");
                        while ($consulta = mysqli_fetch_array($resultados)) {
                            $total = $consulta['total'];

                            $total = $consulta['total'];
                            $act = $total - $egreso;

                            $conexion->query("INSERT INTO $tablaTotal (id_usr,total) values('$idusr','$act')");

                            include("cerrar_conexion.php");
                            header('Location:dashboard.php');
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
    <br />
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>
