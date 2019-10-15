<!DOCTYPE HTML>
<?php

session_start();
if (@!$_SESSION['Usuario']) {
  header("location:login.php");
}
if ($_SESSION['Usuario'] != 'admin') {
  header("Location:logout.php");
}

?>

<!DOCTYPE HTML>
<html>

<head>
  <title>Desarrollos PNP | Dash Text</title>
</head>

<body>
  Tabla de usuarios
  <?php
  include("conn.php");

  if (isset($_GET["del"])) {

    $sql = "DELETE FROM sistema.users WHERE id = '" . $_GET["id"] . "';";

    if ($conn->query($sql) === TRUE) {

      $last_id = $conn->insert_id;

      $_GET["id"] = $last_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    unset($_GET["del"]);
  }

  if (isset($_GET["insert"])) {

    $sql = "INSERT INTO users (user, password, access_level) VALUES ('supervisor', '240295', 0);";

    if ($conn->query($sql) === TRUE) {

      $last_id = $conn->insert_id;

      $_GET["id"] = $last_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  if (isset($_POST["forma"])) {
    $sql = "UPDATE sistema.users SET user = '{$_POST["user"]}', password = '{$_POST["password"]}', access_level = '{$_POST["access_level"]}' WHERE id = '{$_POST["id"]}';";
    if ($conn->query($sql) === TRUE) {
      unset($_GET["id"]);
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  ?>
  <a href="index.php">Inicio</a>
  <table border="1">
    <tr>
      <th>Usuario</th>
      <th>Clave</th>
      <th>Nivel de acceso</th>
    </tr>
    <?php
    $sql = "SELECT * FROM sistema.users";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row["user"]}</td><td>{$row["password"]}</td><td>{$row["access_level"]}</td>";
        if ($_SESSION['Access'] == 1) {
          echo "<td><a href=\"tabla4.php?id={$row["id"]}\">Modificar</a></td><td><a href=\"tabla4.php?id={$row["id"]}&del=1\">Eliminar</a></td></tr>";
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
      echo '<form action= "tabla4.php" method="post">
 Usuario:<br>
  <input type="text" name="user" value="' . $campo["user"] . '">
  <br>
  <input type="hidden" name="id" value="' . $campo["id"] . '">
  Clave:<br>
  <input type="password" name="password" value="' . $campo["password"] . '">
  <br>
  Nivel de acceso:
  <input type="text" name="access_level" value="' . $campo["access_level"] . '">
  <br>
  <input type="submit" name="forma" value="Submit">
 </form>';
    }
    if (!isset($_GET["insert"]) && $_SESSION['Access'] == 1) {

      echo '<a href="tabla4.php?insert=1">Ingresar nuevo registro</a>';
    }


    $conn->close();
    ?>

  </table>
</body>

</html>