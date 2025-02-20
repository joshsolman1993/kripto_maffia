document.addEventListener("DOMContentLoaded", function() {
    let terminalText = "Csatlakozás a dark webhez...\nBejelentkezés anonimizált IP-címmel...\nSikeres kapcsolat!";
    let index = 0;
    let textElement = document.getElementById("terminal-text");
    
    function typeEffect() {
        if (index < terminalText.length) {
            textElement.innerHTML += terminalText[index];
            index++;
            setTimeout(typeEffect, 50);
        }
    }
    
    typeEffect();
});


document.addEventListener("DOMContentLoaded", function() {
    const loggedInUser = localStorage.getItem("loggedInUser");
    const welcomeMessage = document.getElementById("welcome-message");
    const logoutBtn = document.getElementById("logout-btn");

    if (welcomeMessage) {
        if (!loggedInUser) {
            // Ha nincs bejelentkezve a felhasználó, irány a login oldal
            window.location.href = "login.html";
        } else {
            welcomeMessage.textContent = `Üdv, ${loggedInUser}!`;
        }
    }

    // Kijelentkezés
    if (logoutBtn) {
        logoutBtn.addEventListener("click", function() {
            localStorage.removeItem("loggedInUser"); // Felhasználó kijelentkeztetése
            alert("Sikeres kijelentkezés!");
            window.location.href = "index.html"; // Visszaviszi a kezdőlapra
        });
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const btcBalanceElement = document.getElementById("btc-balance");
    const earnBtcBtn = document.getElementById("earn-btc");
    let btcBalance = parseFloat(localStorage.getItem("btcBalance")) || 5; // Kezdőtőke 5 BTC

    if (btcBalanceElement) {
        btcBalanceElement.textContent = btcBalance.toFixed(2);
    }

    // Véletlenszerű BTC bevétel szerzése (0.1 - 1 BTC)
    if (earnBtcBtn) {
        earnBtcBtn.addEventListener("click", function() {
            let income = (Math.random() * 0.9 + 0.1).toFixed(2);
            btcBalance += parseFloat(income);
            localStorage.setItem("btcBalance", btcBalance.toFixed(2));
            btcBalanceElement.textContent = btcBalance.toFixed(2);
            alert(`Sikeres tranzakció! +${income} BTC`);
        });
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const buyButtons = document.querySelectorAll(".buy-btn");

    if (buyButtons) {
        buyButtons.forEach(button => {
            button.addEventListener("click", function() {
                let price = parseFloat(this.getAttribute("data-price"));
                let btcBalance = parseFloat(localStorage.getItem("btcBalance")) || 5;

                if (btcBalance >= price) {
                    btcBalance -= price;
                    localStorage.setItem("btcBalance", btcBalance.toFixed(2));
                    document.getElementById("btc-balance").textContent = btcBalance.toFixed(2);
                    alert(`Vásárlás sikeres! -${price} BTC`);
                } else {
                    alert("Nincs elég Bitcoinod ehhez!");
                }
            });
        });
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const sellButtons = document.querySelectorAll(".sell-btn");
    let btcBalance = parseFloat(localStorage.getItem("btcBalance")) || 5;

    // Eladás gombok kezelése
    if (sellButtons) {
        sellButtons.forEach(button => {
            button.addEventListener("click", function() {
                let price = parseFloat(this.getAttribute("data-price"));
                btcBalance += price;
                localStorage.setItem("btcBalance", btcBalance.toFixed(2));
                document.getElementById("btc-balance").textContent = btcBalance.toFixed(2);
                alert(`Sikeres eladás! +${price} BTC`);
            });
        });
    }

    // AI vásárlók véletlenszerű időközönként vásárolnak
    function aiBuysProduct() {
        let products = [
            { name: "Lopott hitelkártyák", price: 0.5, chance: 0.6 },
            { name: "Exploit kódok", price: 1, chance: 0.3 },
            { name: "Fegyverek", price: 2, chance: 0.1 }
        ];

        let selectedProduct = products.find(p => Math.random() < p.chance);

        if (selectedProduct) {
            btcBalance += selectedProduct.price;
            localStorage.setItem("btcBalance", btcBalance.toFixed(2));
            document.getElementById("btc-balance").textContent = btcBalance.toFixed(2);
            console.log(`AI vásárló vett: ${selectedProduct.name} (+${selectedProduct.price} BTC)`);
        }

        setTimeout(aiBuysProduct, Math.random() * 15000 + 5000); // 5-20 másodpercenként vesz valamit
    }

    aiBuysProduct();
});

document.addEventListener("DOMContentLoaded", function() {
    const hackBtn = document.getElementById("hack-btn");
    const hackStatus = document.getElementById("hack-status");
    let btcBalance = parseFloat(localStorage.getItem("btcBalance")) || 5;
    let anonymity = parseInt(localStorage.getItem("anonymity")) || 50;

    if (hackBtn) {
        hackBtn.addEventListener("click", function() {
            let successChance = 50 + anonymity / 2; // Alap 50% esély, anonim növeli
            let success = Math.random() * 100 < successChance;

            if (success) {
                btcBalance += 1;
                hackStatus.textContent = "✅ Sikeres támadás! +1 BTC";
            } else {
                btcBalance -= 0.5;
                anonymity -= 10; // Lebukás csökkenti az anonim szintet
                hackStatus.textContent = "❌ Lebuktál! -0.5 BTC és anonimitás csökkent";
            }

            localStorage.setItem("btcBalance", btcBalance.toFixed(2));
            localStorage.setItem("anonymity", anonymity);
            document.getElementById("btc-balance").textContent = btcBalance.toFixed(2);
            document.getElementById("anonymity-level").textContent = anonymity;
        });
    }
});


document.addEventListener("DOMContentLoaded", function() {
    const anonymityLevel = document.getElementById("anonymity-level");
    const vpnBtn = document.getElementById("use-vpn");
    const torBtn = document.getElementById("use-tor");
    let anonymity = parseInt(localStorage.getItem("anonymity")) || 50;

    function updateAnonymity() {
        anonymityLevel.textContent = anonymity;
        localStorage.setItem("anonymity", anonymity);
    }

    if (vpnBtn) {
        vpnBtn.addEventListener("click", function() {
            if (anonymity < 100) {
                anonymity += 10;
                updateAnonymity();
                alert("VPN aktiválva! Anonimitás nőtt.");
            } else {
                alert("Anonimitás már maximális!");
            }
        });
    }

    if (torBtn) {
        torBtn.addEventListener("click", function() {
            if (anonymity < 100) {
                anonymity += 20;
                updateAnonymity();
                alert("Tor hálózat aktiválva! Anonimitás jelentősen nőtt.");
            } else {
                alert("Anonimitás már maximális!");
            }
        });
    }

    updateAnonymity();
});

document.addEventListener("DOMContentLoaded", function() {
    const hackButtons = document.querySelectorAll(".hack-btn");
    const hackStatus = document.getElementById("hack-status");
    let btcBalance = parseFloat(localStorage.getItem("btcBalance")) || 5;
    let anonymity = parseInt(localStorage.getItem("anonymity")) || 50;

    const targets = {
        bank: { reward: 3, risk: 70 },
        gov: { reward: 5, risk: 85 },
        darkweb: { reward: 1.5, risk: 50 }
    };

    hackButtons.forEach(button => {
        button.addEventListener("click", function() {
            let target = this.getAttribute("data-target");
            let risk = targets[target].risk - anonymity / 2; // Anonimitás csökkenti a lebukás esélyét
            let success = Math.random() * 100 > risk;

            if (success) {
                btcBalance += targets[target].reward;
                hackStatus.textContent = `✅ Sikeres támadás! +${targets[target].reward} BTC`;
            } else {
                btcBalance -= 1;
                anonymity -= 15; // Lebukás csökkenti az anonimitást
                hackStatus.textContent = `❌ Lebuktál! -1 BTC és anonimitás csökkent (-15%)`;
            }

            localStorage.setItem("btcBalance", btcBalance.toFixed(2));
            localStorage.setItem("anonymity", anonymity);
            document.getElementById("btc-balance").textContent = btcBalance.toFixed(2);
            document.getElementById("anonymity-level").textContent = anonymity;
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    let wantedLevel = parseInt(localStorage.getItem("wantedLevel")) || 0;
    const wantedDisplay = document.getElementById("wanted-level");

    function updateWantedLevel(change) {
        wantedLevel += change;
        if (wantedLevel > 100) wantedLevel = 100;
        if (wantedLevel < 0) wantedLevel = 0;
        localStorage.setItem("wantedLevel", wantedLevel);
        wantedDisplay.textContent = wantedLevel;

        if (wantedLevel >= 100) {
            alert("🚔 A rendőrség elkapott! Újra kell kezdened a játékot.");
            localStorage.clear();
            window.location.href = "index.html";
        }
    }

    // Ha hackel a játékos, nő a wanted level
    const hackButtons = document.querySelectorAll(".hack-btn");
    hackButtons.forEach(button => {
        button.addEventListener("click", function() {
            updateWantedLevel(10); // Minden hack növeli a figyelmet
        });
    });

    // VPN és Tor csökkenti a körözési szintet
    const vpnBtn = document.getElementById("use-vpn");
    const torBtn = document.getElementById("use-tor");

    if (vpnBtn) vpnBtn.addEventListener("click", () => updateWantedLevel(-5));
    if (torBtn) torBtn.addEventListener("click", () => updateWantedLevel(-10));

    wantedDisplay.textContent = wantedLevel;
});

document.addEventListener("DOMContentLoaded", function() {
    let rivalActivity = parseInt(localStorage.getItem("rivalActivity")) || 0;
    const rivalDisplay = document.getElementById("rival-hackers");

    function updateRivalActivity() {
        rivalActivity += Math.floor(Math.random() * 10); // Véletlenszerű növekedés
        if (rivalActivity > 100) rivalActivity = 100;
        localStorage.setItem("rivalActivity", rivalActivity);
        rivalDisplay.textContent = rivalActivity;

        if (rivalActivity >= 100) {
            alert("❌ A rivális hackerek átvették az uralmat! Vége a játéknak.");
            localStorage.clear();
            window.location.href = "index.html";
        }
    }

    setInterval(updateRivalActivity, 15000); // 15 másodpercenként nő a riválisok aktivitása

    // DDoS támadás csökkenti az aktivitásukat
    const hackBtn = document.getElementById("hack-btn");
    if (hackBtn) {
        hackBtn.addEventListener("click", function() {
            rivalActivity -= 10;
            if (rivalActivity < 0) rivalActivity = 0;
            localStorage.setItem("rivalActivity", rivalActivity);
            rivalDisplay.textContent = rivalActivity;
        });
    }
});

function randomEvent() {
    let eventChance = Math.random();

    if (eventChance < 0.2) {
        alert("💀 Zsarolóvírus támadás! -1 BTC");
        btcBalance -= 1;
    } else if (eventChance < 0.1) {
        alert("🚔 FBI razzia! Minden BTC-d fele elveszett!");
        btcBalance /= 2;
    }

    localStorage.setItem("btcBalance", btcBalance.toFixed(2));
    document.getElementById("btc-balance").textContent = btcBalance.toFixed(2);
}

setInterval(randomEvent, 30000); // 30 másodpercenként történik valami


document.addEventListener("DOMContentLoaded", function() {
    const missions = [
        { text: "💻 Lopj adatokat egy cégtől! (Jutalom: 2 BTC)", reward: 2 },
        { text: "📂 Zsarolóvírus támadás egy szerver ellen! (Jutalom: 3 BTC)", reward: 3 },
        { text: "🏦 Banki heist végrehajtása! (Jutalom: 5 BTC, Nagy kockázat)", reward: 5 }
    ];

    let btcBalance = parseFloat(localStorage.getItem("btcBalance")) || 5;
    const missionText = document.getElementById("mission-text");
    const getMissionBtn = document.getElementById("get-mission");
    const completeMissionBtn = document.getElementById("complete-mission");
    let currentMission = JSON.parse(localStorage.getItem("currentMission")) || null;

    function updateMissionDisplay() {
        if (currentMission) {
            missionText.textContent = currentMission.text;
            completeMissionBtn.style.display = "inline";
            getMissionBtn.style.display = "none";
        } else {
            missionText.textContent = "Nincs aktív küldetés.";
            completeMissionBtn.style.display = "none";
            getMissionBtn.style.display = "inline";
        }
    }

    getMissionBtn.addEventListener("click", function() {
        currentMission = missions[Math.floor(Math.random() * missions.length)];
        localStorage.setItem("currentMission", JSON.stringify(currentMission));
        updateMissionDisplay();
    });

    completeMissionBtn.addEventListener("click", function() {
        btcBalance += currentMission.reward;
        localStorage.setItem("btcBalance", btcBalance.toFixed(2));
        document.getElementById("btc-balance").textContent = btcBalance.toFixed(2);
        currentMission = null;
        localStorage.removeItem("currentMission");
        updateMissionDisplay();
    });

    updateMissionDisplay();
});

document.addEventListener("DOMContentLoaded", function() {
    let btcBalance = parseFloat(localStorage.getItem("btcBalance")) || 5;
    let aiHackers = [
        { name: "DarkGhost", btc: 8 },
        { name: "CyberShadow", btc: 6 },
        { name: "AnonOps", btc: 10 }
    ];

    function updateLeaderboard() {
        aiHackers.forEach(hacker => hacker.btc += Math.random() * 2); // AI növeli a BTC-jét
        aiHackers.sort((a, b) => b.btc - a.btc);

        document.getElementById("top-hacker").textContent = `${aiHackers[0].name} (${aiHackers[0].btc.toFixed(2)} BTC)`;

        let playerRank = aiHackers.findIndex(hacker => hacker.btc < btcBalance) + 1;
        document.getElementById("player-rank").textContent = playerRank > 0 ? `#${playerRank}` : "N/A";
    }

    setInterval(updateLeaderboard, 15000); // 15 másodpercenként frissít
});

document.addEventListener("DOMContentLoaded", function() {
    let btcBalance = parseFloat(localStorage.getItem("btcBalance")) || 5;
    let upgrades = JSON.parse(localStorage.getItem("upgrades")) || [];
    const upgradesList = document.getElementById("upgrades-list");

    function updateUpgradesDisplay() {
        upgradesList.innerHTML = "";
        upgrades.forEach(upgrade => {
            let listItem = document.createElement("li");
            listItem.textContent = upgrade;
            upgradesList.appendChild(listItem);
        });
    }

    function buyUpgrade(upgrade, cost) {
        if (btcBalance >= cost) {
            btcBalance -= cost;
            upgrades.push(upgrade);
            localStorage.setItem("btcBalance", btcBalance.toFixed(2));
            localStorage.setItem("upgrades", JSON.stringify(upgrades));
            document.getElementById("btc-balance").textContent = btcBalance.toFixed(2);
            updateUpgradesDisplay();
            alert(`${upgrade} megvásárolva!`);
        } else {
            alert("Nincs elég BTC-d!");
        }
    }

    document.getElementById("buy-exploit").addEventListener("click", () => buyUpgrade("Exploit Kód", 2));
    document.getElementById("buy-botnet").addEventListener("click", () => buyUpgrade("Botnet", 5));
    document.getElementById("buy-vpn").addEventListener("click", () => buyUpgrade("Anonym VPN", 3));

    updateUpgradesDisplay();
});
