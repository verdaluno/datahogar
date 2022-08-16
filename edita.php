<?php
session_start();
ob_start();

if ($_SESSION['correcto'] <> 1) {
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
            <div class="col-md-6">
                <h4>Consultar Ingresos</h4>
                <form action="edita.php" method="post">
                    <input class="form-control" type="date" name="fecI" value="<?php echo date("Y-m-d"); ?>">
                    <input class="form-control" type="date" name="fecF" value="<?php echo date("Y-m-d"); ?>">
                    <input class="form-control btn-outline-primary" type="submit" name="btnI" value="Mostrar">
                </form>
            </div>
            <div class="col-md-6">
                <?php
                // Consultar tabla ingresos
                if (isset($_POST['btnI'])) {

                    $fechI = $_POST['fecI'];
                    $fechF = $_POST['fecF'];


                    include("abrir_conexion.php");

                    $sql = "SELECT * FROM $tablaIngresos WHERE (fecha BETWEEN '$fechI' AND '$fechF') AND (id_usr = '$idusr')";
                    $resultado = mysqli_query($conexion, $sql) or die(mysql_error());
                    $libros = array();
                    while ($rows = mysqli_fetch_assoc($resultado)) {
                        $libros[] = $rows;
                    }
                    include("cerrar_conexion.php");
                ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Valor</th>
                                    <th>Fuente</th>
                                    <th>Detalle</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($libros as $libro) { ?>
                                    <tr>
                                        <td><?php echo $libro['valor']; ?></td>
                                        <td><?php echo $libro['fuente']; ?></td>
                                        <td><?php echo $libro['detalle_i']; ?></td>
                                        <td><?php echo $libro['fecha']; ?></td>
                                        <td>

                                            <button class="btn btn-primary" onclick="btnUpdate('<?php echo $libro['id_in']; ?>', '<?php echo $libro['fuente']; ?>', '<?php echo $libro['detalle_i']; ?>', '<?php echo $libro['fecha']; ?>')" data-toggle="modal" data-target="#modal"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                                </svg></button>

                                            <button class="btn btn-danger" onclick="btnDelete('<?php echo $libro['id_in']; ?>', '<?php echo $libro['valor']; ?>')" data-toggle="modal" data-target="#modald"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                </svg></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <!-- Modal  Actualizar -->
                        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Actualizar</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="act.php" method="post">
                                            <p>Aquí puedes editar los detalles, si ingresaste un valor equivocado debes elimiar el registro.</p>
                                            <input class="form-control" type="hidden" name="id" id="id">
                                            <label>Fuente</label>
                                            <select class="form-control" type="text" name="fuente" id="fuente">
                                                <option value="Nómina">Nómina</option>
                                                <option value="Independiente">Independiente</option>
                                                <option value="Devoluciones">Devoluciones</option>
                                                <option value="Otro">Otro</option>
                                            </select>
                                            <label>Detalles</label>
                                            <input class="form-control" type="text" name="detalle_i" id="detalle">
                                            <label>Fecha</label>
                                            <input class="form-control" type="date" name="fecha" id="fechaIn">
                                            <input class="form-control btn-outline-success" type="submit" name="btnA" value="Actualizar">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal  Eliminar -->
                        <div class="modal fade" id="modald" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="act.php" method="post">
                                            <label>Al eliminar restaremos el valor ingresado.</label>
                                            <input class="form-control" type="hidden" name="ide" id="idEliminar" readonly>
                                            <input class="form-control" type="text" name="valor" id="valorAc" readonly>
                                            <input class="form-control btn-outline-danger" type="submit" name="btnE" value="Eliminar">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            function btnUpdate(ok, dos, tres, cuatro) {
                                document.getElementById('id').value = ok;
                                document.getElementById('fuente').value = dos;
                                document.getElementById('detalle').value = tres;
                                document.getElementById('fechaIn').value = cuatro;
                            }

                            function btnDelete(id, valor) {
                                document.getElementById('idEliminar').value = id;
                                document.getElementById('valorAc').value = valor;
                            }
                        </script>
                    </div>
                <?php } ?>
            </div>

            <div class="col-md-6">
                <h4>Consultar Egresos</h4>
                <form action="edita.php" method="post">
                    <input class="form-control" type="date" name="fecI" value="<?php echo date("Y-m-d"); ?>">
                    <input class="form-control" type="date" name="fecF" value="<?php echo date("Y-m-d"); ?>">
                    <input class="form-control btn-outline-primary" type="submit" name="btnE" value="Mostrar">
                </form>
            </div>
            <div class="col-md-6">
                <?php
                // Consultar tabla egresos
                if (isset($_POST['btnE'])) {

                    $fechI = $_POST['fecI'];
                    $fechF = $_POST['fecF'];


                    include("abrir_conexion.php");

                    $sql = "SELECT * FROM $tablaEgresos WHERE (fecha BETWEEN '$fechI' AND '$fechF') AND (id_usr = '$idusr')";
                    $resultado = mysqli_query($conexion, $sql) or die(mysql_error());
                    $libros = array();
                    while ($rows = mysqli_fetch_assoc($resultado)) {
                        $libros[] = $rows;
                    }
                    include("cerrar_conexion.php");
                ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Valor</th>
                                    <th>Detalle</th>
                                    <th>Observación</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($libros as $libro) { ?>
                                    <tr>
                                        <td><?php echo $libro['monto']; ?></td>
                                        <td><?php echo $libro['detalle_e']; ?></td>
                                        <td><?php echo $libro['detalles']; ?></td>
                                        <td><?php echo $libro['fecha']; ?></td>
                                        <td>
                                            <button class="btn btn-primary" onclick="btnUpdateE('<?php echo $libro['id_eg']; ?>', '<?php echo $libro['detalle_e']; ?>', '<?php echo $libro['detalles']; ?>', '<?php echo $libro['fecha']; ?>')" data-toggle="modal" data-target="#modale"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                                </svg></button>
                                            <button class="btn btn-danger" onclick="btnDeleteE('<?php echo $libro['id_eg']; ?>', '<?php echo $libro['monto']; ?>')" data-toggle="modal" data-target="#modaleD"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                </svg></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <!-- Modal  Actualizar -->
                        <div class="modal fade" id="modale" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Actualizar</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="act.php" method="post">
                                            <p>Aquí puedes editar los detalles, si ingresaste un valor equivocado debes elimiar el registro.</p>
                                            <input class="form-control" type="hidden" name="id" id="ideg">
                                            <label>Fuente</label>
                                            <select class="form-control" type="text" name="fuente" id="detalle_e">
                                                <option value="Hogar">Hogar</option>
                                                <option value="Alimentación">Alimentación</option>
                                                <option value="Vestuario">Vestuario</option>
                                                <option value="Estudio">Estudio</option>
                                                <option value="Inversión">Inversión</option>
                                                <option value="Prestamos">Prestamos</option>
                                                <option value="Otro">Otro</option>
                                            </select>
                                            <label>Detalles</label>
                                            <input class="form-control" type="text" name="detalles" id="detalles">
                                            <label>Fecha</label>
                                            <input class="form-control" type="date" name="fecha" id="fechaEg">
                                            <input class="form-control btn-outline-success" type="submit" name="btnAe" value="Actualizar">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal  Eliminar -->
                        <div class="modal fade" id="modaleD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="act.php" method="post">
                                            <label>Al eliminar restableceremos el valor que se descontó anteriormente.</label>
                                            <input class="form-control" type="hidden" name="ide" id="idEliminar" readonly>
                                            <input class="form-control" type="text" name="valor" id="valorEg" readonly>
                                            <input class="form-control btn-outline-danger" type="submit" name="btnEe" value="Eliminar">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            function btnUpdateE(ideg, dos, tres, cuatro) {
                                document.getElementById('ideg').value = ideg;
                                document.getElementById('detalle_e').value = dos;
                                document.getElementById('detalles').value = tres;
                                document.getElementById('fechaEg').value = cuatro;
                            }

                            function btnDeleteE(id, valor) {
                                document.getElementById('idEliminar').value = id;
                                document.getElementById('valorEg').value = valor;
                            }
                        </script>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <br />

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>

</html>