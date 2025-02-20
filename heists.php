<?php
include("../includes/db.php");
include("../includes/navbar.php");
include("../includes/functions.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$user = $conn->query("SELECT btc_balance, anonymity, wanted_level, max_heist_level FROM users WHERE id = $user_id")->fetch_assoc();

// Heistek listája előfeltételekkel
$heists = [
    ["id" => 1, "name" => "🏦 Bankrablás", "reward" => 15, "risk" => 30, "requirement" => "SQL Injection"],
    ["id" => 2, "name" => "🏢 Kriptotőzsde Feltörése", "reward" => 30, "risk" => 50, "requirement" => "DDoS Botnet"],
    ["id" => 3, "name" => "🔐 Kormányzati Adatlopás", "reward" => 50, "risk" => 70, "requirement" => "Zero-Day Exploit"]
];

$available_heists = array_filter($heists, function ($heist) use ($user) {
    return $user["max_heist_level"] >= $heist["id"];
});

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["heist_id"])) {
    $heist_id = $_POST["heist_id"];
    $heist = array_filter($heists, fn($h) => $h["id"] == $heist_id);
    $heist = reset($heist);

    $risk = rand(1, 100);

    if ($risk > $heist["risk"]) {
        $conn->query("UPDATE users SET btc_balance = btc_balance + {$heist["reward"]} WHERE id = $user_id");
        echo "<p class='success'>✅ Sikeres heist! +{$heist["reward"]} BTC</p>";
    } else {
        $conn->query("UPDATE users SET wanted_level = wanted_level + 15 WHERE id = $user_id");
        echo "<p class='error'>🚨 Lebuktál! Körözési szinted nőtt (+15%)</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Heistek</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>🔥 Heistek</h1>
        <p>Válaszd ki a rablás célpontját:</p>
        <form method="POST">
            <select name="heist_id">
                <?php foreach ($available_heists as $heist): ?>
                    <option value="<?= $heist["id"] ?>"><?= $heist["name"] ?> (<?= $heist["reward"] ?> BTC)</option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Indítás</button>
        </form>
    </div>
</body>
</html>
