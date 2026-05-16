@extends('layouts.app')
@section('title', 'Save Lives Together')

@push('styles')
<style>
/* ── HERO ── */
.hero {
    min-height: calc(100vh - 68px);
    display: grid; grid-template-columns: 1fr 520px;
    align-items: center; gap: 60px;
    padding: 60px 0;
    position: relative; overflow: hidden;
}
.hero-noise {
    position:absolute; inset:0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
    pointer-events:none;
}
.hero-glow {
    position:absolute; top:-20%; right:-10%;
    width:700px; height:700px;
    background:radial-gradient(circle, rgba(139,0,0,.14) 0%, transparent 65%);
    pointer-events:none;
}
.hero-content { position:relative; z-index:2; }

.hero-eyebrow {
    display:inline-flex; align-items:center; gap:8px;
    font-family:var(--font-mono); font-size:.62rem; letter-spacing:3px; text-transform:uppercase;
    color:var(--red); margin-bottom:28px;
}
.hero-eyebrow .live-pill {
    display:flex; align-items:center; gap:6px;
    border:1px solid var(--border-red); border-radius:100px; padding:3px 10px;
}
.hero-eyebrow .dot { width:5px;height:5px;background:var(--red);border-radius:50%;animation:blink 1.4s infinite; }

.hero-h1 {
    font-size: clamp(3.2rem, 7.5vw, 6.8rem);
    line-height: .95; font-weight:900; letter-spacing:-2px;
    margin-bottom: 28px;
}
.hero-h1 em { color:var(--red); font-style:normal; position:relative; }
.hero-h1 em::after {
    content:''; position:absolute; bottom:6px; left:0; right:0;
    height:3px; background:var(--red); opacity:.4;
    transform:scaleX(0); transform-origin:left;
    animation:lineGrow 1s .8s forwards;
}
@keyframes lineGrow { to{transform:scaleX(1)} }

.hero-desc { font-size:1rem; color:var(--muted); line-height:1.8; max-width:480px; margin-bottom:36px; }
.hero-btns { display:flex; gap:14px; flex-wrap:wrap; margin-bottom:52px; }

.hero-kpis { display:flex; gap:40px; }
.kpi-val { font-size:2.2rem; font-weight:900; color:var(--red); line-height:1; }
.kpi-lbl { font-family:var(--font-mono); font-size:.58rem; letter-spacing:2px; text-transform:uppercase; color:var(--muted); margin-top:3px; }

/* ── 3D CANVAS ── */
#canvas3d {
    width:100%; height:500px;
    position:relative; z-index:2;
    display:flex; align-items:center; justify-content:center;
}
#canvas3d canvas { border-radius:16px; }

/* ── TICKER ── */
.ticker-bar {
    background:var(--red-deep); padding:10px 0; overflow:hidden;
    border-top:1px solid rgba(255,255,255,.06);
    border-bottom:1px solid rgba(255,255,255,.06);
}
.ticker-inner { display:flex; gap:60px; animation:ticker 28s linear infinite; white-space:nowrap; }
@keyframes ticker { from{transform:translateX(0)} to{transform:translateX(-50%)} }
.ticker-item {
    font-family:var(--font-mono); font-size:.65rem; letter-spacing:2px; text-transform:uppercase;
    color:rgba(255,255,255,.7); display:flex; align-items:center; gap:10px; flex-shrink:0;
}
.ticker-item i { color:var(--red); }

/* ── PROCESS ── */
.process-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-top:56px; }
.process-card {
    background:var(--bg3); border:1px solid var(--border); border-radius:14px; padding:30px 24px;
    position:relative; overflow:hidden;
    transition: border-color .3s,transform .3s,box-shadow .3s;
}
.process-card:hover { border-color:var(--border-red); transform:translateY(-5px); box-shadow:0 20px 44px rgba(0,0,0,.5); }
.process-num {
    position:absolute; top:16px; right:18px;
    font-size:5rem; font-weight:900; color:rgba(139,0,0,.07); line-height:1;
    pointer-events:none; user-select:none;
}
.process-icon {
    width:50px; height:50px; border-radius:12px;
    background:rgba(139,0,0,.1); display:flex; align-items:center; justify-content:center;
    font-size:1.3rem; color:var(--red); margin-bottom:18px;
}
.process-title { font-size:1rem; font-weight:700; letter-spacing:.5px; margin-bottom:10px; }
.process-desc { font-size:.85rem; color:var(--muted); line-height:1.7; }

/* ── BLOOD TYPES ── */
.blood-grid {
    display:grid; grid-template-columns:repeat(8,1fr); gap:14px; margin-top:52px;
}
.blood-cell {
    aspect-ratio:1; border-radius:12px;
    background:var(--bg3); border:1px solid var(--border);
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    gap:5px; cursor:pointer; text-decoration:none;
    transition: all .3s var(--ease);
}
.blood-cell:hover {
    background:var(--red); border-color:var(--red);
    transform:scale(1.08); box-shadow:0 10px 30px var(--red-glow);
}
.blood-cell .t { font-size:1.5rem; font-weight:900; color:var(--text); transition:color .3s; }
.blood-cell .c { font-family:var(--font-mono); font-size:.55rem; letter-spacing:1px; color:var(--muted); transition:color .3s; }
.blood-cell:hover .t { color:#fff; }
.blood-cell:hover .c { color:rgba(255,255,255,.7); }

/* ── CTA ── */
.cta-wrap {
    background:var(--bg2); border:1px solid var(--border); border-radius:20px;
    padding:72px 60px; text-align:center; position:relative; overflow:hidden;
}
.cta-wrap::before {
    content:''; position:absolute; inset:0;
    background:radial-gradient(ellipse 60% 80% at 50% 50%, rgba(139,0,0,.12) 0%, transparent 70%);
    pointer-events:none;
}

/* ── 3D FLOATING ELEMENTS ── */
.float-badge {
    position:absolute;
    background:var(--bg2); border:1px solid var(--border); border-radius:12px;
    padding:12px 18px; display:flex; align-items:center; gap:10px;
    animation:floatBadge 4s ease-in-out infinite;
    font-size:.78rem; font-weight:600; pointer-events:none;
}
.float-badge.top    { top:8%;  right:5%; animation-delay:0s; }
.float-badge.bottom { bottom:10%; left:2%; animation-delay:2s; }
@keyframes floatBadge {
    0%,100%{transform:translateY(0)}
    50%{transform:translateY(-12px)}
}

@media(max-width:1024px){
    .hero { grid-template-columns:1fr; padding:40px 0; text-align:center; }
    #canvas3d { height:380px; }
    .hero-btns { justify-content:center; }
    .hero-kpis { justify-content:center; }
    .process-grid { grid-template-columns:1fr 1fr; }
    .blood-grid { grid-template-columns:repeat(4,1fr); }
}
@media(max-width:640px){
    .process-grid { grid-template-columns:1fr; }
    .blood-grid { grid-template-columns:repeat(4,1fr); }
    .hero-h1 { letter-spacing:-1px; }
}
</style>
@endpush

@section('content')

<!-- ── EMERGENCY TICKER ── -->
<div class="ticker-bar">
    <div class="ticker-inner">
        @php
            $tickerItems = $latestRequests->count() > 0
                ? $latestRequests->map(fn($r) => $r->blood_type.' '.strtoupper($r->urgency).' — '.$r->hospital_name.' '.$r->city)->toArray()
                : ['B+ Needed — Services Hospital Lahore','O- Critical — Aga Khan Karachi','A+ Urgent — PIMS Islamabad','AB- Required — Mayo Hospital Lahore','O+ Needed — Lady Reading Peshawar'];
            $tickerDouble = array_merge($tickerItems, $tickerItems);
        @endphp
        @foreach($tickerDouble as $item)
            <div class="ticker-item"><i class="fas fa-tint"></i> {{ $item }}</div>
        @endforeach
    </div>
</div>

<!-- ── HERO ── -->
<div class="section" style="padding-bottom:40px">
<div class="container">
<div class="hero">
    <div class="hero-noise"></div>
    <div class="hero-glow"></div>

    <div class="hero-content">
        <div class="hero-eyebrow">
            <div class="live-pill"><div class="dot"></div>Network Live</div>
            Pakistan's #1 Blood Donor Network
        </div>
        <h1 class="hero-h1">GIVE<br>BLOOD<br><em>SAVE LIFE</em></h1>
        <p class="hero-desc">Every 2 seconds, someone in Pakistan needs blood. BloodLink connects verified donors with patients in real time — cutting search time from hours to minutes.</p>
        <div class="hero-btns">
            <a href="{{ route('emergency.form') }}" class="btn btn-primary"><i class="fas fa-broadcast-tower"></i> Request Blood Now</a>
            <a href="{{ route('donor.find') }}" class="btn btn-outline"><i class="fas fa-map-marker-alt"></i> Find Donors</a>
        </div>
        <div class="hero-kpis">
            <div><div class="kpi-val" data-to="12847">0</div><div class="kpi-lbl">Active Donors</div></div>
            <div><div class="kpi-val" data-to="5423">0</div><div class="kpi-lbl">Lives Saved</div></div>
            <div><div class="kpi-val" data-to="247">0</div><div class="kpi-lbl">Cities</div></div>
        </div>
    </div>

    <div id="canvas3d" style="position:relative">
        <canvas id="threeCanvas"></canvas>
        <div class="float-badge top">
            <i class="fas fa-heartbeat" style="color:var(--red)"></i>
            <div><div style="font-size:.62rem;color:var(--muted);font-family:var(--font-mono);letter-spacing:1px;text-transform:uppercase">Response Time</div><div style="font-weight:700">Under 4 Minutes</div></div>
        </div>
        <div class="float-badge bottom">
            <i class="fas fa-shield-alt" style="color:var(--success)"></i>
            <div><div style="font-size:.62rem;color:var(--muted);font-family:var(--font-mono);letter-spacing:1px;text-transform:uppercase">Verified Donors</div><div style="font-weight:700">100% Screened</div></div>
        </div>
    </div>
</div>
</div>
</div>

<!-- ── PROCESS ── -->
<div class="section" style="background:var(--bg2);padding:80px 0">
<div class="container">
    <div class="reveal"><div class="tag"><div class="live" style="background:var(--red)"></div>Process</div></div>
    <div class="reveal" style="transition-delay:.1s"><h2 style="font-size:clamp(2rem,5vw,3.5rem)">HOW IT <em style="color:var(--red)">WORKS</em></h2></div>
    <div class="process-grid">
        @php $steps = [
            ['fa-user-plus','Register','Sign up as a donor in 2 minutes — your blood type, city, and availability go live on the map immediately.'],
            ['fa-search-location','Match','Our system instantly matches emergency requests with the nearest available, compatible verified donors.'],
            ['fa-bell','Get Alerted','Donors receive a WhatsApp notification with the patient name, hospital, and urgency level.'],
            ['fa-heart','Donate','Arrive at the hospital and save a life. Your impact is tracked on your personal donor dashboard.'],
        ]; @endphp
        @foreach($steps as $i=>$s)
        <div class="process-card reveal" style="transition-delay:{{ $i*0.1 }}s">
            <div class="process-num">0{{ $i+1 }}</div>
            <div class="process-icon"><i class="fas {{ $s[0] }}"></i></div>
            <div class="process-title">{{ $s[1] }}</div>
            <p class="process-desc">{{ $s[2] }}</p>
        </div>
        @endforeach
    </div>
</div>
</div>

<!-- ── BLOOD TYPES ── -->
<div class="section">
<div class="container">
    <div class="reveal"><div class="tag">All Blood Groups</div></div>
    <div class="reveal" style="transition-delay:.1s"><h2 style="font-size:clamp(2rem,5vw,3.5rem)">FIND BY <em style="color:var(--red)">BLOOD TYPE</em></h2></div>
    <div class="blood-grid">
        @php $types=['A+'=>342,'A-'=>89,'B+'=>518,'B-'=>103,'AB+'=>201,'AB-'=>47,'O+'=>687,'O-'=>156]; @endphp
        @foreach($types as $t=>$n)
        <a href="{{ route('donor.find',['blood_type'=>$t]) }}" class="blood-cell reveal">
            <div class="t">{{ $t }}</div>
            <div class="c">{{ $n }}</div>
        </a>
        @endforeach
    </div>
</div>
</div>

<!-- ── CTA ── -->
<div class="section" style="padding-top:0">
<div class="container">
    <div class="cta-wrap reveal">
        <div style="position:relative;z-index:2">
            <div class="tag" style="justify-content:center;display:inline-flex">Become a Hero</div>
            <h2 style="font-size:clamp(2.2rem,6vw,4rem);margin-bottom:18px">YOUR DONATION<br>SAVES <em style="color:var(--red)">3 LIVES</em></h2>
            <p class="section-sub" style="max-width:480px;margin:0 auto 36px">Registration takes 2 minutes. Donating blood takes 20 minutes. The impact lasts a lifetime.</p>
            <div style="display:flex;justify-content:center;gap:14px;flex-wrap:wrap">
                <a href="{{ route('register') }}" class="btn btn-primary" style="padding:15px 40px"><i class="fas fa-tint"></i> Register as Donor</a>
                <a href="{{ route('donor.find') }}" class="btn btn-outline" style="padding:15px 40px">Search Donors</a>
            </div>
        </div>
    </div>
</div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
// ── OPTIMISED THREE.JS ── (no lag, requestAnimationFrame with delta)
(function(){
    const canvas = document.getElementById('threeCanvas');
    const wrap   = document.getElementById('canvas3d');

    const renderer = new THREE.WebGLRenderer({ canvas, antialias:true, alpha:true, powerPreference:'high-performance' });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio,2));
    renderer.setClearColor(0x000000,0);

    const scene  = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(48,1,0.1,100);
    camera.position.z = 5;

    function resize(){
        const w=wrap.clientWidth, h=wrap.clientHeight;
        renderer.setSize(w,h,false);
        camera.aspect = w/h;
        camera.updateProjectionMatrix();
    }
    resize();
    window.addEventListener('resize', resize, {passive:true});

    // ── Lights ──
    scene.add(new THREE.AmbientLight(0xffffff, 0.3)); // Further reduced to remove white washout
    const pL1 = new THREE.PointLight(0x8b0000, 5, 20);
    pL1.position.set(3,3,3);
    scene.add(pL1);
    const pL2 = new THREE.PointLight(0x5d0000, 3, 15);
    pL2.position.set(-3,-2,2);
    scene.add(pL2);
    const dL = new THREE.DirectionalLight(0x8b0000, 0.5);
    dL.position.set(0,5,5);
    scene.add(dL);

    // ── Blood Drop Group ──
    const group = new THREE.Group();
    scene.add(group);

    const mat = new THREE.MeshPhongMaterial({
        color: 0x8b0000,
        emissive: 0x050000,
        specular: 0x000000,
        shininess: 0,
        transparent: true,
        opacity: 0.98
    });

    // Sphere body
    const sphere = new THREE.Mesh(new THREE.SphereGeometry(.95,64,64), mat);
    sphere.position.y = -.25;
    group.add(sphere);

    // Cone top
    const cone = new THREE.Mesh(new THREE.ConeGeometry(.55,1.5,64), mat);
    cone.position.y = .8;
    group.add(cone);

    // Inner glow removed

    // ── Orbiting Rings ──
    const ring1 = new THREE.Mesh(
        new THREE.TorusGeometry(1.9,.012,12,80),
        new THREE.MeshBasicMaterial({color:0x8b0000,transparent:true,opacity:.35})
    );
    ring1.rotation.x = Math.PI/2;
    scene.add(ring1);

    const ring2 = new THREE.Mesh(
        new THREE.TorusGeometry(2.5,.007,12,80),
        new THREE.MeshBasicMaterial({color:0x5d0000,transparent:true,opacity:.18})
    );
    ring2.rotation.x = Math.PI/3;
    scene.add(ring2);

    // ── Particles (reduced count for performance) ──
    const pCount = 60;
    const pGeo = new THREE.BufferGeometry();
    const pPos = new Float32Array(pCount*3);
    for(let i=0;i<pCount;i++){
        pPos[i*3]   = (Math.random()-.5)*10;
        pPos[i*3+1] = (Math.random()-.5)*10;
        pPos[i*3+2] = (Math.random()-.5)*4;
    }
    pGeo.setAttribute('position', new THREE.BufferAttribute(pPos,3));
    const particles = new THREE.Points(pGeo, new THREE.PointsMaterial({color:0x8b0000,size:.05,transparent:true,opacity:.55}));
    scene.add(particles);

    // ── Mouse ──
    let mX=0, mY=0;
    document.addEventListener('mousemove', e=>{
        mX = (e.clientX/window.innerWidth-.5)*2;
        mY = (e.clientY/window.innerHeight-.5)*2;
    },{passive:true});

    // ── Loop ──
    let t=0;
    (function loop(){
        requestAnimationFrame(loop);
        t += .012;
        group.rotation.y += .007;
        group.rotation.x += (mY*.25 - group.rotation.x)*.04;
        group.rotation.z += (-mX*.15 - group.rotation.z)*.04;
        group.position.y = Math.sin(t)*.14;
        ring1.rotation.z += .004;
        ring2.rotation.y += .006;
        particles.rotation.y += .0008;
        pL1.position.x = Math.sin(t*.8)*4;
        pL1.position.y = Math.cos(t*.6)*3;
        renderer.render(scene,camera);
    })();
})();

// ── COUNTER ANIMATION ──
const counterObs = new IntersectionObserver(entries=>{
    entries.forEach(e=>{
        if(!e.isIntersecting) return;
        const el=e.target, to=+el.dataset.to, dur=1800;
        let start=null;
        function step(ts){
            if(!start) start=ts;
            const p=Math.min((ts-start)/dur,1);
            el.textContent = Math.floor(p*p*(3-2*p)*to).toLocaleString(); // ease
            if(p<1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
        counterObs.unobserve(el);
    });
},{ threshold:.6 });
document.querySelectorAll('[data-to]').forEach(el=>counterObs.observe(el));

// ── SCROLL REVEAL (already in layout, extra trigger for new elements) ──
const revObs = new IntersectionObserver(entries=>{
    entries.forEach(e=>{ if(e.isIntersecting) e.target.classList.add('in'); });
},{ threshold:.08 });
document.querySelectorAll('.reveal').forEach(el=>revObs.observe(el));
</script>
@endpush
