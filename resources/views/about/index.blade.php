@extends('layouts.app')
@section('title', 'About BloodLink')

@push('styles')
<style>
.about-hero {
    padding:130px 0 80px; text-align:center; position:relative; overflow:hidden;
}
.about-hero::before {
    content:''; position:absolute; inset:0;
    background:radial-gradient(ellipse 65% 55% at 50% 30%, rgba(139,0,0,.12) 0%, transparent 70%);
    pointer-events:none;
}
.about-big { font-size:clamp(3.5rem,11vw,9rem); font-weight:900; line-height:.9; letter-spacing:-3px; }
.about-big em { color:var(--red); font-style:normal; }

.split { display:grid; grid-template-columns:1fr 1fr; gap:80px; align-items:center; }
.split-visual {
    background:var(--bg3); border:1px solid var(--border); border-radius:20px;
    height:400px; display:flex; align-items:center; justify-content:center;
    position:relative; overflow:hidden;
}
.vis-3d-canvas { width:100%; height:100%; }

.val-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-top:56px; }
.val-card {
    background:var(--bg3); border:1px solid var(--border); border-radius:14px; padding:28px;
    transition:all .25s var(--ease);
}
.val-card:hover { border-color:var(--border-red); transform:translateY(-4px); }
.val-icon {
    width:46px; height:46px; border-radius:11px;
    background:rgba(139,0,0,.1); display:flex; align-items:center; justify-content:center;
    color:var(--red); font-size:1.1rem; margin-bottom:16px;
}
.val-title { font-size:1rem; font-weight:800; letter-spacing:.5px; margin-bottom:8px; }
.val-desc  { font-size:.85rem; color:var(--muted); line-height:1.7; }

.impact-row { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-top:52px; }
.impact-card {
    background:var(--bg3); border:1px solid var(--border); border-radius:14px; padding:28px 20px;
    text-align:center; transition:all .25s;
}
.impact-card:hover { border-color:var(--border-red); transform:translateY(-4px); }
.impact-val { font-size:2.5rem; font-weight:900; color:var(--red); line-height:1; margin-bottom:6px; }
.impact-lbl { font-family:var(--font-mono); font-size:.6rem; letter-spacing:2px; text-transform:uppercase; color:var(--muted); }

@media(max-width:900px){
    .split       { grid-template-columns:1fr; gap:40px; }
    .split-visual{ display:none; }
    .val-grid    { grid-template-columns:1fr; }
    .impact-row  { grid-template-columns:1fr 1fr; }
}
@media(max-width:480px){ .impact-row { grid-template-columns:1fr 1fr; } }
</style>
@endpush

@section('content')

<!-- Hero -->
<div class="about-hero">
    <div class="container" style="position:relative;z-index:2">
        <div class="tag" style="justify-content:center;display:inline-flex;margin-bottom:28px">Our Mission</div>
        <div class="about-big">SAVING<br>LIVES<br><em>TOGETHER</em></div>
        <p class="section-sub" style="max-width:560px;margin:28px auto 0;font-size:1rem">
            BloodLink was born from one belief: no one should die waiting for blood when a matching donor is just kilometres away.
        </p>
    </div>
</div>

<!-- Mission Split -->
<div class="section" style="padding-top:40px">
<div class="container">
<div class="split reveal">
    <div class="split-visual">
        <canvas id="aboutCanvas" class="vis-3d-canvas"></canvas>
    </div>
    <div>
        <div class="tag">Who We Are</div>
        <h2 style="font-size:clamp(2rem,5vw,3.2rem);margin-bottom:20px">MORE THAN<br>AN <em style="color:var(--red)">APP</em></h2>
        <p class="section-sub" style="margin-bottom:20px">
            BloodLink is Pakistan's fastest-growing voluntary blood donor network. We use technology to connect verified donors with patients in real time — cutting the average blood-search time from hours to under 4 minutes.
        </p>
        <p class="section-sub" style="margin-bottom:32px">
            Founded in 2022, we've grown to 12,000+ active donors across 247 cities. Our platform operates 24/7, ensuring no emergency goes unanswered.
        </p>
        <a href="{{ route('register') }}" class="btn btn-primary"><i class="fas fa-user-plus"></i> Join the Network</a>
    </div>
</div>
</div>
</div>

<!-- Impact Numbers -->
<div style="background:var(--bg2);padding:80px 0;border-top:1px solid var(--border);border-bottom:1px solid var(--border)">
<div class="container">
    <div class="reveal" style="text-align:center;margin-bottom:0">
        <div class="tag" style="justify-content:center;display:inline-flex">Real Impact</div>
        <h2 style="font-size:clamp(2rem,5vw,3.2rem);margin-bottom:0">BY THE <em style="color:var(--red)">NUMBERS</em></h2>
    </div>
    <div class="impact-row">
        @php $impacts=[['12,847','Active Donors'],['5,423','Lives Saved'],['247','Cities Covered'],['< 4 min','Avg. Response']]; @endphp
        @foreach($impacts as $imp)
        <div class="impact-card reveal">
            <div class="impact-val">{{ $imp[0] }}</div>
            <div class="impact-lbl">{{ $imp[1] }}</div>
        </div>
        @endforeach
    </div>
</div>
</div>

<!-- Values -->
<div class="section">
<div class="container">
    <div class="reveal"><div class="tag">Core Values</div></div>
    <div class="reveal" style="transition-delay:.1s">
        <h2 style="font-size:clamp(2rem,5vw,3.2rem);margin-bottom:0">WHAT WE <em style="color:var(--red)">BELIEVE</em></h2>
    </div>
    <div class="val-grid">
        @php $vals=[
            ['fa-bolt','Speed First','Every second matters in a blood emergency. Our system notifies the nearest compatible donors in under 30 seconds of a request being submitted.'],
            ['fa-shield-alt','Trust & Safety','All donors are screened. All requests are verified. Patient safety and donor privacy are our highest commitments — always.'],
            ['fa-globe-asia','Nationwide Reach','From Karachi to Chitral — our network covers every major city and is actively growing into smaller towns and rural areas.'],
            ['fa-hands-helping','Community Power','BloodLink is built on the generosity of ordinary people doing extraordinary things. Every donor is a hero in our eyes.'],
        ]; @endphp
        @foreach($vals as $i=>$v)
        <div class="val-card reveal" style="transition-delay:{{ $i*.08 }}s">
            <div class="val-icon"><i class="fas {{ $v[0] }}"></i></div>
            <div class="val-title">{{ $v[1] }}</div>
            <p class="val-desc">{{ $v[2] }}</p>
        </div>
        @endforeach
    </div>
</div>
</div>

<!-- CTA -->
<div style="background:var(--bg2);border-top:1px solid var(--border);padding:80px 0">
<div class="container" style="text-align:center">
    <div class="reveal">
        <div class="tag" style="justify-content:center;display:inline-flex;margin-bottom:20px">Take Action</div>
        <h2 style="font-size:clamp(2rem,6vw,4rem);margin-bottom:16px">READY TO <em style="color:var(--red)">SAVE A LIFE?</em></h2>
        <p class="section-sub" style="max-width:460px;margin:0 auto 36px">Registration takes 2 minutes. Donating takes 20 minutes. The impact lasts forever.</p>
        <div style="display:flex;justify-content:center;gap:14px;flex-wrap:wrap">
            <a href="{{ route('register') }}"     class="btn btn-primary" style="padding:14px 36px"><i class="fas fa-tint"></i> Become a Donor</a>
            <a href="{{ route('emergency.form') }}" class="btn btn-outline" style="padding:14px 36px"><i class="fas fa-exclamation-triangle"></i> Request Blood</a>
        </div>
    </div>
</div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
// ── About page 3D DNA-style helix visualization ──
(function(){
    const canvas = document.getElementById('aboutCanvas');
    if(!canvas) return;
    const wrap = canvas.parentElement;

    const renderer = new THREE.WebGLRenderer({canvas,antialias:true,alpha:true,powerPreference:'high-performance'});
    renderer.setPixelRatio(Math.min(window.devicePixelRatio,2));
    renderer.setClearColor(0,0);

    const scene = new THREE.Scene();
    const camera= new THREE.PerspectiveCamera(48,1,0.1,100);
    camera.position.set(0,0,7);

    function resize(){
        const w=wrap.clientWidth, h=wrap.clientHeight;
        renderer.setSize(w,h,false);
        camera.aspect=w/h;
        camera.updateProjectionMatrix();
    }
    resize();
    window.addEventListener('resize',resize,{passive:true});

    scene.add(new THREE.AmbientLight(0xffffff, 0.4));
    const pl = new THREE.PointLight(0x8b0000, 4, 20);
    pl.position.set(2,3,3);
    scene.add(pl);

    // Helix of spheres
    const sphMat = new THREE.MeshPhongMaterial({color:0x8b0000, shininess:20, specular:0x330000}); // Dark Blood Red strand
    const lineMat = new THREE.MeshBasicMaterial({color:0x64748B, transparent:true, opacity:.4}); // Slate Gray connectors
    const group  = new THREE.Group();
    scene.add(group);

    const N = 32, R = 1.3, pitch = 0.22;
    for(let i=0; i<N; i++){
        const t = (i/N) * Math.PI * 5; // 2.5 turns
        
        // strand 1
        const s1 = new THREE.Mesh(new THREE.SphereGeometry(.12, 16, 16), sphMat);
        s1.position.set(Math.cos(t)*R, (i-N/2)*pitch, Math.sin(t)*R);
        group.add(s1);
        
        // strand 2 (opposite) - Royal Navy Blue
        const s2 = new THREE.Mesh(new THREE.SphereGeometry(.12, 16, 16), new THREE.MeshPhongMaterial({color:0x0A2540, shininess:60}));
        s2.position.set(Math.cos(t+Math.PI)*R, (i-N/2)*pitch, Math.sin(t+Math.PI)*R);
        group.add(s2);
        
        // connector (every base pair for a consistent rhythm)
        const p1 = s1.position, p2 = s2.position;
        const mid = new THREE.Vector3().addVectors(p1,p2).multiplyScalar(.5);
        const len = p1.distanceTo(p2);
        const cyl = new THREE.Mesh(new THREE.CylinderGeometry(.02, .02, len, 8), lineMat);
        cyl.position.copy(mid);
        cyl.lookAt(p2);
        cyl.rotateX(Math.PI/2);
        group.add(cyl);
    }

    // Soft Crimson glow sphere
    const glowMesh = new THREE.Mesh(
        new THREE.SphereGeometry(2.5,32,32),
        new THREE.MeshBasicMaterial({color:0x8b0000, transparent:true, opacity:.05, side:THREE.BackSide})
    );
    scene.add(glowMesh);

    let t2=0;
    (function loop(){
        requestAnimationFrame(loop);
        t2+=.008;
        group.rotation.y=t2;
        group.position.y=Math.sin(t2*.7)*.15;
        pl.position.x=Math.sin(t2)*3;
        renderer.render(scene,camera);
    })();
})();

// Reveal
const ro=new IntersectionObserver(e=>e.forEach(x=>{if(x.isIntersecting)x.target.classList.add('in');}),{threshold:.06});
document.querySelectorAll('.reveal').forEach(el=>ro.observe(el));
</script>
@endpush
