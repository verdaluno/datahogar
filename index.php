<html>
    <head>
        <meta charset="utf-8">
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
                $resultados = mysqli_query($conexion,"SELECT SUM(valor) AS total FROM $tablaIngresos");
                while($consulta = mysqli_fetch_array($resultados)) {
                    $sum = $consulta['total'];
                    echo "<p class=\"nombro\">$ ". $sum ."</p>";
                    include("cerrar_conexion.php");
                }
                ?>
                <hr>
                <h2>Ingresos</h2>
                <form action="index.php" method="post">
                    <input class="form-control" type="text" name="ingreso" placeholder="Ingresos"> 
                    <input class="form-control" type="text" name="fuente" placeholder="Fuente">
                    <input class="form-control" type="date" name="fech-in" placeholder="Fecha">
                    <input class="form-control btn-outline-success" type="submit" name="btn-in" value="Actualizar">
                <?php
                // INSERTAR
                if (isset($_POST['btn-in'])){
              
                    $ingreso = $_POST['ingreso'];
                    $fuente = $_POST['fuente'];
                    $date = date("Y")."-".date("m")."-".date("d");
      
                    if($ingreso == "" || $fuente == "" || $date == ""){
                        echo "Complete todos los campos.";
                    } else {
                    include("abrir_conexion.php");
                    $conexion->query("INSERT INTO $tablaIngresos (valor,fuente,fecha) values('$ingreso','$fuente','$date')"); 
                    include("cerrar_conexion.php");
                        echo "Datos cargados corectamente.";
                    }
                }
                ?>
                
                </form>
                <h2>Gastos</h2>
                <form action="#" method="post">
                    <input class="form-control" type="text" name="gasto" placeholder="Monto"> 
                    <input class="form-control" type="text" name="razon" placeholder="Detalles">
                    <input class="form-control" type="date" name="fech-out" placeholder="Fecha">
                    <input class="form-control btn-outline-danger" type="submit" name="btn-out" value="Actualizar">
                </form>
            </div>
        </div>
    </div>
<br/>
    <footer>
        <p>&copy 2020 | NOMBROJ<br/>
        info@verdaluno.com<br/>
        verdaluno.com</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>