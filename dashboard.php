<?php
include("../includes/db.php");
include("../includes/navbar.php");
include("../includes/functions.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$result = $conn->query("SELECT username, btc_balance, btc_safe, anonymity, wanted_level, level, max_heist_level, exploit_access, investigation_level FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>💻 Dark Web Dashboard</h1>

        <div class="grid-container">
            <div class="panel full-width">
                <h2>👤 Üdv, <?= $user["username"] ?>!</h2>
                <p>Ez a főhadiszállásod a dark weben.</p>
            </div>

            <div class="panel">
                <h2>💰 Bitcoin Egyenleg</h2>
                <p><?= $user["btc_balance"] ?> BTC</p>
            </div>

            <div class="panel">
                <h2>🏦 Biztonságos BTC</h2>
                <p><?= $user["btc_safe"] ?> BTC</p>
            </div>

            <div class="panel">
                <h2>🕵️ Anonimitás</h2>
                <p><?= $user["anonymity"] ?>%</p>
            </div>

            <div class="panel">
                <h2>🚔 Körözési Szint</h2>
                <p><?= $user["wanted_level"] ?>%</p>
            </div>

            <div class="panel">
                <h2>🚨 FBI Figyelmeztetés</h2>
                <p><?= fbiInvestigation($user_id, $conn) ?></p>
            </div>

            <div class="panel">
                <h2>🔍 FBI Nyomozás Szintje</h2>
                <p><?= $user["investigation_level"] ?>%</p>
            </div>

            <div class="panel">
                <h2>🎯 Szint és XP</h2>
                <p>Szinted: <?= $user["level"] ?></p>
                <p>Tapasztalati pontjaid: <?= $user["level"] * 100 ?> XP</p>
            </div>

            <div class="panel">
                <h2>🤖 Botnet Bányászat</h2>
                <p><?= botnetEarnings($user_id, $conn) ?></p>
            </div>

            <div class="panel">
                <h2>⚠️ Védelem</h2>
                <p><?= aiHackersAttack($user_id, $conn) ?></p>
            </div>
        </div>

        <div class="button-group">
            <a href="market.php" class="button">🛒 Piactér</a>
            <a href="missions.php" class="button">🎯 Küldetések</a>
            <?= ($user["max_heist_level"] >= 2) ? '<a href="heists.php" class="button">🔥 Heistek</a>' : '<a class="button disabled">🔒 Heistek (Zárva)</a>' ?>
            <?= ($user["exploit_access"] >= 1) ? '<a href="exploits.php" class="button">🔧 Exploitok</a>' : '<a class="button disabled">🔒 Exploitok (Zárva)</a>' ?>
        </div>
    </div>
</body>
</html>
