<?php
    session_start();
    ob_start();

    if($_SESSION['correcto']<>1){
    header('Location:salir.php');
    }

    $idusr = $_SESSION['idusr'];
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
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
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
              <a class="nav-link" href="datos.php">Registros</a>
            <a class="nav-link" href="salir.php">Salir</a>
          </li>
        </ul>
      </div>
    </nav>
    
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Registro Ingresos</h2>
                <canvas id="chartIn" width="100%" height="100%"></canvas>
            </div>
            <div class="col-md-6">
                <h2>Registro Egresos</h2>
                <canvas id="chartEg" width="100%" height="100%"></canvas>
            </div>
            
            <div class="col-md-6">
                <?php
                include("abrir_conexion.php");
                $resultados = mysqli_query($conexion,"SELECT COUNT(*) as nomina FROM $tablaIngresos WHERE id_usr = '$idusr' AND fuente = 'Nómina'");
                while($consulta = mysqli_fetch_array($resultados)) {
                $nomina = $consulta['nomina'];
                }
                $resultados = mysqli_query($conexion,"SELECT COUNT(*) as indepen FROM $tablaIngresos WHERE id_usr = '$idusr' AND fuente = 'Independiente'");
                while($consulta = mysqli_fetch_array($resultados)) {
                $indepen = $consulta['indepen'];
                }
                $resultados = mysqli_query($conexion,"SELECT COUNT(*) as devol FROM $tablaIngresos WHERE id_usr = '$idusr' AND fuente = 'Devoluciones'");
                while($consulta = mysqli_fetch_array($resultados)) {
                $devol = $consulta['devol'];
                }
                $resultados = mysqli_query($conexion,"SELECT COUNT(*) as otro FROM $tablaIngresos WHERE id_usr = '$idusr' AND fuente = 'Otro'");
                while($consulta = mysqli_fetch_array($resultados)) {
                $otroi = $consulta['otro'];
                }
                include("cerrar_conexion.php");
                ?>
            </div>
            <div class="col-md-6">
                <?php
                include("abrir_conexion.php");
                $resultados = mysqli_query($conexion,"SELECT COUNT(*) as hogar FROM $tablaEgresos WHERE id_usr = '$idusr' AND detalle_e = 'Hogar'");
                while($consulta = mysqli_fetch_array($resultados)) {
                $hogar = $consulta['hogar'];
                }
                $resultados = mysqli_query($conexion,"SELECT COUNT(*) as alim FROM $tablaEgresos WHERE id_usr = '$idusr' AND detalle_e = 'Alimentación'");
                while($consulta = mysqli_fetch_array($resultados)) {
                $alim = $consulta['alim'];
                }
                $resultados = mysqli_query($conexion,"SELECT COUNT(*) as ves FROM $tablaEgresos WHERE id_usr = '$idusr' AND detalle_e = 'Vestuario'");
                while($consulta = mysqli_fetch_array($resultados)) {
                $ves = $consulta['ves'];
                }
                $resultados = mysqli_query($conexion,"SELECT COUNT(*) as estudio FROM $tablaEgresos WHERE id_usr = '$idusr' AND detalle_e = 'Estudio'");
                while($consulta = mysqli_fetch_array($resultados)) {
                $estudio = $consulta['estudio'];
                }
                $resultados = mysqli_query($conexion,"SELECT COUNT(*) as inver FROM $tablaEgresos WHERE id_usr = '$idusr' AND detalle_e = 'Inversión'");
                while($consulta = mysqli_fetch_array($resultados)) {
                $inver = $consulta['inver'];
                }
                $resultados = mysqli_query($conexion,"SELECT COUNT(*) as pres FROM $tablaEgresos WHERE id_usr = '$idusr' AND detalle_e = 'Prestamos'");
                while($consulta = mysqli_fetch_array($resultados)) {
                $pres = $consulta['pres'];
                }
                $resultados = mysqli_query($conexion,"SELECT COUNT(*) as otro FROM $tablaEgresos WHERE id_usr = '$idusr' AND detalle_e = 'Otro'");
                while($consulta = mysqli_fetch_array($resultados)) {
                $otroe = $consulta['otro'];
                }
                include("cerrar_conexion.php");
                ?>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            <div class="col-md-6">
                <h2>Consultar Ingresos</h2>
                    <form action="datos.php" method="post">
                        <input class="form-control" type="date" name="fecI" value="<?php echo date("Y-m-d"); ?>">
                        <input class="form-control" type="date" name="fecF" value="<?php echo date("Y-m-d"); ?>">
                        <input class="form-control btn-outline-primary" type="submit" name="btnI" value="Mostrar">
                    </form>
            </div>
            <div class="col-md-6">
                <?php
                // Consultar tabla ingresos
                if(isset($_POST['btnI'])){

                    $fechI = $_POST['fecI'];
                    $fechF = $_POST['fecF'];
                    

                include("abrir_conexion.php");

                $sql = "SELECT * FROM $tablaIngresos WHERE (fecha BETWEEN '$fechI' AND '$fechF') AND (id_usr = '$idusr')";
                $resultado = mysqli_query ($conexion, $sql) or die (mysql_error ());
                $libros = array();
                while( $rows = mysqli_fetch_assoc($resultado) ) {
                $libros[] = $rows;
                }
                include("cerrar_conexion.php");
                ?>
                
                <h2>Consulta Detalles Ingresos</h2>
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
                <td>
                <a class="btn btn-primary" href="#"><i><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
</svg></i></a>
                <a class="btn btn-danger" href="#"><i><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
</svg></i></a>
                </td>
                </tr>
                <?php } ?>
                </tbody>
                </table>
                </div>
                <?php } ?>
            </div>
            
            <div class="col-md-6">
                <h2>Consultar Engresos</h2>
                    <form action="datos.php" method="post">
                        <input class="form-control" type="date" name="fecI" value="<?php echo date("Y-m-d"); ?>">
                        <input class="form-control" type="date" name="fecF" value="<?php echo date("Y-m-d"); ?>">
                        <input class="form-control btn-outline-primary" type="submit" name="btnE" value="Mostrar">
                    </form>
            </div>
            <div class="col-md-6">
                <?php
                // Consultar tabla egresos
                if(isset($_POST['btnE'])){

                    $fechI = $_POST['fecI'];
                    $fechF = $_POST['fecF'];
                    

                include("abrir_conexion.php");

                $sql = "SELECT * FROM $tablaEgresos WHERE (fecha BETWEEN '$fechI' AND '$fechF') AND (id_usr = '$idusr')";
                $resultado = mysqli_query ($conexion, $sql) or die (mysql_error ());
                $libros = array();
                while( $rows = mysqli_fetch_assoc($resultado) ) {
                $libros[] = $rows;
                }
                include("cerrar_conexion.php");
                ?>

                <h2>Consulta Detalles Egresos</h2>
                <div class="table-responsive">
                <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                <th>Fecha</th>
                <th>Fuente</th>
                <th>Monto</th>
                <th>Detalle</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($libros as $libro) { ?>
                <tr>
                <td><?php echo $libro ['fecha']; ?></td>
                <td><?php echo $libro ['detalle_e']; ?></td>
                <td><?php echo $libro ['monto']; ?></td>
                <td><?php echo $libro ['detalles']; ?></td>
                <td>
                <a class="btn btn-primary" href="#"><i><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
</svg></i></a>
                <a class="btn btn-danger" href="#"><i><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
</svg></i></a>
                </td>
                </tr>
                <?php } ?>
                </tbody>
                </table>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
<br/>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    
    
    
    <script>
        
    var nom = <?php echo $nomina ?>;
    var ind = <?php echo $indepen ?>;
    var dev = <?php echo $devol ?>;
    var otr = <?php echo $otroi ?>;
        
    var ctx = document.getElementById("chartIn").getContext("2d");
        var chartIn= new Chart(ctx,{
        type:"doughnut",
        data:{
            labels:['Nomina','Independiente','Devoluciones','Otro'],
            datasets:[{
                data:[nom,ind,dev,otr],
                backgroundColor:[
                    'rgb(28, 87, 53)',
                    'rgb(38, 115, 70)',
                    'rgb(47, 144, 88)',
                    'rgb(56, 173, 105)'
                ]
            }]
        }
        });
    
    </script>
    <script>
        
    var hog = <?php echo $hogar ?>;
    var ali = <?php echo $alim ?>;
    var ves = <?php echo $ves ?>;
    var est = <?php echo $estudio ?>;
    var inv = <?php echo $inver ?>;
    var pres = <?php echo $pres ?>;
    var otre = <?php echo $otroe ?>;
        
    var ctxe = document.getElementById("chartEg").getContext("2d");
        var chartEg= new Chart(ctxe,{
        type:"doughnut",
        data:{
            labels:['Hogar','Alimentación','Vestuario','Estudio','Inversión','Prestamo','Otro'],
            datasets:[{
                data:[hog,ali,ves,est,inv,pres,otre],
                backgroundColor:[
                    'rgb(88, 30, 30)',
                    'rgb(117, 40, 40)',
                    'rgb(147, 50, 50)',
                    'rgb(176, 60, 60)',
                    'rgb(206, 70, 70)',
                    'rgb(235, 80, 80)',
                    'rgb(250, 90, 90)'
                ]
            }]
        }
        });
    
    </script>
    
</body>
</html>
