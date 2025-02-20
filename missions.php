<?php
include("../includes/db.php");
include("../includes/navbar.php");
include("../includes/functions.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$user = $conn->query("SELECT level, btc_balance FROM users WHERE id = $user_id")->fetch_assoc();

// Ellenőrizzük, hogy a `completed_missions` tábla létezik-e
$conn->query("CREATE TABLE IF NOT EXISTS completed_missions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    mission_id INT NOT NULL,
    completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)");

$missions = [
    ["id" => 1, "text" => "💻 Első hack: Céges Adatok Ellopása", "reward" => 2, "xp" => 10, "requirement" => null],
    ["id" => 2, "text" => "📂 Zsarolóvírus telepítése", "reward" => 5, "xp" => 20, "requirement" => 1],
    ["id" => 3, "text" => "🏦 Banki átutalás manipulálása", "reward" => 10, "xp" => 30, "requirement" => 2],
    ["id" => 4, "text" => "🔐 Kormányzati szerver feltörése", "reward" => 20, "xp" => 50, "requirement" => 3]
];

// Lekérdezzük a már teljesített küldetéseket
$completed_missions = $conn->query("SELECT mission_id FROM completed_missions WHERE user_id = $user_id")->fetch_all(MYSQLI_ASSOC);
$completed_missions = array_column($completed_missions, 'mission_id');

$available_missions = array_filter($missions, function ($mission) use ($completed_missions) {
    return is_null($mission['requirement']) || in_array($mission['requirement'], $completed_missions);
});

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mission_id"])) {
    $mission_id = $_POST["mission_id"];
    $mission = array_filter($missions, fn($m) => $m["id"] == $mission_id);
    $mission = reset($mission);

    if (!in_array($mission_id, $completed_missions)) {
        $conn->query("UPDATE users SET btc_balance = btc_balance + {$mission["reward"]} WHERE id = $user_id");
        $conn->query("INSERT INTO completed_missions (user_id, mission_id) VALUES ($user_id, $mission_id)");
        echo "<p class='success'>✅ Sikeres küldetés! +{$mission["reward"]} BTC</p>";
    } else {
        echo "<p class='error'>❌ Ezt a küldetést már teljesítetted!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Küldetések</title>
    <link rel="stylesheet" href="styles.css"> <!-- Most már mindenhol betöltjük a CSS-t -->
</head>
<body>
    <div class="container">
        <h1>🎯 Sztori Küldetések</h1>
        <p>Válaszd ki a küldetésed:</p>
        <form method="POST">
            <select name="mission_id">
                <?php foreach ($available_missions as $mission): ?>
                    <option value="<?= $mission["id"] ?>"><?= $mission["text"] ?> (<?= $mission["reward"] ?> BTC)</option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Indítás</button>
        </form>
    </div>
</body>
</html>
