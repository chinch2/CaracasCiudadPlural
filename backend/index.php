<!DOCTYPE HTML>
<html>
<?php

session_start();
if ($_SESSION['Usuario']) {
	session_destroy();
}

?>

<head>
	<title>Caracas Ciudad Plural</title>
</head>

<body>

	<h1>Bienvenido al Servidor Web de Caracas Ciudad Plural</h1> <br>
	<!-- botones login	<a href="login.php">Iniciar Sesion</a><br><br>
	<a href="logout.php">Cerrar Sesion</a><br><br> -->
	<a href="tablas.php">Editar Tablas</a>

	<?php
	include("conn.php");
	?>
	<h2>Tabla de Noticias</h2>
	<table border="1">
		<tr>
			<th>Imagen</th>
			<th>Titulo</th>
			<th>Link</th>
			<th>Fecha De Publicacion</th>
		</tr>
		<?php
		$sql = "SELECT * FROM sistema.news";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo "<tr><td>{$row["image"]}</td><td>{$row["title"]}</td><td>{$row["link"]}</td><td>{$row["publish_date"]}</td></tr>";
			}
		} else {
			echo "0 results <br><br>";
		}

		echo "</table><br><br>";
		?>
		<h2>Tabla de Audios</h2>
		<table border="1">
			<tr>
				<th>Link</th>
				<th>Parte</th>
				<th>Fecha De Publicacion</th>
			</tr>
			<?php
			$sql = "SELECT * FROM sistema.audios";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					echo "<tr><td>{$row["link"]}</td><td>{$row["part"]}</td><td>{$row["datetime"]}</td></tr>";
				}
			} else {
				echo "0 results <br><br>";
			}

			echo "</table><br><br>";
			?>
			<h2>Tabla de Flyers</h2>
			<table border="1">
				<tr>
					<th>Imagen</th>
					<th>Fecha De Publicacion</th>
				</tr>
				<?php
				$sql = "SELECT * FROM sistema.flyers";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						echo "<tr><td>{$row["image"]}</td><td>{$row["datetime"]}</td></tr>";
					}
				} else {
					echo "0 results <br><br>";
				}

				echo "</table><br><br>";

				$conn->close();
				?>

				<?php

				/*	if ($_SESSION['Access'] == 1) {

		echo "<a href=\"tabla4.php\">Users</a>";
	}*/

				?>
</body>

</html>