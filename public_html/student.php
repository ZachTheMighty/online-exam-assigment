<!DOCTYPE html>
<html>
<body>

<h1>My first PHP page</h1>

<?php
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
echo "Connected successfully<br>";

// sql to create table

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $htmlName = $_SERVER['HTTP_REFERER'];

    if(preg_match("/add_student/", $htmlName))
    {
        $name = $_POST['name'];
        $id = $_POST['id'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $grade = $_POST['grade'];

        $sql = "INSERT INTO studentList (Name , ID, Username,
        Password, Grade)
        VALUES ('$name', '$id', '$username', '$password', '$grade')";

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


}



?>

</body>
</html>

