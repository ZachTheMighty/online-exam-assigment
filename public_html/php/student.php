<!DOCTYPE html>
<html>
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
echo "Connected successfully to the database<br>";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $htmlName = $_SERVER['HTTP_REFERER'];

    if($htmlName == "http://localhost/")
    {
        $username = $_POST['username'];
        $_SESSION['username'] = $username;

        $sql = "SELECT * FROM studentList WHERE Username='$username'";
        $result = mysqli_query($conn, $sql);
        $num_of_rows = mysqli_num_rows($result);

        if($num_of_rows == 0)
        {
            echo "Can't sign you in, as the student
            with username '$username' couldn't be found in our database";
            exit;
        }

        else
        {
            $sql = "SELECT Password FROM studentList WHERE
                Username='$username'
            ";
            $result = mysqli_query($conn, $sql);
          $password = mysqli_fetch_assoc($result)['Password'];

          if($_POST['password'] == $password)
            header("Location: exam.php");
            else echo "The password you entered was incorrect";
        }
    }

    if(preg_match("/add_student/", $htmlName))
    {
        $name = $_POST['name'];
        $id = $_POST['id'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "INSERT INTO studentList (Name , ID, Username,
        Password)
        VALUES ('$name', '$id', '$username', '$password')";

        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully\n";
        } else
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    if(preg_match("/remove_student/", $htmlName))
    {
        $id = $_POST['id'];

        $sql = "SELECT * FROM studentList WHERE ID=$id";
        $result = mysqli_query($conn, $sql);
        $num_of_rows = mysqli_num_rows($result);

        if($num_of_rows == 0)
        {
            echo "Could not find student with a corresponding id of $id";
            exit;
        }

        $sql = "DELETE FROM studentList WHERE ID=$id";


        if (mysqli_query($conn, $sql)) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    }

    if(preg_match("/add_question/", $htmlName))
    {
        $question = $_POST['question'];
        $c1 = $_POST['c1'];
        $c2 = $_POST['c2'];
        $c3 = $_POST['c3'];
        $answer = $_POST['answer'];

        $sql = "INSERT INTO examQuestions (question,
        first_choice, second_choice, third_choice,
        answer) VALUES('$question', '$c1', '$c2', '$c3',
        '$answer')";

        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully\n";
        } else
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    if(preg_match("/remove_question/", $htmlName))
    {
        $question = $_POST['question'];


        $sql = "SELECT * FROM examQuestions WHERE question='$question'";

        $result = mysqli_query($conn, $sql);
        $num_of_rows = mysqli_num_rows($result);

        if($num_of_rows == 0)
        {
            echo "Could not find question: $question";
            exit;
        }

        $sql = "DELETE FROM examQuestions WHERE question='$question'";

        if (mysqli_query($conn, $sql)) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }

    }
}
?>
</body>
</html>

