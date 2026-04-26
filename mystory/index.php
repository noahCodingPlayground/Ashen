<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Ashen | Our Story</title>
<link rel="icon" type="image/png" href="/ashen/resources/main.png">
<link rel="stylesheet" href="/ashen/style.css">
</head>

<body>

<div class="cursor-glow"></div>

<div class="navbar-wrapper">
<nav class="navbar fade-in">

<div class="nav-left">
<img src="/ashen/resources/main.png" class="logo">
<span class="site-title">Ashen</span>
</div>

<div class="nav-links">
<a href="/ashen/">Home</a>
<a href="/ashen/games/">Games</a>
<a href="/ashen/apps/">Apps</a>
</div>

</nav>
</div>

<main class="home-page fade-in">

<section class="hero">

<h1>The Journey</h1>

<p class="hero-sub">
Ashen was built around a simple idea — games should be fast, clean, and easy to access. What started as a small experiment grew into a modern arcade hub designed for performance and simplicity.
</p>

</section>

<section class="section">

<h2>The Beginning</h2>

<div class="feature-card">
<p>
I started building websites that revolved around HTML5 games at the start of the class of 2025-26. I started with a simple website known as "Sentry X" to many. I slowly built up and upgraded this website whilst the community was growing along with the updates.
</p>
</div>

</section>

<section class="section">

<h2>The Idea Development</h2>

<div class="feature-card">
<p>
Since Sentry X, the original website has been down for a while, I have been thinking about doing a full rewrite. You may be asking, "Noah, why not just fix the bugs in the website?". Well, so glad you asked (even though you probably did not). I have kept the same website structure since I started creating Sentry X, which was messy and inconvenient. Fixing all of the bugs inside of the Sentry X website would take too long, so I decided that I will start from scratch and build my way back up. 
</p>
</div>

</section>

<section class="section">

<h2>About Me</h2>

<div class="feature-card">
<p>
My name is Noah, and I am the person who started the trend of "making game websites" for school (not really a trend but whatever). I'm a seventh grader who likes playing soccer and coding. Yeah, that's about it. Nothing really interesting on my part :D
</p>
</div>

</section>

<section class="section">

<h2>The Future</h2>

<div class="feature-card">
<p>
I hope by the end of this school year, I can have a full community of users that know about this website. Along with that, I will continue to roll out more updates and grow the game library. Until then, see you next time!
</p>
</div>

</section>

<section class="section">

<h2>Version</h2>

<div class="feature-card">
<p>
Current Version: v1.3a.4 | A couple more games were added, display page was upgraded.
</p>
</div>

</section>

<section class="features">

</section>

</main>

<script>
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
</script>

<script src="/ashen/main.js"></script>

<script src="https://unpkg.com/lenis@1.3.16/dist/lenis.min.js"></script>
<script>
const lenis = new Lenis({
duration:1.2,
smoothWheel:true,
smoothTouch:false
})

function raf(time){
lenis.raf(time)
requestAnimationFrame(raf)
}

requestAnimationFrame(raf)
</script>

</body>
</html>