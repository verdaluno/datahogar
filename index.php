<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalabel=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>Nombroj - Cuentas claras, control a la mano.</title>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <hr>
                <?php
                include("abrir_conexion.php");
                $resultados = mysqli_query($conexion,"SELECT * FROM $tablaTotal ORDER BY id_total DESC LIMIT 1");
                while($consulta = mysqli_fetch_array($resultados)) {
                    $mostrar = $consulta['total'];
                    echo "<p class=\"nombro\">$ ". $mostrar ."</p>";
                    include("cerrar_conexion.php");
                }
                ?>
                <hr>
                <h2>Ingresos</h2>
                <form action="index.php" method="post">
                    <input class="form-control" type="text" name="ingreso" placeholder="Ingresos"> 
                    <select class="form-control" type="text" name="fuente">
                        <option value="Seleccione Motivo">Seleccione Motivo</option>
                        <option value="Nómina">Nómina</option>
                        <option value="Meloso">Meloso</option>
                        <option value="Verda Luno">Verda Luno</option>
                        <option value="Otro">Otro</option>
                    </select>
                    <input class="form-control" type="text" name="detalle" placeholder="Detalles">
                    <input class="form-control" type="date" name="fechIn" placeholder="Fecha">
                    <input class="form-control btn-outline-success" type="submit" name="btn-in" value="Actualizar">
                <?php
                // INSERTAR
                if (isset($_POST['btn-in'])){
                
                    $ingreso = $_POST['ingreso'];
                    $fuente = $_POST['fuente'];
                    $detalle = $_POST['detalle'];
                    $fechai = $_POST['fechIn'];
                    
                    if($ingreso == "" || $fuente == "" || $fechai == ""){
                        echo "Complete todos los campos.";
                    } else {
                    include("abrir_conexion.php");
                    // INSERTO VALORES DE INGRESOS
                    $conexion->query("INSERT INTO $tablaIngresos (valor,fuente,detalle_i,fecha) values('$ingreso','$fuente','$detalle','$fechai')"); 
                    }
                    // CONSULTA ÚLTIMO VALOR INGRESADO
                    $resultados = mysqli_query($conexion,"SELECT * FROM $tablaIngresos ORDER BY id_in DESC LIMIT 1");
                    while($consulta = mysqli_fetch_array($resultados)) {
                        $valuno = $consulta['valor'];
                        echo $valuno . "</br> valor ingresaro";
                    }
                    // CONSULTA ÚLTIMO VALOR TOTAL
                    $resultados = mysqli_query($conexion,"SELECT * FROM $tablaTotal ORDER BY id_total DESC LIMIT 1");
                    while($consulta = mysqli_fetch_array($resultados)) {
                        $valdos = $consulta['total'];
                        echo $valdos . "</br> valor total";
                    }
                    
                    echo $sum = $valuno + $valdos . "suma de los dos";

                    $conexion->query("INSERT INTO $tablaTotal (total) values('$sum')");

                    include("cerrar_conexion.php");
                    header('Location:index.php');
                    }
                ?>
                
                </form>
                <h2>Gastos</h2>
                <form action="#" method="post">
                    <input class="form-control" type="text" name="gasto" placeholder="Monto">
                    <select class="form-control" type="text" name="fuenteg">
                        <option value="Seleccione Motivo">Seleccione Motivo</option>
                        <option value="Arriendo">Arriendo</option>
                        <option value="Mercado">Mercado</option>
                        <option value="Vestuario">Vestuario</option>
                        <option value="Estudio">Estudio</option>
                        <option value="Empresas">Empresas</option>
                        <option value="Otro">Otro</option>
                    </select>
                    <input class="form-control" type="text" name="razon" placeholder="Detalles">
                    <input class="form-control" type="date" name="fechOut" placeholder="Fecha">
                    <input class="form-control btn-outline-danger" type="submit" name="btn-out" value="Actualizar">
                    <?php
                // ACTUALIZAR
                if (isset($_POST['btn-out'])){
              
                    $egreso = $_POST['gasto'];
                    $fuenteg = $_POST['fuenteg'];
                    $razon = $_POST['razon'];
                    $fechae = $_POST['fechOut'];;
                    
                    if($egreso == "" || $fuenteg == "" || $fechae == ""){
                        echo "Complete todos los campos.";
                    } else {
                    include("abrir_conexion.php");
                    // INSERTAR VALOR A RESTAR
                    $conexion->query("INSERT INTO $tablaEgresos (monto,detalle_e,detalles,fecha) values('$egreso','$fuenteg','$razon','$fechae')"); 
                    }
                    // CONSULTA VALOR TOTAL QUE SERÁ DISMINUIDO
                    $resultados = mysqli_query($conexion,"SELECT * FROM $tablaTotal ORDER BY id_total DESC LIMIT 1");
                    while($consulta = mysqli_fetch_array($resultados)) {
                    $total = $consulta['total'];
                    
                        $total = $consulta['total'];
                        $act = $total - $egreso;
                        
                    $conexion->query("INSERT INTO $tablaTotal (total) values('$act')");

                    include("cerrar_conexion.php");
                    header('Location:index.php');
                    }
                }
                ?>
                </form>
            </div>
        </div>
    </div>
<br/>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>