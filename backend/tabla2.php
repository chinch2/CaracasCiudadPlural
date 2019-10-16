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
  Tabla de Audios
  <?php
  include("conn.php");

  if (isset($_GET["del"])) {

    $sql = "DELETE FROM sistema.audios WHERE id = '" . $_GET["id"] . "';";

    if ($conn->query($sql) === TRUE) {

      $last_id = $conn->insert_id;

      $_GET["id"] = $last_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    unset($_GET["del"]);
  }

  if (isset($_GET["insert"])) {

    $sql = "INSERT INTO audios (link, part) VALUES ('link', 'part');";

    if ($conn->query($sql) === TRUE) {

      $last_id = $conn->insert_id;

      $_GET["id"] = $last_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  if (isset($_POST["forma"])) {
    $sql = "UPDATE sistema.audios SET  link = '{$_POST["link"]}', part = '{$_POST["part"]}' WHERE id = '{$_POST["id"]}';";
    $result = $conn->query($sql);
    unset($_GET["id"]);
  }
  ?>
  <a href="tablas.php">Volver</a>
  <table border="1">
    <tr>
      <th>Link de audio</th>
      <th>Parte</th>
      <th>Fecha de Publicacion</th>
    </tr>
    <?php
    $sql = "SELECT * FROM sistema.audios";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row["link"]}</td><td>{$row["part"]}</td><td>{$row["datetime"]}</td>";
        if ($_SESSION['Access'] == 1) {
          echo "<td><a href=\"tabla2.php?id={$row["id"]}\">Modificar</a></td><td><a href=\"tabla2.php?id={$row["id"]}&del=1\">Eliminar</a></td></tr>";
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
      echo '<form action= "tabla2.php" method="post">
  Link de audio:<br>
  <input type="text" name="link" value="' . $campo["link"] . '">
  <br>
  Parte:<br>
  <input type="text" name="part" value="' . $campo["part"] . '">
  <br>
  <input type="hidden" name="id" value="' . $campo["id"] . '">
  <input type="submit" name="forma" value="Submit">
 </form>';
    }
    if (!isset($_GET["insert"]) && $_SESSION['Access'] == 1) {

      echo '<a href="tabla2.php?insert=1">Ingresar nuevo registro</a>';
    }


    $conn->close();
    ?>

  </table>
</body>

</html>