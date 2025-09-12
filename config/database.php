<?php
$servername = "localhost";
$username = "root";
$password = "Aa@161183";
$dbname = "link";
$port = 3307;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;port=$port", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
    return $conn;
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>