<?php
include("../includes/db.php");
include("../includes/navbar.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$result = $conn->query("SELECT btc_balance FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();
?>

<head>
<link rel="stylesheet" href="styles.css">
</head>

<h1>🛡 Védekezési Rendszerek</h1>

<section class="panel">
    <h2>Biztonsági fejlesztések</h2>
    <form action="market.php" method="POST">
        <select name="security">
            <option value="firewall">🛑 Tűzfal - 3 BTC</option>
            <option value="proxy">🌐 Proxy - 2 BTC</option>
            <option value="tor">🕵️ Tor Hálózat - 5 BTC</option>
        </select>
        <button type="submit" name="buy_security">Vásárlás</button>
    </form>
</section>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["buy_security"])) {
    $security_items = ["firewall" => 3, "proxy" => 2, "tor" => 5];
    $item = $_POST["security"];

    if ($user["btc_balance"] >= $security_items[$item]) {
        $conn->query("UPDATE users SET btc_balance = btc_balance - {$security_items[$item]} WHERE id = $user_id");
        $conn->query("UPDATE users SET anonymity = anonymity + 10 WHERE id = $user_id");
        echo "<p>Sikeres vásárlás! +10% Anonimitás</p>";
    } else {
        echo "<p>Nincs elég BTC-d!</p>";
    }
}
?>
