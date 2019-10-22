<?php
$servername = "127.0.0.1";
$username = "josedev";
$password = "J.2574274.j";
$dbname = "sistemaCCP";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
