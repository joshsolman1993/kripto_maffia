<?php
function addXP($user_id, $xp_gain, $conn) {
    $user = $conn->query("SELECT xp, level FROM users WHERE id = $user_id")->fetch_assoc();
    $new_xp = $user['xp'] + $xp_gain;
    $new_level = $user['level'];

    if ($new_xp >= $new_level * 100) { // Szintlépés 100 XP-nként nő
        $new_xp = 0;
        $new_level++;
        $conn->query("UPDATE users SET level = $new_level, xp = $new_xp WHERE id = $user_id");
        return "🎉 Szintlépés! Most már Level $new_level vagy!";
    } else {
        $conn->query("UPDATE users SET xp = $new_xp WHERE id = $user_id");
        return "✅ +$xp_gain XP szerzése!";
    }
}

function aiHackersAttack($user_id, $conn) {
    $user = $conn->query("SELECT btc_balance, anonymity FROM users WHERE id = $user_id")->fetch_assoc();
    $chance = rand(1, 100) - ($user["anonymity"] / 2); // Anonimitás csökkenti a lebukás esélyét

    if ($chance < 20) { // Ha túl alacsony az anonimitás, nagyobb a támadás esélye
        $loss = rand(2, 6);
        $conn->query("UPDATE users SET btc_balance = GREATEST(0, btc_balance - $loss) WHERE id = $user_id");
        return "🚨 Egy AI hacker feltörte a szervered! -$loss BTC!";
    }
    return "🔒 Sikeresen elkerülted a támadást!";
}

function botnetEarnings($user_id, $conn) {
    $user = $conn->query("SELECT level FROM users WHERE id = $user_id")->fetch_assoc();
    $earnings = $user["level"] * 0.1; // Szintenként 0.1 BTC bányászat
    $conn->query("UPDATE users SET btc_balance = btc_balance + $earnings WHERE id = $user_id");
    return "🤖 Botnet termelt +$earnings BTC!";
}

function updateInvestigationLevel($user_id, $conn) {
    $user = $conn->query("SELECT btc_balance, btc_safe FROM users WHERE id = $user_id")->fetch_assoc();
    $risk_factor = ($user["btc_balance"] - $user["btc_safe"]) / 10; // Minél több BTC van a nyílt egyenlegeden, annál nagyobb a lebukás esélye
    $conn->query("UPDATE users SET investigation_level = LEAST(100, investigation_level + $risk_factor) WHERE id = $user_id");
}

function fbiInvestigation($user_id, $conn) {
    $user = $conn->query("SELECT btc_balance, btc_safe, investigation_level FROM users WHERE id = $user_id")->fetch_assoc();
    
    if ($user["investigation_level"] >= 80) { // FBI üldözés 80%-nál indul
        $loss = $user["btc_balance"] * 0.5; // A játékos elveszítheti a BTC 50%-át
        $conn->query("UPDATE users SET btc_balance = GREATEST(0, btc_balance - $loss), investigation_level = 50 WHERE id = $user_id");
        return "🚔 FBI rajtaütés! Elvesztettél {$loss} BTC-t!";
    }
    return "🔒 Még biztonságban vagy.";
}


?>
