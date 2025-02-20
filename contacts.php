<?php
include("../includes/db.php");
include("../includes/navbar.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$user = $conn->query("SELECT btc_balance FROM users WHERE id = $user_id")->fetch_assoc();

// Dark Web kapcsolatok listája
$contacts = [
    ["type" => "Bérhacker", "effectiveness" => 10, "cost" => 10],
    ["type" => "Pénzmosó", "effectiveness" => 15, "cost" => 8],
    ["type" => "Ügyvéd", "effectiveness" => 20, "cost" => 5]
];

// Ha a játékos vesz egy kapcsolatot
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["contact_type"])) {
    $contact = array_filter($contacts, fn($c) => $c["type"] === $_POST["contact_type"]);
    $contact = reset($contact);

    if ($user["btc_balance"] >= $contact["cost"]) {
        $conn->query("INSERT INTO dark_web_contacts (user_id, contact_type, effectiveness, cost) VALUES ($user_id, '{$contact["type"]}', {$contact["effectiveness"]}, {$contact["cost"]})");
        $conn->query("UPDATE users SET btc_balance = btc_balance - {$contact["cost"]} WHERE id = $user_id");
        echo "<p class='success'>✅ Sikeresen felbérelted a(z) {$contact["type"]}-t!</p>";
    } else {
        echo "<p class='error'>❌ Nincs elég BTC-d ehhez!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Web Kapcsolatok</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>🕵️ Dark Web Kapcsolatok</h1>
        <p>Bérelj segítőket a dark weben!</p>
        <form method="POST">
            <select name="contact_type">
                <?php foreach ($contacts as $contact): ?>
                    <option value="<?= $contact["type"] ?>"><?= $contact["type"] ?> (<?= $contact["cost"] ?> BTC)</option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Felbérel</button>
        </form>
    </div>
</body>
</html>
