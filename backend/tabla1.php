<!DOCTYPE HTML>
<html>
<?php

session_start();
if (@!$_SESSION['Usuario']) {
  header("location:login.php");
}

?>


<head>
  <title>Caracas Ciudad Plural</title>
</head>

<body>
  Tabla de Noticias
  <?php
  include("conn.php");

  if (isset($_GET["del"])) {

    $sql = "DELETE FROM sistema.news WHERE id = '" . $_GET["id"] . "';";

    if ($conn->query($sql) === TRUE) {

      $last_id = $conn->insert_id;

      $_GET["id"] = $last_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    unset($_GET["del"]);
  }

  if (isset($_GET["insert"])) {

    $sql = "INSERT INTO news (image, title, link) VALUES ('Imagen', 'Titulo de Noticia', 'Link de noticia')";

    if ($conn->query($sql) === TRUE) {

      $last_id = $conn->insert_id;

      $_GET["id"] = $last_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  if (isset($_POST["forma"])) {
    $sql = "UPDATE sistema.news SET   image = '{$_POST["image"]}', title = '{$_POST["title"]}', link = '{$_POST["link"]}' WHERE id = '{$_POST["id"]}'";
    $result = $conn->query($sql);
    unset($_GET["id"]);
  }
  ?>
  <a href="tablas.php">Volver</a>
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
        echo "<tr><td>{$row["image"]}</td><td>{$row["title"]}</td><td>{$row["link"]}</td><td>{$row["publish_date"]}</td>";
        if ($_SESSION['Access'] == 1) {
          echo "<td><a href=\"tabla1.php?id={$row["id"]}\">Modificar</a></td><td><a href=\"tabla1.php?id={$row["id"]}&del=1\">Eliminar</a></td></tr>";
        } else {
          echo "</tr>";
        }

        if ($_GET["id"] == $row["id"]) {
          $campo = $row;
        }
      }
    } else {
      echo "0 results <br><br>";
    }

    echo "</table><br><br>";

    if (count($campo)) {
      echo '<form action= "tabla1.php" method="post">
  Imagen:<br>
  <input type="text" name="image" value="' . $campo["image"] . '">
  <br>
  Titulo:<br>
  <input type="text" name="title" value="' . $campo["title"] . '">
  <br>
  <input type="hidden" name="id" value="' . $campo["id"] . '">
  Link:<br>
  <input type="text" name="link" value="' . $campo["link"] . '">
  <br>
  <input type="submit" name="forma" value="Submit">
 </form>';
    }
    if (!isset($_GET["upload"]) && $_SESSION['Access'] == 1) {

      echo '<a href="tabla1.php?insert=1&forma=1">Ingresar nuevo registro</a>';
    }


    $conn->close();
    ?>

  </table>
</body>

</html>