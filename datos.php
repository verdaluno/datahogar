<?php
    session_start();
    ob_start();

    if($_SESSION['correcto']<>1){
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
            <a class="nav-link" href="salir.php">Salir</a>
          </li>
        </ul>
      </div>
    </nav>
    
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Consultar Ingresos</h2>
                    <form action="datos.php" method="post">
                        <input class="form-control" type="date" name="fecI" value="<?php echo date("Y-m-d"); ?>">
                        <input class="form-control" type="date" name="fecF" value="<?php echo date("Y-m-d"); ?>">
                        <input class="form-control btn-outline-primary" type="submit" name="btnL" value="Mostrar">
                    </form>
            </div>
            <div class="col-md-6">
                <?php
                // Consultar tabla ventas
                if(isset($_POST['btnL'])){

                    $fechI = $_POST['fecI'];
                    $fechF = $_POST['fecF'];
                    $idusr = $_SESSION['idusr'];

                include("../abrir_conexion.php");

                $sql = "SELECT * FROM $tablaIngresos WHERE (fecha BETWEEN '$fechI' AND '$fechF') AND (id_num_age = '$idusr')";
                $resultado = mysqli_query ($conexion, $sql) or die (mysql_error ());
                $libros = array();
                while( $rows = mysqli_fetch_assoc($resultado) ) {
                $libros[] = $rows;
                }
                include("../cerrar_conexion.php");
                ?>

                <h2>Vista Local</h2>
                <div class="table-responsive">
                <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                <th>Fecha</th>
                <th>Fuente</th>
                <th>Valor</th>
                <th>Detalle</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($libros as $libro) { ?>
                <tr>
                <td><?php echo $libro ['fecha']; ?></td>
                <td><?php echo $libro ['fuente']; ?></td>
                <td><?php echo $libro ['valor']; ?></td>
                <td><?php echo $libro ['detalle_i']; ?></td>
                </tr>
                <?php } ?>
                </tbody>
                </table>
                </div>
            </div>
                <?php } ?>
        </div>
    </div>
<br/>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
