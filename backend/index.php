<!DOCTYPE HTML>
<?php
/*
session_start();
if(@!$_SESSION['Usuario']){
	header("Location:login.php");
}
*/
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>Caracas Ciudad Plural</title>
</head>

<body>

	Bienvenido al Servidor Web de Caracas Ciudad Plural <br>
	<a href="login.php">Iniciar Sesion</a><br><br>
	<a href="logout.php">Cerrar Sesion</a><br><br>

	<?php
	include("conn.php");

	$sql = "SELECT salio FROM tickets WHERE salio = 0;";

	$result = $conn->query($sql);

	$carrosdentro = $result->num_rows;

	echo  "Carros adentro: $carrosdentro<br>";

	$conn->close();
	?>

	<a href="tabla1.php">Feed</a>
	<a href="tabla2.php">Equipos</a>
	<a href="tabla3.php">Tarifas</a>
	<a href="tabla4.php">Transacciones</a>
	<a href="tabla6.php">Puestos fijos</a>


	<?php

	if ($_SESSION['Access'] == 1) {

		echo "<a href=\"tabla5.php\">Usuarios</a>";
	}

	?>
</body>

</html>