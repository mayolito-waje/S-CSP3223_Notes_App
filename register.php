<?php 
  include "connect.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $insert = 'INSERT INTO users (username, password) VALUES (?, ?)';
    $stmt = $conn->prepare($insert);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    if($stmt->affected_rows > 0) {
      $get_user = 'SELECT * FROM users ORDER BY id DESC LIMIT 1';
      $fetched = mysqli_query($conn, $get_user);

      while($row = mysqli_fetch_assoc($fetched)) {
        setcookie('username', $row['username'], time() + 86400);
        setcookie('id', $row['id'], time() + 86400);
      }

      header('Location: '.'http://localhost/notes_app/notes.php');
      die();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
  <form class="container" action="" method="POST">
    <fieldset>
      <legend class="text">Register to Notes App</legend>
      <div class="form-row">
        <div class="input-data">
          <input type="text" id="username" name="username" required>
          <div class="underline"></div>
          <label for="username">Username:</label>
        </div>
      </div><br>
      <div class="form-row">
        <div class="input-data">
          <input type="password" id="password" name="password" required>
          <div class="underline"></div>
          <label for="password">Password:</label>
        </div>
      </div><br>
      <div class="form-row submit-btn">
        <div class="input-data">
          <div class="inner"></div>
          <input type="submit" value="Register">
        </div>
      </div>
      <br><br>
      <a href="http://localhost/notes_app/login.php">Go to login page.</a>
    </fieldset>
  </form>
</body>
</html>