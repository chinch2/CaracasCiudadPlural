<!DOCTYPE HTML>
<html>

<head>
	<title>Pagina de inicio</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
	<form id="formu" action="validate.php" method="post">
		Inicia Sesion
		<br><br> Usuario: <input type="text" id="user" name="user" value="user" onclick="if(this.value=='user') this.value=''" onblur="if(this.value=='') this.value='user'" />
		<br><br> Clave: <input type="password" id="pass" name="pass" value="password" onclick="if(this.value=='password') this.value=''" onblur="if(this.value=='') this.value='password'" />
		<br><br> <input type="submit" value="Log in"> </form>
</body>

</html>