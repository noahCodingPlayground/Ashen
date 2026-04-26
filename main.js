const tips = [
"Head over to the 'Journey' page to view interesting facts about the developer, and updates about this website!",
"The owner of this website likes corgis",
"Carson likes big black oiled up guys in his butt",
"Leo is married to the main guy in 60 Seconds Burger Run.",
"My name is Noah, and I'm the creator of this site.",
"You are one of a few people in this school who have access to this website at this time.",
"mikey diddy blud on calculator",
"Jonah Bigham holds the current WR of 33 goals in one game for the Premier Leagues."
]

function setRandomTip(){
    const tipElement = document.getElementById("tip-text")

    if(!tipElement) return

    const randomIndex = Math.floor(Math.random() * tips.length)
    tipElement.textContent = "TIP: " + tips[randomIndex]
}

document.addEventListener("DOMContentLoaded", setRandomTip)

const glow = document.querySelector(".cursor-glow");

let mouseX = 0;
let mouseY = 0;
let currentX = 0;
let currentY = 0;

document.addEventListener("mousemove", e => {
    mouseX = e.clientX;
    mouseY = e.clientY;
});

function animate(){
    currentX += (mouseX - currentX) * 0.08;
    currentY += (mouseY - currentY) * 0.08;

    glow.style.left = currentX + "px";
    glow.style.top = currentY + "px";

    requestAnimationFrame(animate);
}

animate();

window.addEventListener("load", () => {
    document.querySelectorAll(".fade-in").forEach(el=>{
        el.classList.add("show");
    });
});

const searchContainer = document.getElementById("searchContainer");
const searchBtn = document.getElementById("searchBtn");
const searchInput = document.getElementById("searchInput");

searchBtn.addEventListener("click", (e)=>{
e.stopPropagation();
searchContainer.classList.toggle("active");

if(searchContainer.classList.contains("active")){
searchInput.focus();
}
});

document.addEventListener("click", ()=>{
searchContainer.classList.remove("active");
});

searchContainer.addEventListener("click", e=>{
e.stopPropagation();
});

searchInput.addEventListener("input", ()=>{
const value = searchInput.value.toLowerCase();
document.querySelectorAll(".game-card").forEach(card=>{
const name = card.innerText.toLowerCase();
card.style.display = name.includes(value) ? "" : "none";
});
});

