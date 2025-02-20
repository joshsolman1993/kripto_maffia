<?php
include("db.php");
include("navbar.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["bid"])) {
    $bid = $_POST["bid"];
    $conn->query("UPDATE users SET btc_balance = btc_balance - $bid WHERE id = {$_SESSION["user_id"]}");
    $conn->query("INSERT INTO auctions (user_id, bid_amount) VALUES ({$_SESSION["user_id"]}, $bid)");
    echo "⚡ Licitálás sikeres! Jelenlegi ajánlatod: $bid BTC";
}

$highest_bid = $conn->query("SELECT MAX(bid_amount) AS max_bid FROM auctions")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Web Aukció</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>⚡ Dark Web Aukció</h1>
    <p>Jelenlegi legmagasabb licit: <?= $highest_bid["max_bid"] ?? 0 ?> BTC</p>
    <p>Licitálj ritka exploitokra és egyedi hacker eszközökre!</p>
    <form method="POST">
        <input type="number" name="bid" placeholder="Licit összeg" required>
        <button type="submit">Licitálás</button>
    </form>
</body>
</html>