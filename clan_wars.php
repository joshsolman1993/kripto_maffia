<?php
include("../includes/db.php");
include("../includes/navbar.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$clan = $conn->query("SELECT clan_id, role FROM clan_members WHERE user_id = $user_id")->fetch_assoc();

if (!$clan || $clan["role"] !== "Leader") {
    echo "<p class='error'>❌ Csak klánvezetők indíthatnak háborút!</p>";
    exit();
}

$clan_id = $clan["clan_id"];
$opponent_clans = $conn->query("SELECT id, clan_name FROM clans WHERE id != $clan_id");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["target_clan"])) {
    $target_clan = $_POST["target_clan"];
    $success = rand(1, 100) < 60; // 60% esély a sikerre
    $reputation_change = $success ? 10 : -5;

    if ($success) {
        $conn->query("UPDATE clans SET reputation = reputation + $reputation_change WHERE id = $clan_id");
        $conn->query("UPDATE clans SET reputation = reputation - $reputation_change WHERE id = $target_clan");
        $conn->query("INSERT INTO clan_wars (attacking_clan_id, defending_clan_id, result, reputation_change) VALUES ($clan_id, $target_clan, 'Win', $reputation_change)");
        echo "<p class='success'>🔥 Sikeres támadás! Klánod reputációja nőtt (+$reputation_change)</p>";
    } else {
        $conn->query("INSERT INTO clan_wars (attacking_clan_id, defending_clan_id, result, reputation_change) VALUES ($clan_id, $target_clan, 'Lose', $reputation_change)");
        echo "<p class='error'>💀 A támadás sikertelen volt! Klánod reputációja csökkent ($reputation_change)</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klánháborúk</title>
    <link rel="stylesheet" href="styles.css">
</head>
<h1>⚔️ Klánháborúk</h1>
<form method="POST">
    <select name="target_clan">
        <?php while ($clan = $opponent_clans->fetch_assoc()): ?>
            <option value="<?= $clan["id"] ?>"><?= $clan["clan_name"] ?></option>
        <?php endwhile; ?>
    </select>
    <button type="submit">Támadás!</button>
</form>
