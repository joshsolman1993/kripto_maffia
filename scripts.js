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
