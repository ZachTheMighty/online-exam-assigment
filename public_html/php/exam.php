<!DOCTYPE html>
<html>
<body>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/reset.css">
<link rel="stylesheet" href="../css/question.css">
<link rel="stylesheet" href="../css/teacher.css">
<style>
main
{
  align-items: stretch;
}

a
{
    text-align: center;
}
</style>
</head>
<body>

<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "klux";
$password = "123";
$dbname = "mydb";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$num_of_questions = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM examQuestions"));

if (!isset($_POST['next'])) {
  $_SESSION['questionID'] = 0;
  $_SESSION['grade'] = 0;
}

else {
  $currentID = $_SESSION['questionID'];
  $checkSql = "SELECT answer FROM examQuestions LIMIT 1 OFFSET {$_SESSION['questionID']}";
  $checkResult = mysqli_query($conn, $checkSql);
  $checkRow = mysqli_fetch_assoc($checkResult);

  if (isset($_POST['option']) && $checkRow && $_POST['option'] === $checkRow['answer']) {
    $_SESSION['grade']++;
  }
  $_SESSION['questionID']++;
}


if ($_SESSION['questionID'] >= $num_of_questions) {
  $sql = "UPDATE studentList SET Grade = {$_SESSION['grade']}
          WHERE Username = '{$_SESSION['username']}'
  ";
  mysqli_query($conn, $sql);

  echo "<main><h2>Your final result is: " . $_SESSION['grade'] . " / $num_of_questions</h2>
  <a href=http://localhost>Sign out</a>
  </main>";
  exit;
}

$id = $_SESSION['questionID'];
$sql = "SELECT * FROM examQuestions LIMIT 1 OFFSET {$_SESSION['questionID']}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);


if ($row) {
  $q = $row['question'];
  $c1 = $row['first_choice'];
  $c2 = $row['second_choice'];
  $c3 = $row['third_choice'];
  $answer = $row['answer'];
}

?>
    <main>
    <header>
      <h2><?php echo $id + 1 . " / ". $num_of_questions?></h2>
    </header>
      <h2><?php echo $q ?></h2>

      <form action="exam.php" method="post">
        <label
          ><input type="radio" name="option" autocomplete="off" value="<?php echo $c1?>" required/>
          <?php echo $c1?>
        </label>

        <label
          ><input type="radio" name="option" autocomplete="off" value="<?php echo $c2?>" required/>
          <?php echo $c2?>
        </label>

        <label
          ><input type="radio" name="option" autocomplete="off" value="<?php echo $c3?>" required/>
          <?php echo $c3?>
        </label>

        <label>
          <input type="submit" name="next" value="Next" />
        </label>
      </form>
    </main>
  </body>

</html>
