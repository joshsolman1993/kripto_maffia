<?php
include("../includes/db.php");
include("../includes/navbar.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$attacks = [
    ["text" => "🏦 Bank Hackelése (3 BTC)", "reward" => 3, "risk" => 70],
    ["text" => "🏛 Kormányzati szerver támadása (5 BTC)", "reward" => 5, "risk" => 85],
    ["text" => "🕵️ Dark Web riválisok elleni támadás (1.5 BTC)", "reward" => 1.5, "risk" => 50]
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $attack = $attacks[array_rand($attacks)];
    $risk = $attack["risk"] - rand(0, 50); // VPN és anonimitás csökkenti a lebukás esélyét
    $success = rand(1, 100) > $risk;

    if ($success) {
        $conn->query("UPDATE users SET btc_balance = btc_balance + {$attack["reward"]} WHERE id = $user_id");
        echo "<p>✅ Sikeres támadás! +{$attack["reward"]} BTC</p>";
    } else {
        $conn->query("UPDATE users SET btc_balance = btc_balance - 1 WHERE id = $user_id");
        echo "<p>❌ Lebuktál! -1 BTC</p>";
    }
}
?>
<head>
<link rel="stylesheet" href="styles.css">
</head>
<h1>💻 Hacker Támadások</h1>
<p>Válassz célpontot:</p>
<form method="POST">
    <button type="submit">Indíts támadást</button>
</form>
