<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kripto_maffia";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("❌ Adatbázis kapcsolódási hiba: " . $conn->connect_error);
}
?>
