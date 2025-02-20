<?php
include("../includes/db.php");
session_start();

$user_id = $_SESSION["user_id"] ?? null;
if ($user_id) {
    $user = $conn->query("SELECT level, max_heist_level, exploit_access FROM users WHERE id = $user_id")->fetch_assoc();
} else {
    $user = ["level" => 0, "max_heist_level" => 0, "exploit_access" => 0];
}
?>

<nav>
    <ul>
        <li><a href="dashboard.php">🏠 Kezdőlap</a></li>
        <li><a href="market.php">🛒 Piactér</a></li>
        <li><a href="missions.php">🎯 Küldetések</a></li>
        <?= ($user["max_heist_level"] >= 2) ? '<li><a href="heists.php">🔥 Heistek</a></li>' : '<li class="disabled">🔒 Heistek</li>' ?>
        <?= ($user["exploit_access"] >= 1) ? '<li><a href="exploits.php">🔧 Exploitok</a></li>' : '<li class="disabled">🔒 Exploitok</li>' ?>
        <?= ($user["level"] >= 3) ? '<li><a href="contacts.php">🕵️ Dark Web Kapcsolatok</a></li>' : '<li class="disabled">🔒 Dark Web Kapcsolatok</li>' ?>
        <?= ($user["level"] >= 4) ? '<li><a href="clans.php">🏴 Klánok</a></li>' : '<li class="disabled">🔒 Klánok</li>' ?>
        <?= ($user["level"] >= 5) ? '<li><a href="pvp.php">💀 PvP Hack</a></li>' : '<li class="disabled">🔒 PvP Hack</li>' ?>
        <?= ($user["level"] >= 6) ? '<li><a href="clan_wars.php">⚔️ Klánháborúk</a></li>' : '<li class="disabled">🔒 Klánháborúk</li>' ?>
        <li><a href="profile.php">👤 Profil</a></li>
        <?= ($user["level"] >= 6) ? '<li><a href="leaderboard.php">🏆 Ranglista</a></li>' : '<li class="disabled">🔒 Ranglista</li>' ?>
        <li><a href="logout.php">🚪 Kijelentkezés</a></li>
    </ul>
</nav>

