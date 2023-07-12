<?php
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout']) && $_POST['logout'] == 'true') {
    setcookie('username', '', time() - 3600);
    setcookie('id', '', time() - 3600);

    header('Location: '.'http://localhost/notes_app/login.php');
    die();
  }

  if(!isset($_COOKIE['username']) && !isset($_COOKIE['id'])) {
    header('Location: '.'http://localhost/notes_app/login.php');
    die();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notes</title>
  <link rel="stylesheet" href="./styles/style.css">
</head>
<body class="notes">
  <div class="container">
    <h1 class="text">Notes App</h1>
    <form action="" method="POST">
      <input type="hidden" name="logout" value="true">
      <div class="form-row submit-btn">
        <div class="input-data">
          <div class="inner"></div>
          <input type="submit" value="logout">
        </div>
      </div>
    </form>
    <form action="./create.php" class="create-note">
      <div class="form-row submit-btn">
        <div class="input-data">
          <div class="inner"></div>
          <input type="submit" value="Create a new note">
        </div>
      </div>
    </form>

    <h2 class="text">Created notes:</h2>
    <?php
      include "connect.php";

      if (isset($_COOKIE['id'])) {
        $user_id = $_COOKIE['id'];

        $sql = 'SELECT * FROM notes WHERE user_id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $user_id);
        $stmt->execute();
        
        $retrieved_notes = $stmt->get_result();
        while($row = $retrieved_notes->fetch_assoc()) {
          $note_title = $row['title'];
          $note_id = $row['id'];

          echo "
            <form action='./view.php' method='GET' class='view-note'>
              <input type='hidden' name='note_id' value='{$note_id}'>
              <h3>{$note_title}</h3>
              <input type='submit' value='view note'>
            </form>
          ";
        }

        $stmt->close();
        $conn->close();
      }
    ?>
  </div>
</body>
</html>