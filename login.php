<?php 
  include "connect.php";

  if (isset($_COOKIE['username']) && isset($_COOKIE['id'])) {
    header('Location: '.'http://localhost/notes_app/notes.php');
    die();
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = 'SELECT * FROM users WHERE username = ? AND password = ?';
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1) {
      while($row = mysqli_fetch_assoc($result)) {
        setcookie('username', $row['username'], time() + 86400);
        setcookie('id', $row['id'], time() + 86400);
      }

      header('Location: '.'http://localhost/notes_app/notes.php');
      die();
    } else {
      echo "<div class=\"notif\">Invalid username or password. Please try again.</div>";
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
  <title>Login</title>
  <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
  <form class="container" action="" method="POST">
    <fieldset>
      <div class="text">Login to Notes App</div>
      <div class="form-row">
        <div class="input-data">
          <input type="text" id="username" name="username" required>
          <div class="underline"></div>
          <label for="username">Username:</label>
        </div><br>
      </div>
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
          <input type="submit" value="Login">
        </div>
      </div>
      <br><br>
      <a href="http://localhost/notes_app/register.php">No account? Register here.</a>
    </fieldset>
  </form>
</body>
</html>