<?php
include("../includes/db.php");
include("../includes/navbar.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Klán keresése
$user_clan = $conn->query("SELECT clans.id, clans.clan_name, clans.reputation, clan_members.role 
                           FROM clan_members 
                           JOIN clans ON clan_members.clan_id = clans.id 
                           WHERE clan_members.user_id = $user_id")->fetch_assoc();

// Ha nincs klánja, lehetőséget kap csatlakozni vagy létrehozni egyet
if (!$user_clan) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["clan_name"])) {
        $clan_name = $_POST["clan_name"];
        $conn->query("INSERT INTO clans (clan_name, leader_id) VALUES ('$clan_name', $user_id)");
        $clan_id = $conn->insert_id;
        $conn->query("INSERT INTO clan_members (user_id, clan_id, role) VALUES ($user_id, $clan_id, 'Leader')");
        echo "<p class='success'>✅ Klán létrehozva: $clan_name</p>";
    }
    ?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klánok</title>
    <link rel="stylesheet" href="styles.css">
</head>
    <h1>🏴 Klánok</h1>
    <p>Még nem tartozol egy klánhoz sem. Csatlakozz egyhez, vagy hozz létre egyet!</p>
    <form method="POST">
        <input type="text" name="clan_name" placeholder="Klán neve" required>
        <button type="submit">Klán létrehozása</button>
    </form>

<?php
} else {
    echo "<h1>🏴 Klánod: {$user_clan['clan_name']}</h1>";
    echo "<p>Reputáció: {$user_clan['reputation']}</p>";
    echo "<p>Szereped: {$user_clan['role']}</p>";
}
?>

