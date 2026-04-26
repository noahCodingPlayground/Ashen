<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Ashen</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="/ashen/resources/favicon.png">
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
<a href="/ashen/games/">Games</a>
<a href="/ashen/apps/">Apps</a>
<a href="/ashen/mystory/">The Journey</a>
</div>

</nav>
</div>

<main class="home-page fade-in">

<section class="hero">

<h1>Exceptional Power. Endless Games.</h1>

<p class="hero-sub" id="tip-text">
TIP: Go to the "Journey" page to find the version and facts about the creator of this website.
</p>

<div class="hero-buttons">
<a href="/ashen/games/" class="hero-btn">Browse Games</a>
<a href="/ashen/mystory/" class="hero-btn-alt">Our Story</a>
</div>


</section>

<section class="section">

</section>

<section class="features">

<div class="feature-card">
<h3>Fast Performance</h3>
<p>Games launch instantly with optimized delivery and lightweight design for smooth gameplay.</p>
</div>

<div class="feature-card">
<h3>Clean Experience</h3>
<p>No clutter. No distractions. Just a modern interface designed for focus and enjoyment.</p>
</div>

<div class="feature-card">
<h3>Growing Library</h3>
<p>Ashen continues expanding with new browser games and curated arcade classics.</p>
</div>

</section>

</main>

<script src="main.js"></script>

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