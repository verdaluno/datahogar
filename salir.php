
<?php
	session_start();
	ob_start();

	$_SESSION['correcto']=4;//error 4 cerro sesion exitosamente
	header('Location:login.php');
?>