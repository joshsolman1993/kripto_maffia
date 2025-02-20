<?php
include("../includes/db.php");
include("../includes/navbar.php");

$top_hackers = $conn->query("
    SELECT users.username, COALESCE(leaderboard.wins, 0) AS wins, COALESCE(leaderboard.losses, 0) AS losses 
    FROM users 
    LEFT JOIN leaderboard ON users.id = leaderboard.user_id 
    ORDER BY wins DESC, losses ASC LIMIT 10
");

$top_clans = $conn->query("SELECT clan_name, reputation FROM clans ORDER BY reputation DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="hu">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Dark Web Ranglista</title>
            <link rel="stylesheet" href="styles.css"> <!-- Most már mindenhol betöltjük a CSS-t -->
        </head>
    <body>
<h1>🏆 Dark Web Ranglista</h1>

<div class="leaderboard">
    <h2>🔥 Top 10 Hackerek</h2>
    <table>
        <tr>
            <th>🏅 Helyezés</th>
            <th>💀 Hacker</th>
            <th>✅ Győzelmek</th>
            <th>❌ Vereségek</th>
        </tr>
        <?php $rank = 1; while ($hacker = $top_hackers->fetch_assoc()): ?>
            <tr>
                <td>#<?= $rank++ ?></td>
                <td><?= $hacker["username"] ?></td>
                <td><?= $hacker["wins"] ?></td>
                <td><?= $hacker["losses"] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<div class="leaderboard">
    <h2>🏴 Top 5 Klánok</h2>
    <table>
        <tr>
            <th>🏅 Helyezés</th>
            <th>⚔️ Klán</th>
            <th>🌟 Reputáció</th>
        </tr>
        <?php $rank = 1; while ($clan = $top_clans->fetch_assoc()): ?>
            <tr>
                <td>#<?= $rank++ ?></td>
                <td><?= $clan["clan_name"] ?></td>
                <td><?= $clan["reputation"] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
    </body>
</html>