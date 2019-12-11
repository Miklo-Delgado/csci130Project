<?php

$servername = "localhost"; // default server name
$username = "delgado"; // user name that you created
$password = "XcgVyWIwYg6paZFb"; // password that you created
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Creation of a table

$sql = "CREATE TABLE Games (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    playerEmail VARCHAR(100),
    dur INT(100),
    score VARCHAR(50)
    )";

if ($conn->query($sql) === TRUE) {
    echo "Table Person created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error ."<br>";
}


$sql = "INSERT INTO Games (playerEmail, dur, score) VALUES ('jMoney@anime.com', 29.223, 'jMoney@anime.com won with 12-6')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error ."<br>";
}

$sql = "SELECT * FROM Orders LIMIT 10";
?>
<p><a href="/Reversi-130">Homepage</a></p>