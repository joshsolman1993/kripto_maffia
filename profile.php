<?php
include("../includes/db.php");
include("../includes/navbar.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$result = $conn->query("SELECT username, btc_balance, anonymity, wanted_level FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();

$transactions = $conn->query("SELECT type, amount, description, created_at FROM transactions WHERE user_id = $user_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>👤 Profil - <?= $user["username"] ?></h1>

        <section class="panel">
            <h2>💰 Bitcoin Egyenleg</h2>
            <p><?= $user["btc_balance"] ?> BTC</p>
        </section>

        <section class="panel">
            <h2>🕵️ Anonimitás</h2>
            <p><?= $user["anonymity"] ?>%</p>
        </section>

        <section class="panel">
            <h2>🚔 Körözési Szint</h2>
            <p><?= $user["wanted_level"] ?>%</p>
        </section>

        <section class="panel">
            <h2>📊 Legutóbbi Tranzakciók</h2>
            <table>
                <tr>
                    <th>Típus</th>
                    <th>Összeg</th>
                    <th>Leírás</th>
                    <th>Dátum</th>
                </tr>
                <?php while ($row = $transactions->fetch_assoc()): ?>
                <tr>
                    <td><?= $row["type"] == 'earn' ? '💰 Bevétel' : '🛒 Kiadás' ?></td>
                    <td><?= $row["amount"] ?> BTC</td>
                    <td><?= $row["description"] ?></td>
                    <td><?= $row["created_at"] ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </section>

        <a href="dashboard.php" class="button">🔙 Vissza a főoldalra</a>
    </div>
</body>
</html>
