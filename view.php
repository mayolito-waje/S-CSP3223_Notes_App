<?php 
  include "connect.php";

  if(!isset($_COOKIE['username']) && !isset($_COOKIE['id'])) {
    header('Location: '.'http://localhost/notes_app/login.php');
    die();
  }

  if(isset($_GET['note_id'])) {
    $note_id = $_GET['note_id'];

    $sql_get_note = 'SELECT * FROM notes WHERE id = ?';
    $stmt = $conn->prepare($sql_get_note);
    $stmt->bind_param('s', $note_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()) {
      $note_id = $row['id'];
      $title = $row['title'];
      $content = $row['content'];
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo "$title" ?></title>
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

    

    <?php 
      if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['action'] == 'update') {
          $set_title = $_POST['title'];
          $set_content = $_POST['content'];
    
          $sql_update_note = 'UPDATE notes SET title = ?, content = ? WHERE id = ?';
          $stmt = $conn->prepare($sql_update_note);
          $stmt->bind_param('sss', $set_title, $set_content, $note_id);
          $stmt->execute();
    
          if ($stmt->affected_rows > 0) {
            header('Refresh:0');
          }

          $stmt->close();
        } elseif ($_POST['action'] == 'delete') {
          $sql_delete_note = 'DELETE FROM notes WHERE id = ?';
          $stmt = $conn->prepare($sql_delete_note);
          $stmt->bind_param('i', $note_id);
          $stmt->execute();

          if ($stmt->affected_rows > 0) {
            header('Location: '.'http://localhost/notes_app/notes.php');
            die();
          }

          $stmt->close();
        }
      }

      echo "
        <h2 class='text' style='padding: 10px'>$title</h2>

        <form action='' method='POST'>
          <input type='hidden' name='action' value='update'>
          <div class='form-row'>
            <div class='input-data'>
              <input type='text' id='title' name='title' value='$title'>
              <div class='underline'></div>
              <label for='title'>Title:</label> 
            </div>
          </div>
          <div class='form-row'>
            <div class='input-data textarea'>
              <textarea name='content' id='content' cols='30' rows='10'>$content</textarea>
              <br>
              <div class='underline'></div>
              <label for='content'>Content:</label>
              <br>
            </div>
          </div>
          <div class='form-row submit-btn'>
            <div class='input-data'>
              <div class='inner'></div>
              <input type='submit' value='Update note'>
            </div>
          </div>
        </form>

        <form action='' method='POST' class='create-note'>
          <input type='hidden' name='action' value='delete'>
          <div class='form-row submit-btn'>
            <div class='input-data'>
              <div class='inner'></div>
              <input type='submit' value='Delete note'>
            </div>
          </div>
        </form>
      "
    ?>
  </div>
</body>
</html>

<?php 
  $conn->close();
?>