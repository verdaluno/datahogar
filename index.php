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
    <div class="container">
        <div class="row">
            <div class="col-md-3">

            </div>
            <div class="col-md-6 login">
                <img src="img/data.png"/>
                <p>Con <b>DataHogar</b>, podrás tener el control de tus cuentas. Ingresos y gastos para que siempre puedas mantener tranquilidad.</p>
					<?php
					session_start();
					ob_start();
					
					if(isset($_SESSION['correcto'])){
						if($_SESSION['correcto']==2){
                            echo "<p class=\"p-3 mb-2 bg-danger\"><b>";
                            echo "Los campos son obligatorios";
                            echo "</b><p>";
						}
						if($_SESSION['correcto']==3){
							echo "<p class=\"p-3 mb-2 bg-danger\"><b>";
                            echo "!Datos incorrectos!";
                            echo "</b><p>";
						}
					} else {
						$_SESSION['correcto']=0;
					}
					?>
                <form action="dashboard.php" method="post">
                    <input class="form-control" type="email" name="mail" placeholder="Correo">
                    <input class="form-control" type="password" name="pass" placeholder="Clave">
                    <input class="form-control btn-outline-success" type="submit" name="btnIni" value="Ingresar">
                </form>
                <p><a href="registro.php">¡Crea una Cuenta!</a></p>
            </div>
            <div class="col-md-3">

            </div>
        </div>
    </div>
</body>
</html>
