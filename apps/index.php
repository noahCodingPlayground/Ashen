<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Ashen | Game Library</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="/ashen/resources/main.png">
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
<a href="/ashen/mystory/">The Journey</a>
</div>

</nav>
</div>

<main class="games-page fade-in">

<div class="library-header">
<h1>Apps Libary (BETA)</h1>

<div class="search-container" id="searchContainer">
<button class="search-btn" id="searchBtn">
<img src="/ashen/resources/search.png">
</button>
<input type="text" id="searchInput" placeholder="Search games...">
</div>

</div>

<div class="games-grid">

<?php

$gamesDir = "b1";
$folders = scandir($gamesDir);

foreach ($folders as $folder) {

if ($folder === "." || $folder === "..") {
continue;
}

$path = "$gamesDir/$folder";

if (is_dir($path)) {

$thumbnail = "$path/thumbnail.png";
$gameFile = "$path/game.html";

echo "
<div class='game-card' <div class='game-card' onclick=\"window.location.href='/ashen/display/index.php?f=showApp&app=/ashen/apps/$gameFile'\">
<div class='card-thumb'>
<img src='$thumbnail'>
</div>
<p class='game-name'>$folder</p>
</div>
";
}
}

?>

</div>

</main>

<script src="main.js"></script>

<script src="https://unpkg.com/lenis@1.3.16/dist/lenis.min.js"></script>
<script>
const lenis = new Lenis({
duration: 1.2,
smoothWheel: true,
smoothTouch: false
})

function raf(time){
lenis.raf(time)
requestAnimationFrame(raf)
}

requestAnimationFrame(raf)
</script>
</body>
</html>

