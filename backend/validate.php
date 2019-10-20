<?php

session_start();

require("conn.php");

$username = $_POST['user'];
$pass = $_POST['pass'];

	$sql = "SELECT * FROM users WHERE user='$username'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			if ($pass == $row['password']) {
				$_SESSION['ID'] = $row['id'];
				$_SESSION['Usuario'] = $row['user'];
				$_SESSION['Access'] = $row['access_level'];
				echo '<script>alert("BIENVENIDO")</script> ';
				echo "<script>location.href='tablas.php'</script>";
			} else {
				echo '<script>alert("Los Datos ingresados no son los correctos")</script> ';
				echo "<script>location.href='login.php'</script>";
			}
		}
	}
