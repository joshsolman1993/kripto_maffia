<?php
include("../includes/db.php");
include("../includes/navbar.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$opponents = $conn->query("SELECT id, username, btc_balance FROM users WHERE id != $user_id ORDER BY btc_balance DESC LIMIT 5");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["target_id"])) {
    $target_id = $_POST["target_id"];
    $target = $conn->query("SELECT btc_balance FROM users WHERE id = $target_id")->fetch_assoc();

    $success = rand(1, 100) < 50; // 50% esély a sikerre

    if ($success) {
        $stolen = $target["btc_balance"] * 0.2; // 20%-ot lehet ellopni
        $conn->query("UPDATE users SET btc_balance = btc_balance - $stolen WHERE id = $target_id");
        $conn->query("UPDATE users SET btc_balance = btc_balance + $stolen WHERE id = $user_id");
        $conn->query("INSERT INTO pvp_attacks (attacker_id, defender_id, result, btc_stolen) VALUES ($user_id, $target_id, 'Win', $stolen)");
        echo "<p class='success'>✅ Sikeres támadás! Loptál $stolen BTC-t!</p>";
    } else {
        echo "<p class='error'>❌ A támadás sikertelen volt!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PVP Hacker Támadások</title>
    <link rel="stylesheet" href="styles.css">
</head>
<h1>💀 PvP Hacker Támadások</h1>
<form method="POST">
    <select name="target_id">
        <?php while ($opponent = $opponents->fetch_assoc()): ?>
            <option value="<?= $opponent["id"] ?>"><?= $opponent["username"] ?> (<?= $opponent["btc_balance"] ?> BTC)</option>
        <?php endwhile; ?>
    </select>
    <button type="submit">Támadás</button>
</form>
