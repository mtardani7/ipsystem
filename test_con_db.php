<?php
$servername = "172.18.0.3";
$username = "ipsystem";
$password = "Firew411+";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
