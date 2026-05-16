<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BloodLink — @yield('title', 'Save Lives Together')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --red:        #980000; /* Deep Blood Red */
            --red-deep:   #4D0000;
            --red-glow:   rgba(152, 0, 0, 0.15);
            --bg:         #F4F6F8; /* Light Gray */
            --bg2:        #FFFFFF; /* Pure White */
            --bg3:        #E2E8F0; /* Soft Gray for inputs */
            --border:     rgba(10, 37, 64, 0.08);
            --border-red: rgba(217, 4, 41, 0.2);
            --text:       #0A2540; /* Royal Navy Blue */
            --muted:      #64748B; /* Slate Gray */
            --success:    #00D4A4;
            --warning:    #F5A623;
            --font-head:  'Montserrat', sans-serif;
            --font-mono:  'Space Mono', monospace;
            --ease:       cubic-bezier(0.4,0,0.2,1);
            --r:          10px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; font-size: 16px; }

        body {
            font-family: var(--font-head);
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ── CURSOR ── */
        .c-dot, .c-ring {
            position: fixed; pointer-events: none; z-index: 9999;
            border-radius: 50%; transform: translate(-50%,-50%);
        }
        .c-dot  { width:7px; height:7px; background:var(--red); transition:transform .1s; }
        .c-ring { width:30px; height:30px; border:1.5px solid var(--red); opacity:.5; transition:width .3s,height .3s,opacity .3s; }

        /* ── NAV ── */
        .nav {
            position: fixed; top:0; left:0; right:0; z-index:1000;
            height: 68px;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 48px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px);
            border-bottom: 1px solid var(--border);
        }
        .nav-logo {
            font-weight: 900; font-size: 1.4rem; letter-spacing: 4px;
            text-decoration: none; color: var(--text);
            display: flex; align-items: center; gap: 10px;
        }
        .nav-logo .dot {
            width: 10px; height: 10px; background: var(--red);
            border-radius: 50%;
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0%,100% { box-shadow: 0 0 0 0 var(--red-glow); }
            50%      { box-shadow: 0 0 0 10px transparent; }
        }
        .nav-links { display:flex; gap:36px; list-style:none; }
        .nav-links a {
            font-size:.72rem; letter-spacing:2.5px; text-transform:uppercase;
            color:var(--muted); text-decoration:none;
            transition: color .25s var(--ease);
        }
        .nav-links a:hover { color:var(--text); }
        .nav-links a.active { color:var(--red); }
        .nav-cta {
            display: flex; gap: 10px; align-items: center;
        }
        .btn-ghost {
            font-family: var(--font-mono); font-size:.68rem; letter-spacing:1.5px;
            text-transform:uppercase; padding:9px 20px;
            border:1px solid var(--border-red); border-radius:6px;
            color:var(--red); background:transparent;
            text-decoration:none; transition:all .25s var(--ease);
        }
        .btn-ghost:hover { background:var(--red-glow); }
        .btn-solid {
            font-family: var(--font-mono); font-size:.68rem; letter-spacing:1.5px;
            text-transform:uppercase; padding:9px 20px;
            background:var(--red); border-radius:6px;
            color:#fff; text-decoration:none; border:none;
            transition: all .25s var(--ease);
        }
        .btn-solid:hover { background:#FF1A30; box-shadow:0 0 20px var(--red-glow); transform:translateY(-2px); }

        /* ── BUTTONS ── */
        .btn {
            display:inline-flex; align-items:center; gap:9px;
            font-family:var(--font-mono); font-size:.72rem; letter-spacing:2px;
            text-transform:uppercase; padding:13px 30px;
            border-radius:7px; border:none; cursor:pointer;
            text-decoration:none; transition:all .25s var(--ease);
            position:relative; overflow:hidden;
        }
        .btn-primary { background:var(--red); color:#fff; }
        .btn-primary:hover { background:#FF1A30; box-shadow:0 8px 28px var(--red-glow); transform:translateY(-2px); }
        .btn-outline { background:transparent; color:var(--text); border:1px solid var(--border); }
        .btn-outline:hover { border-color:var(--red); color:var(--red); }

        /* ── CARD ── */
        .card {
            background:var(--bg3); border:1px solid var(--border);
            border-radius:14px; padding:28px;
            transition: border-color .3s var(--ease), transform .3s var(--ease), box-shadow .3s var(--ease);
        }
        .card:hover {
            border-color:var(--border-red);
            transform:translateY(-4px);
            box-shadow:0 20px 48px rgba(0,0,0,.5);
        }

        /* ── FORM ── */
        .f-group { margin-bottom:18px; }
        .f-label {
            display:block; font-family:var(--font-mono);
            font-size:.62rem; letter-spacing:2px; text-transform:uppercase;
            color:var(--muted); margin-bottom:7px;
        }
        .f-input {
            width:100%; padding:13px 16px;
            background:var(--bg2); border:1px solid var(--border);
            border-radius:7px; color:var(--text);
            font-family:var(--font-head); font-size:.92rem;
            outline:none; transition:border-color .2s var(--ease), box-shadow .2s var(--ease);
        }
        .f-input:focus {
            border-color:var(--red);
            box-shadow:0 0 0 3px var(--red-glow);
        }
        select.f-input option { background:var(--bg3); }
        textarea.f-input { resize:vertical; }

        /* ── TYPOGRAPHY ── */
        .tag {
            display:inline-flex; align-items:center; gap:7px;
            font-family:var(--font-mono); font-size:.62rem; letter-spacing:3px; text-transform:uppercase;
            color:var(--red); border:1px solid var(--border-red);
            padding:5px 14px; border-radius:100px; margin-bottom:20px;
        }
        .tag .live { width:5px;height:5px;background:var(--red);border-radius:50%;animation:blink 1.4s infinite; }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0} }

        h1,h2,h3 { font-weight:900; letter-spacing:-0.5px; line-height:1.05; }
        .section-sub { font-size:.95rem; color:var(--muted); line-height:1.75; }

        /* ── LAYOUT ── */
        .container { max-width:1240px; margin:0 auto; padding:0 32px; }
        .section { padding:96px 0; }

        /* ── ALERTS ── */
        .alert { padding:13px 18px; border-radius:8px; margin-bottom:18px; font-size:.88rem; border-left:3px solid; }
        .alert-ok  { background:rgba(0,212,164,.08); border-color:var(--success); color:var(--success); }
        .alert-err { background:rgba(217,4,41,.08);  border-color:var(--red);     color:#ff6b6b; }

        /* ── FOOTER ── */
        footer {
            border-top:1px solid var(--border);
            padding:48px 0 28px;
            background:var(--bg2);
        }
        footer .f-top {
            display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:24px;
            padding-bottom:32px; border-bottom:1px solid var(--border);
            margin-bottom:24px;
        }
        footer .f-logo { font-weight:900; font-size:1.2rem; letter-spacing:4px; color:var(--red); }
        footer .f-links { display:flex; gap:28px; list-style:none; }
        footer .f-links a {
            font-family:var(--font-mono); font-size:.62rem; letter-spacing:2px; text-transform:uppercase;
            color:var(--muted); text-decoration:none; transition:color .2s;
        }
        footer .f-links a:hover { color:var(--red); }
        footer .f-copy { font-family:var(--font-mono); font-size:.6rem; letter-spacing:1px; color:rgba(102,102,102,.5); text-align:center; }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width:3px; }
        ::-webkit-scrollbar-track { background:var(--bg); }
        ::-webkit-scrollbar-thumb { background:var(--red); border-radius:2px; }

        /* ── ENTRANCE ── */
        .page-in { animation:pageIn .55s var(--ease) both; }
        @keyframes pageIn { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }

        .reveal { opacity:0; transform:translateY(28px); transition:opacity .65s var(--ease),transform .65s var(--ease); }
        .reveal.in { opacity:1; transform:none; }

        /* ── MOBILE NAV ── */
        .hamburger { display:none; background:none; border:none; cursor:pointer; padding:4px; }
        .hamburger span { display:block; width:22px;height:2px;background:var(--text);margin:5px 0;transition:all .3s; }
        .mobile-menu {
            display:none; flex-direction:column; gap:0;
            position:absolute; top:68px; left:0; right:0;
            background:var(--bg2); border-bottom:1px solid var(--border);
        }
        .mobile-menu.open { display:flex; }
        .mobile-menu a {
            padding:14px 24px; font-size:.8rem; letter-spacing:2px; text-transform:uppercase;
            color:var(--muted); text-decoration:none; border-bottom:1px solid var(--border);
            transition:color .2s;
        }
        .mobile-menu a:hover { color:var(--red); }

        @media(max-width:900px){
            .nav { padding:0 20px; }
            .nav-links,.nav-cta { display:none; }
            .hamburger { display:block; }
            .container { padding:0 18px; }
            .section { padding:64px 0; }
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="c-dot" id="cDot"></div>
<div class="c-ring" id="cRing"></div>

<nav class="nav">
    <a href="{{ route('home') }}" class="nav-logo">
        <div class="dot"></div>BLOODLINK
    </a>
    <ul class="nav-links">
        <li><a href="{{ route('home') }}"         class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
        <li><a href="{{ route('donor.find') }}"   class="{{ request()->routeIs('donor.find') ? 'active' : '' }}">Find Donor</a></li>
        <li><a href="{{ route('emergency.index') }}" class="{{ request()->routeIs('emergency.*') ? 'active' : '' }}">Emergency</a></li>
        <li><a href="{{ route('about') }}"        class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
    </ul>
    <div class="nav-cta">
        @auth
            <a href="{{ route('dashboard') }}" class="btn-solid">Dashboard</a>
        @else
            <a href="{{ route('login') }}"    class="btn-ghost">Sign In</a>
            <a href="{{ route('register') }}" class="btn-solid">Register</a>
        @endauth
    </div>
    <button class="hamburger" onclick="toggleNav()" aria-label="Menu">
        <span></span><span></span><span></span>
    </button>
</nav>

<div class="mobile-menu" id="mobileMenu">
    <a href="{{ route('home') }}">Home</a>
    <a href="{{ route('donor.find') }}">Find Donor</a>
    <a href="{{ route('emergency.index') }}">Emergency</a>
    <a href="{{ route('about') }}">About</a>
    @auth
        <a href="{{ route('dashboard') }}">Dashboard</a>
    @else
        <a href="{{ route('login') }}">Sign In</a>
        <a href="{{ route('register') }}">Register as Donor</a>
    @endauth
</div>

<main class="page-in" style="padding-top:68px">
    @if(session('success'))
        <div class="container" style="padding-top:16px">
            <div class="alert alert-ok"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="container" style="padding-top:16px">
            <div class="alert alert-err"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        </div>
    @endif
    @yield('content')
</main>

<footer>
    <div class="container">
        <div class="f-top">
            <div class="f-logo">BLOODLINK</div>
            <ul class="f-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('donor.find') }}">Find Donor</a></li>
                <li><a href="{{ route('emergency.index') }}">Emergency</a></li>
                <li><a href="{{ route('about') }}">About</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            </ul>
        </div>
        <div class="f-copy">© {{ date('Y') }} BLOODLINK — Every drop counts &nbsp;·&nbsp; Built to save lives</div>
    </div>
</footer>

<script>
// ── CURSOR ──
const cDot = document.getElementById('cDot');
const cRing= document.getElementById('cRing');
let mx=window.innerWidth/2, my=window.innerHeight/2, rx=mx, ry=my;

document.addEventListener('mousemove', e => { mx=e.clientX; my=e.clientY; cDot.style.left=mx+'px'; cDot.style.top=my+'px'; });

(function animRing(){
    rx += (mx-rx)*.1; ry += (my-ry)*.1;
    cRing.style.left=rx+'px'; cRing.style.top=ry+'px';
    requestAnimationFrame(animRing);
})();

['a','button','.btn','.btn-solid','.btn-ghost'].forEach(sel=>{
    document.querySelectorAll(sel).forEach(el=>{
        el.addEventListener('mouseenter',()=>{ cRing.style.width='46px'; cRing.style.height='46px'; cRing.style.opacity='1'; });
        el.addEventListener('mouseleave',()=>{ cRing.style.width='30px'; cRing.style.height='30px'; cRing.style.opacity='.5'; });
    });
});

// ── MOBILE NAV ──
function toggleNav(){
    document.getElementById('mobileMenu').classList.toggle('open');
}

// ── SCROLL REVEAL ──
const io = new IntersectionObserver(entries=>{
    entries.forEach(e=>{ if(e.isIntersecting) e.target.classList.add('in'); });
},{ threshold:.08 });
document.querySelectorAll('.reveal').forEach(el=>io.observe(el));
</script>

@stack('scripts')
</body>
</html>
