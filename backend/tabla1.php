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
  <style type="text/css">
    #content {
      width: 50%;
      margin: 20px auto;
      border: 1px solid #cbcbcb;
    }

    form {
      width: 50%;
      margin: 20px auto;
    }

    form div {
      margin-top: 5px;
    }

    #img_div {
      width: 80%;
      padding: 5px;
      margin: 15px auto;
      border: 1px solid #cbcbcb;
    }

    #img_div:after {
      content: "";
      display: block;
      clear: both;
    }

    img {
      float: left;
      margin: 5px;
      width: 300px;
      height: 140px;
    }
  </style>
</head>

<body>
  Tabla de Noticias
  <?php
  include("conn.php");

  // Initialize message variable
  $msg = "";

  // If upload button is clicked ... 
  if (isset($_POST['upload'])) {
    // Get image name
    $image = $_FILES['image']['name'];
    // Get text
    $image_text = mysqli_real_scape_string($conn, $_POST['image_text']);

    // image file directory
    $target = "images/" . basename($image);

    $sql = "INSERT INTO news (image, image_text, title, link) VALUES('$image', '$image_text', 'Titulo de Noticia', 'Link de noticia')";
    // execute query
    if ($conn->query($sql) === TRUE) {

      $last_id = $conn->insert_id;

      $_GET["id"] = $last_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
      $msg = "Image uploaded successfully";
    } else {
      $msg = "Failed to upload image";
    }
  }

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

  /*if (isset($_GET["insert"])) {

    $sql = "INSERT INTO news (title, link) VALUES ('Titulo de Noticia', 'Link de noticia')";

    if ($conn->query($sql) === TRUE) {

      $last_id = $conn->insert_id;

      $_GET["id"] = $last_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }*/

  if (isset($_POST["forma"])) {
    $sql = "UPDATE sistema.news SET  title = '{$_POST["title"]}', link = '{$_POST["link"]}' WHERE id = '{$_POST["id"]}'";
    $result = $conn->query($sql);
    unset($_GET["id"]);
  }
  ?>
  <a href="index.php">Inicio</a>
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
        echo "<tr><td><div id='img_div'><img src='images/" . $row['image'] . "'><p>" . $row['image_text'] . "</p></div></td><td>{$row["title"]}</td><td>{$row["link"]}</td><td>{$row["publish_date"]}</td>";
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
  <input type="hidden" name="size" value="1000000">
  <div>
  <input type="file" name"image">
  </div>
  <div>
  <textarea id="text" cols="40" rows="4" name"image_text" placeholder="Say Something about this image..."></textarea>
  </div>
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

      echo '<a href="tabla1.php?upload=1">Ingresar nuevo registro</a>';
    }


    $conn->close();
    ?>

  </table>
</body>

</html>