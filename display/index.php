<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
define('BASE_PATH', realpath(__DIR__ . '/../../'));
include_once BASE_PATH . '/env.php';
include_once BASE_PATH . '/config.php';
include_once BASE_PATH . '/api/utilities.php';

if (isset($_REQUEST['f']) && !empty($_REQUEST['f'])){
    if (__FILE__==realpath($_SERVER['SCRIPT_FILENAME'])){
        $requestedFunction=$_REQUEST['f'];
        unset($_REQUEST['f']);

        if (!util_security_isuserfctn(['f'=>$requestedFunction])){
            die("API function not recognized.");
        }

        if (!function_exists($requestedFunction)){
            die("API function not recognized.");
        }

        call_user_func($requestedFunction,$_REQUEST);
        exit;
    }
}

function showApp($params){
    if (!isset($params['app']) || empty($params['app'])){
        die("no app link provided");
    }

    $link = htmlspecialchars($params['app'], ENT_QUOTES, 'UTF-8');

    echo '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Ashen | Game Display</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="/ashen/resources/main.png">

<style>
html,body{
height:100%;
}

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Inter,Arial,sans-serif;
}

body{
background:#0d0d12;
color:#e5e7eb;
min-height:100vh;
overflow-x:hidden;
}

body::before{
content:"";
position:fixed;
inset:0;
background-image:radial-gradient(rgba(255,120,40,.18) 1px,transparent 1px);
background-size:28px 28px;
pointer-events:none;
z-index:0;
}

.cursor-glow{
position:fixed;
width:420px;
height:420px;
border-radius:50%;
pointer-events:none;
background:rgba(255,120,40,.16);
filter:blur(120px);
transform:translate(-50%,-50%);
z-index:1;
}

.navbar-wrapper{
position:fixed;
top:28px;
width:100%;
display:flex;
justify-content:center;
z-index:100;
}

.navbar{
width:80%;
height:70px;
display:flex;
align-items:center;
justify-content:space-between;
padding:0 28px;
border-radius:16px;
background:rgba(255,255,255,.06);
backdrop-filter:blur(18px) saturate(180%);
border:1px solid rgba(255,255,255,.12);
box-shadow:0 10px 40px rgba(0,0,0,.45);
}

.nav-left{
display:flex;
align-items:center;
gap:10px;
}

.logo{
height:34px;
width:auto;
}

.site-title{
font-size:20px;
font-weight:600;
color:#ff7a18;
}

.nav-links a{
text-decoration:none;
color:#e5e7eb;
font-size:14px;
padding:8px 18px;
border-radius:8px;
background:rgba(0,0,0,.35);
border:1px solid rgba(255,255,255,.15);
transition:.15s;
}

.nav-links a:hover{
background:rgba(255,120,40,.35);
border-color:rgba(255,120,40,.6);
transform:translateY(-1px);
}

.player-container{
padding-top:140px;
width:90%;
margin:auto;
position:relative;
z-index:2;
}

.display-layout{
display:flex;
gap:28px;
align-items:flex-start;
}

.left-panel{
flex:3;
}

.right-panel{
flex:1;
}

.game-player{
width:100%;
height:70vh;
border-radius:14px;
overflow:hidden;
box-shadow:0 10px 40px rgba(0,0,0,.6);
}

.game-player iframe{
width:100%;
height:100%;
border:none;
}

.player-header{
display:flex;
align-items:center;
justify-content:space-between;
margin-bottom:10px;
}

.game-title{
font-size:32px;
}

.play-more{
position:sticky;
top:120px;
}

.play-more h2{
margin-bottom:18px;
}

.games-grid{
display:grid;
grid-template-columns:repeat(2, 1fr);
gap:12px;
padding-top:8px;
align-content:start;
}

.game-card{
position:relative;
border-radius:10px;
overflow:hidden;
cursor:pointer;
width:100%;
aspect-ratio:1/1;
transition:.18s;
}

.game-card:hover{
transform:translateY(-4px);
box-shadow:0 10px 25px rgba(0,0,0,.45);
}

.card-thumb{
width:100%;
height:100%;
}

.card-thumb img{
width:100%;
height:100%;
object-fit:cover;
}

.game-name{
position:absolute;
bottom:0;
width:100%;
padding:8px;
text-align:center;
font-size:12px;
font-weight:600;
background:rgba(0,0,0,.45);
}

.fullscreen-btn{
width:42px;
height:42px;
border-radius:10px;
border:1px solid rgba(255,255,255,.15);
background:rgba(0,0,0,.35);
backdrop-filter:blur(10px);
display:flex;
align-items:center;
justify-content:center;
cursor:pointer;
transition:.2s;
}

.fullscreen-btn img{
width:18px;
height:18px;
}

.fullscreen-btn:hover{
background:rgba(255,120,40,.35);
border-color:rgba(255,120,40,.6);
transform:translateY(-1px);
}
</style>
</head>

<body>

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

<div class="player-container fade-in">

<div class="display-layout">

<div class="left-panel">

<div class="player-header">
<div class="game-title">Now Playing</div>

<div class="fullscreen-btn" onclick="goFullscreen()">
<img src="/ashen/resources/maximize.png">
</div>
</div>

<div class="game-player" id="gameContainer">
<iframe id="gameFrame" src="'.$link.'"></iframe>
</div>

</div>

<div class="right-panel">

<div class="play-more">

<h2>Play More</h2>

<div class="games-grid">';

$gamesDir = BASE_PATH . "/ashen/display/playmore";
$folders = scandir($gamesDir);

foreach ($folders as $folder) {

    if ($folder === "." || $folder === "..") {
        continue;
    }

    $path = $gamesDir . "/" . $folder;

    if (is_dir($path)) {

        $thumbnail = "/ashen/display/playmore/" . $folder . "/thumbnail.png";
        $gameFile = "/ashen/display/playmore/" . $folder . "/game.html";

        echo '
        <div class="game-card" onclick="location.href=\'/ashen/display/index.php?f=showApp&app=' . $gameFile . '\'">
            <div class="card-thumb">
                <img src="' . $thumbnail . '">
            </div>
            <div class="game-name">' . htmlspecialchars($folder, ENT_QUOTES, "UTF-8") . '</div>
        </div>
        ';
    }
}

echo '
</div>

</div>

</div>

</div>

</div>

<script src="/ashen/main.js"></script>

<script src="https://unpkg.com/lenis@1.3.16/dist/lenis.min.js"></script>
<script>
function goFullscreen(){
    const elem = document.getElementById("gameContainer");

    if (!document.fullscreenElement) {
        elem.requestFullscreen().catch(()=>{});
    } else {
        document.exitFullscreen();
    }
}

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

document.querySelectorAll(".fade-in").forEach(el=>{
setTimeout(()=>el.classList.add("show"),100)
})

document.addEventListener("mousemove",e=>{
const glow=document.querySelector(".cursor-glow")
glow.style.left=e.clientX+"px"
glow.style.top=e.clientY+"px"
})
</script>

</body>
</html>';
}
?>