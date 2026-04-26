(async () => {
    const saved = localStorage.getItem("ashenAuth");

    if (!saved) {
        window.location.href = "/ashen/login";
        return;
    }

    const data = JSON.parse(saved);

    try {
        const res = await fetch(`/ashen/apis/api.php?f=validateAccount&username=${data.username}&password=${data.password}&licenseKey=${data.licenseKey}`);
        const text = await res.text();

        if (text !== "success") {
            window.location.href = "/ashen/login";
        }
    } catch {
        window.location.href = "/ashen/login";
    }
})();

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