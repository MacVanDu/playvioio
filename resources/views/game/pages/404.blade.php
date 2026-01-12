<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>404 | Game Over</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
:root{
    --bg:#020617;
    --card:#0f172a;
    --neon:#38bdf8;
    --text:#e5e7eb;
    --muted:#94a3b8;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Segoe UI', Roboto, Arial, sans-serif;
}

body{
    min-height:100vh;
    background:
        radial-gradient(circle at 20% 20%, #1e293b, transparent 40%),
        radial-gradient(circle at 80% 10%, #0ea5e9, transparent 35%),
        var(--bg);
    color:var(--text);
    display:flex;
    align-items:center;
    justify-content:center;
}

.container{
    background:rgba(15,23,42,.85);
    backdrop-filter: blur(10px);
    border-radius:20px;
    padding:40px 50px;
    max-width:900px;
    width:100%;
    display:flex;
    gap:50px;
    align-items:center;
    box-shadow:0 30px 80px rgba(0,0,0,.6);
}

.left h1{
    font-size:140px;
    font-weight:900;
    line-height:1;
    background:linear-gradient(90deg,var(--neon),#818cf8);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.left h2{
    font-size:32px;
    margin-bottom:10px;
}

.left p{
    color:var(--muted);
    max-width:420px;
    margin-bottom:28px;
}

.actions{
    display:flex;
    gap:14px;
    flex-wrap:wrap;
}

.btn{
    padding:12px 28px;
    border-radius:999px;
    font-weight:600;
    text-decoration:none;
    transition:.25s;
}

.btn-home{
    background:var(--neon);
    color:#020617;
}

.btn-home:hover{
    background:#0ea5e9;
    transform:translateY(-2px);
}

.btn-back{
    border:2px solid var(--neon);
    color:var(--neon);
}

.btn-back:hover{
    background:var(--neon);
    color:#020617;
}

.right{
    flex-shrink:0;
}

svg{
    width:280px;
    animation:float 4s ease-in-out infinite;
    filter: drop-shadow(0 0 18px rgba(56,189,248,.6));
}

@keyframes float{
    0%{transform:translateY(0)}
    50%{transform:translateY(-14px)}
    100%{transform:translateY(0)}
}

/* Responsive */
@media(max-width:850px){
    .container{
        flex-direction:column;
        text-align:center;
        padding:40px 25px;
    }
    .left h1{font-size:110px}
}
</style>
</head>

<body>

<div class="container">
    <div class="left">
        <h1>404</h1>
        <h2>GAME OVER</h2>
        <p>
      The page you are looking for either doesn't exist or has been deleted.
		It seems you've strayed off the map.
        </p>

        <div class="actions">
            <a href="/" class="btn btn-home">🏠 Home Page</a>
            <a href="javascript:history.back()" class="btn btn-back">⬅ Come back</a>
        </div>
    </div>

    <div class="right">
        <!-- SVG GAME ICON -->
        <svg viewBox="0 0 200 200" fill="none">
            <rect x="30" y="50" width="140" height="90" rx="18" fill="#020617" stroke="#38bdf8" stroke-width="4"/>
            <circle cx="80" cy="95" r="8" fill="#38bdf8"/>
            <circle cx="120" cy="85" r="6" fill="#818cf8"/>
            <circle cx="135" cy="100" r="6" fill="#818cf8"/>
            <rect x="70" y="75" width="20" height="4" rx="2" fill="#38bdf8"/>
            <rect x="78" y="67" width="4" height="20" rx="2" fill="#38bdf8"/>
            <rect x="60" y="140" width="80" height="10" rx="5" fill="#38bdf8"/>
        </svg>
    </div>
</div>

</body>
</html>
