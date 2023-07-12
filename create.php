<?php
  include 'connect.php';

  if(!isset($_COOKIE['username']) && !isset($_COOKIE['id'])) {
    header('Location: '.'http://localhost/notes_app/login.php');
    die();
  }

  if (isset($_COOKIE['username']) && isset($_COOKIE['id'])
    && $_SERVER['REQUEST_METHOD'] == 'POST'
    && $_POST['title'] != '' && $_POST['content'] != '') {

    $user_id = $_COOKIE['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = 'INSERT INTO notes (title, content, user_id) VALUES(?, ?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $title, $content, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
      header('Location: '.'http://localhost/notes_app/notes.php');
      die();
    } else {
      echo "Error inserting record: ".$conn->error;
    }

    $stmt->close();
    $conn->close();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create New Note</title>
  <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
  <div class="container">
    <form action="./notes.php" class="create-note">
      <div class="form-row submit-btn">
        <div class="input-data">
          <div class="inner"></div>
          <input type="submit" value="Back to notes list">
        </div>
      </div>
    </form>

    <h2 class="text">Create New Note</h2>

    <form action="" method="POST">
      <div class="form-row">
        <div class="input-data">
          <input type="text" id="title" name="title">
          <div class="underline"></div>
          <label for="title">Title:</label>
        </div>
      </div>
      <div class="form-row">
        <div class="input-data textarea">
          <textarea name="content" id="content" cols="30" rows="10"></textarea>
          <br>
          <div class="underline"></div>
          <label for="content">Content:</label>
          <br>
        </div>
      </div>
      <div class="form-row submit-btn">
        <div class="input-data">
          <div class="inner"></div>
          <input type="submit" value="Create new note">
        </div>
      </div>
    </form>
  </div>
</body>
</html>