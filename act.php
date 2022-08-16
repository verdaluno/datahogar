<?php

session_start();
ob_start();

// ********************
// ACTUALIZAR INGRESOS
//*********************

if (isset($_POST['btnA'])) {

    $id = $_POST['id'];
    $fuente = $_POST['fuente'];
    $detalle_i = $_POST['detalle_i'];
    $fecha = $_POST['fecha'];

    include("abrir_conexion.php");

    $_UPDATE_SQL = "UPDATE $tablaIngresos Set
        fuente = '$fuente',
        detalle_i = '$detalle_i',
        fecha = '$fecha' WHERE id_in = '$id'";
}
mysqli_query($conexion, $_UPDATE_SQL);
include("cerrar_conexion.php");

header('Location: edita.php');

// ********************
// ELIMINAR INGRESOS
//*********************

if (isset($_POST['btnE'])) {

    $idusr = $_SESSION['idusr'];
    $id = $_POST['ide'];
    $valor = $_POST['valor'];

    include("abrir_conexion.php");
    
    // CONSULTA ÚLTIMO VALOR TOTAL
    $resultados = mysqli_query($conexion, "SELECT * FROM $tablaTotal WHERE id_usr = '$idusr' ORDER BY id_total DESC LIMIT 1");
    while ($consulta = mysqli_fetch_array($resultados)) {
        $valdos = $consulta['total'];
    }

    $resta = $valdos - $valor;

    // ACTUALIZA VALOR TOTAL EN LA VISTA
    $conexion->query("INSERT INTO $tablaTotal (id_usr,total) values('$idusr','$resta')");

    //ELIMINA REGISTRO
    $_DELETE_SQL = "DELETE FROM $tablaIngresos WHERE id_in = '$id'";
    mysqli_query($conexion, $_DELETE_SQL);
}
mysqli_query($conexion, $_UPDATE_SQL);
include("cerrar_conexion.php");


// ********************
// ACTUALIZAR EGRESOS
//*********************

if (isset($_POST['btnAe'])) {

    $id = $_POST['id'];
    $detalle_e = $_POST['fuente'];
    $detalles = $_POST['detalles'];
    $fecha = $_POST['fecha'];

    include("abrir_conexion.php");

    $_UPDATE_SQL = "UPDATE $tablaEgresos Set
        detalle_e = '$detalle_e',
        detalles = '$detalles',
        fecha = '$fecha' WHERE id_eg = '$id'";
}
mysqli_query($conexion, $_UPDATE_SQL);
include("cerrar_conexion.php");

header('Location: edita.php');

// ********************
// ELIMINAR INGRESOS
//*********************

if (isset($_POST['btnEe'])) {

    $idusr = $_SESSION['idusr'];
    $id = $_POST['ide'];
    $monto = $_POST['valor'];

    include("abrir_conexion.php");
    
    // CONSULTA ÚLTIMO VALOR TOTAL
    $resultados = mysqli_query($conexion, "SELECT * FROM $tablaTotal WHERE id_usr = '$idusr' ORDER BY id_total DESC LIMIT 1");
    while ($consulta = mysqli_fetch_array($resultados)) {
        $valdos = $consulta['total'];
    }

    $regreso = $valdos + $monto;

    // ACTUALIZA VALOR TOTAL EN LA VISTA
    $conexion->query("INSERT INTO $tablaTotal (id_usr,total) values('$idusr','$regreso')");

    //ELIMINA REGISTRO
    $_DELETE_SQL = "DELETE FROM $tablaEgresos WHERE id_eg = '$id'";
    mysqli_query($conexion, $_DELETE_SQL);
}
mysqli_query($conexion, $_UPDATE_SQL);
include("cerrar_conexion.php");
?>


 
                                      
                