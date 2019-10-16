<!DOCTYPE HTML>
<?php

session_start();
if (@!$_SESSION['Usuario']) {
  header("location:login.php");
}

?>

<!DOCTYPE HTML>
<html>

<head>
  <title>Caracas Ciudad Plural</title>
</head>

<body>
  Tabla del Flyers
  <?php
  include("conn.php");

  if (isset($_GET["del"])) {

    $sql = "DELETE FROM sistema.flyers WHERE id = '" . $_GET["id"] . "';";

    if ($conn->query($sql) === TRUE) {

      $last_id = $conn->insert_id;

      $_GET["id"] = $last_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    unset($_GET["del"]);
  }

  if (isset($_GET["insert"])) {

    $sql = "INSERT INTO flyers (image) VALUES ('imagen');";

    if ($conn->query($sql) === TRUE) {

      $last_id = $conn->insert_id;

      $_GET["id"] = $last_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  if (isset($_POST["forma"])) {
    $sql = "UPDATE sistema.flyers SET  image = '{$_POST["image"]}' WHERE id = '{$_POST["id"]}';";
    $result = $conn->query($sql);
    unset($_GET["id"]);
  }
  ?>
  <a href="tablas.php">Volver</a>
  <table border="1">
    <tr>
      <th>Imagen</th>
      <th>Fecha de Publicacion</th>
    </tr>
    <?php
    $sql = "SELECT * FROM sistema.flyers";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row["image"]}</td><td>{$row["datetime"]}</td>";
        if ($_SESSION['Access'] == 1) {
          echo "<td><a href=\"tabla3.php?id={$row["id"]}\">Modificar</a></td><td><a href=\"tabla3.php?id={$row["id"]}&del=1\">Eliminar</a></td></tr>";
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
      echo '<form action= "tabla3.php" method="post">
  Imagen:<br>
  <input type="text" name="image" value="' . $campo["image"] . '">
  <br>
  <input type="hidden" name="id" value="' . $campo["id"] . '">
  <input type="submit" name="forma" value="Submit">
 </form>';
    }
    if (!isset($_GET["insert"]) && $_SESSION['Access'] == 1) {

      echo '<a href="tabla3.php?insert=1">Ingresar nuevo registro</a>';
    }


    $conn->close();
    ?>

  </table>
</body>

</html>