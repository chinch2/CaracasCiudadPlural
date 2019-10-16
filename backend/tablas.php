<!DOCTYPE HTML>
<html>
<?php

session_start();
if (@!$_SESSION['Usuario']) {
    header("location:login.php");
}

?>

<a href="tabla1.php">News</a>
<a href="tabla2.php">Audios</a>
<a href="tabla3.php">Flyers</a>
<br>
<br>
<br>
<a href="index.php">Salir</a>