<?php 
  $servername = "localhost";
  $username = "root";
  $password = "";
  $db_name = "notes_app";

  $conn = mysqli_connect($servername, $username, $password, $db_name);

  if (!$conn) {
    die("Connection Failed".mysqli_connect_error());
  }
?>