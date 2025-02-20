<?php
include("db.php");
include("navbar.php");

$user_id = $_SESSION["user_id"];
$items = [
    ["name" => "Anonim SIM-kártya", "price" => 8],
    ["name" => "Deep Web VPN", "price" => 12],
    ["name" => "Zero-Day Exploit", "price" => 20],
    ["name" => "Adatszivárgási Lista", "price" => 15],
    ["name" => "Hamis Identitás Csomag", "price" => 18]
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["item"])) {
    $item = $_POST["item"];
    $cost = array_filter($items, fn($i) => $i["name"] === $item);
    $cost = reset($cost)["price"];
    
    $conn->query("UPDATE users SET btc_balance = btc_balance - $cost WHERE id = $user_id");
    echo "✅ Sikeres vásárlás! Megvetted: $item";
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Titkos Piactér</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>🛑 Titkos Piactér</h1>
    <p>Vásárolj exkluzív dark web eszközöket, hogy növeld a hacker képességeidet!</p>
    <form method="POST">
        <select name="item">
            <?php foreach ($items as $i): ?>
                <option value="<?= $i["name"] ?>"><?= $i["name"] ?> - <?= $i["price"] ?> BTC</option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Vásárlás</button>
    </form>
</body>
</html>