@extends('layouts.app')
@section('title', 'Dashboard')

@push('styles')
<style>
.dash-grid {
    display:grid; grid-template-columns:260px 1fr;
    min-height:calc(100vh - 68px);
}
.dash-sidebar {
    background:var(--bg2); border-right:1px solid var(--border);
    padding:32px 20px; position:sticky; top:68px; height:calc(100vh - 68px);
    display:flex; flex-direction:column; overflow-y:auto;
}
.user-card { text-align:center; padding:20px 0 28px; border-bottom:1px solid var(--border); margin-bottom:24px; }
.u-avatar {
    width:68px; height:68px; border-radius:50%;
    background:var(--red); display:flex; align-items:center; justify-content:center;
    font-size:1.6rem; font-weight:900; margin:0 auto 14px;
    box-shadow:0 0 0 4px rgba(217,4,41,.15), 0 0 0 8px rgba(217,4,41,.06);
}
.u-name  { font-size:.95rem; font-weight:700; margin-bottom:8px; }
.u-blood { display:inline-block; background:var(--red); padding:2px 14px; border-radius:100px; font-size:.88rem; font-weight:900; }
.u-city  { font-family:var(--font-mono); font-size:.6rem; letter-spacing:1px; text-transform:uppercase; color:var(--muted); margin-top:6px; }

.avail-row {
    display:flex; align-items:center; justify-content:space-between;
    padding:12px 14px; background:var(--bg3); border-radius:10px;
    border:1px solid var(--border); margin-bottom:20px; cursor:pointer;
    transition:border-color .2s;
}
.avail-row:hover { border-color:var(--border-red); }
.avail-label { font-family:var(--font-mono); font-size:.6rem; letter-spacing:2px; text-transform:uppercase; color:var(--muted); }
.avail-status { font-size:.82rem; font-weight:600; }
.toggle { width:44px; height:24px; border-radius:12px; background:var(--bg); position:relative; transition:background .3s; }
.toggle.on { background:var(--red); }
.toggle::after { content:''; position:absolute; top:3px; left:3px; width:18px; height:18px; border-radius:50%; background:white; transition:transform .3s; box-shadow:0 1px 4px rgba(0,0,0,.4); }
.toggle.on::after { transform:translateX(20px); }

.dash-nav { list-style:none; flex:1; }
.dash-nav li { margin-bottom:2px; }
.dash-nav a { display:flex; align-items:center; gap:12px; padding:11px 14px; border-radius:9px; color:var(--muted); font-size:.88rem; text-decoration:none; transition:all .2s; }
.dash-nav a:hover { background:var(--bg3); color:var(--text); }
.dash-nav a.act  { background:rgba(217,4,41,.1); color:var(--text); border-left:3px solid var(--red); }
.dash-nav .ico   { width:18px; text-align:center; color:var(--red); font-size:.85rem; }
.dash-nav .badge { margin-left:auto; background:var(--red); border-radius:100px; padding:1px 7px; font-size:.58rem; color:#fff; font-weight:700; }
.dash-bottom { margin-top:auto; padding-top:20px; }

/* MAIN */
.dash-main { padding:36px 40px; overflow-y:auto; }
.dash-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:36px; flex-wrap:wrap; gap:16px; }
.dash-greeting { font-size:1.5rem; font-weight:900; letter-spacing:-1px; }

/* Become Donor Banner */
.become-donor-banner {
    background: var(--bg3); border: 1px solid var(--border-red);
    border-radius: 14px; padding: 24px 28px;
    display: flex; align-items: center; gap: 20px; justify-content: space-between;
    margin-bottom: 28px; flex-wrap: wrap;
}
.bdb-text h3 { font-size: 1rem; font-weight: 800; margin-bottom: 4px; }
.bdb-text p  { font-size: .82rem; color: var(--muted); }

/* Stats */
.stats-row { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:28px; }
.stat-box { background:var(--bg3); border:1px solid var(--border); border-radius:13px; padding:24px 20px; transition:all .25s var(--ease); }
.stat-box:hover { border-color:var(--border-red); transform:translateY(-3px); }
.stat-ico  { font-size:1.1rem; color:var(--red); margin-bottom:14px; }
.stat-val  { font-size:2rem; font-weight:900; line-height:1; margin-bottom:4px; }
.stat-lbl  { font-family:var(--font-mono); font-size:.58rem; letter-spacing:2px; text-transform:uppercase; color:var(--muted); }

/* Requests */
.section-bar { display:flex; align-items:center; justify-content:space-between; margin-bottom:18px; }
.section-bar h3 { font-size:1rem; font-weight:900; letter-spacing:1px; }
.section-bar a  { font-family:var(--font-mono); font-size:.6rem; letter-spacing:2px; text-transform:uppercase; color:var(--red); text-decoration:none; }

.req-list { display:flex; flex-direction:column; gap:12px; }
.req-item {
    background:var(--bg3); border:1px solid var(--border);
    border-radius:12px; padding:18px 20px;
    display:flex; align-items:center; gap:16px; flex-wrap:wrap;
    transition:all .2s; border-left:3px solid var(--red);
}
.req-item:hover { border-color:var(--border-red); transform:translateX(3px); }
.req-blood { width:50px; height:50px; border-radius:10px; background:var(--red); display:flex; align-items:center; justify-content:center; font-size:1rem; font-weight:900; flex-shrink:0; box-shadow:0 4px 14px var(--red-glow); }
.req-info  { flex:1; min-width:150px; }
.req-title { font-size:.9rem; font-weight:700; margin-bottom:3px; }
.req-meta  { font-family:var(--font-mono); font-size:.58rem; letter-spacing:1px; text-transform:uppercase; color:var(--muted); }
.urg-badge { padding:3px 10px; border-radius:100px; font-family:var(--font-mono); font-size:.58rem; letter-spacing:1px; text-transform:uppercase; font-weight:700; }
.urg-critical { background:rgba(217,4,41,.12); color:var(--red); }
.urg-urgent   { background:rgba(245,166,35,.12); color:var(--warning); }
.urg-normal   { background:rgba(0,212,164,.12); color:var(--success); }

.wa-btn { font-family:var(--font-mono); font-size:.6rem; letter-spacing:1.5px; text-transform:uppercase; padding:8px 16px; border-radius:7px; text-decoration:none; background:rgba(37,211,102,.1); color:#25d366; border:1px solid rgba(37,211,102,.2); transition:all .2s; white-space:nowrap; display:inline-flex; align-items:center; gap:6px; }
.wa-btn:hover { background:#25d366; color:#fff; }

.empty-state { text-align:center; padding:40px; color:var(--muted); }
.empty-state i { font-size:2rem; margin-bottom:12px; display:block; color:var(--border); }

@media(max-width:1100px){ .stats-row { grid-template-columns:1fr 1fr; } }
@media(max-width:900px){ .dash-grid { grid-template-columns:1fr; } .dash-sidebar { display:none; } .dash-main { padding:20px 16px; } }
</style>
@endpush

@section('content')
<div class="dash-grid">

    <!-- SIDEBAR -->
    <aside class="dash-sidebar">
        <div class="user-card">
            <div class="u-avatar">{{ strtoupper(substr(Auth::user()->first_name ?? Auth::user()->name, 0, 1)) }}</div>
            <div class="u-name">{{ Auth::user()->first_name ?? '' }} {{ Auth::user()->last_name ?? '' }}</div>
            <div><span class="u-blood">{{ Auth::user()->blood_type ?? '—' }}</span></div>
            <div class="u-city">📍 {{ Auth::user()->city ?? 'Unknown' }}</div>
        </div>

        @if($isDonor)
        <div class="avail-row" onclick="toggleAvail()" id="availRow">
            <div>
                <div class="avail-label">Availability</div>
                <div class="avail-status" id="availTxt" style="color:{{ Auth::user()->is_available ? 'var(--success)' : 'var(--muted)' }}">
                    {{ Auth::user()->is_available ? 'Available Now' : 'Not Available' }}
                </div>
            </div>
            <div class="toggle {{ Auth::user()->is_available ? 'on' : '' }}" id="toggleEl"></div>
        </div>
        @endif

        <ul class="dash-nav">
            <li><a href="{{ route('dashboard') }}" class="act"><span class="ico"><i class="fas fa-home"></i></span> Dashboard</a></li>
            <li><a href="{{ route('emergency.index') }}"><span class="ico"><i class="fas fa-bell"></i></span> Emergency Requests <span class="badge">{{ $requests->count() }}</span></a></li>
            <li><a href="{{ route('donor.find') }}"><span class="ico"><i class="fas fa-map-marker-alt"></i></span> Find Donors</a></li>
            <li><a href="{{ route('emergency.form') }}"><span class="ico"><i class="fas fa-plus"></i></span> Post Emergency</a></li>
        </ul>

        <div class="dash-bottom">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="width:100%;padding:11px;background:transparent;border:1px solid var(--border);border-radius:9px;color:var(--muted);font-family:var(--font-mono);font-size:.6rem;letter-spacing:2px;text-transform:uppercase;cursor:pointer;transition:all .2s">
                    <i class="fas fa-sign-out-alt" style="margin-right:6px"></i> Sign Out
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="dash-main">
        <div class="dash-head">
            <div>
                <div class="tag" style="margin-bottom:10px"><div class="live"></div>Donor Portal</div>
                <div class="dash-greeting">WELCOME, <span style="color:var(--red)">{{ strtoupper(Auth::user()->first_name ?? 'BACK') }}</span></div>
            </div>
            <a href="{{ route('emergency.form') }}" class="btn btn-primary" style="font-size:.65rem;padding:11px 20px">
                <i class="fas fa-exclamation-triangle"></i> Emergency Request
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-ok" style="margin-bottom:24px"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        {{-- Become Donor Banner (if not donor yet) --}}
        @if(!$isDonor)
        <div class="become-donor-banner">
            <div class="bdb-text">
                <h3>🩸 Want to save lives?</h3>
                <p>You're not listed as a donor yet. Enable donor status to appear in the donor directory!</p>
            </div>
            <form method="POST" action="{{ route('donor.become') }}" style="flex-shrink:0">
                @csrf
                <button type="submit" class="btn btn-primary" style="font-size:.68rem;padding:11px 24px">
                    <i class="fas fa-user-plus"></i> Become a Donor Now
                </button>
            </form>
        </div>
        @endif

        <!-- Stats -->
        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-ico"><i class="fas fa-tint"></i></div>
                <div class="stat-val">{{ Auth::user()->donations_count ?? 0 }}</div>
                <div class="stat-lbl">Total Donations</div>
            </div>
            <div class="stat-box">
                <div class="stat-ico"><i class="fas fa-heart"></i></div>
                <div class="stat-val">{{ (Auth::user()->donations_count ?? 0) * 3 }}</div>
                <div class="stat-lbl">Lives Impacted</div>
            </div>
            <div class="stat-box">
                <div class="stat-ico"><i class="fas fa-bell"></i></div>
                <div class="stat-val">{{ $requests->count() }}</div>
                <div class="stat-lbl">Pending Requests</div>
            </div>
            <div class="stat-box">
                <div class="stat-ico"><i class="fas fa-user-check"></i></div>
                <div class="stat-val">{{ $isDonor ? '✅' : '❌' }}</div>
                <div class="stat-lbl">Donor Status</div>
            </div>
        </div>

        <!-- Incoming Requests matching blood group + city -->
        <div class="section-bar">
            <h3>🚨 REQUESTS FOR {{ Auth::user()->blood_type }} IN {{ strtoupper(Auth::user()->city ?? '') }}</h3>
            <a href="{{ route('emergency.index') }}">View All →</a>
        </div>

        <div class="req-list">
            @forelse($requests as $r)
            <div class="req-item">
                <div class="req-blood">{{ $r->blood_type }}</div>
                <div class="req-info">
                    <div class="req-title">{{ $r->patient_name }} — Contact: {{ $r->contact_name }}</div>
                    <div class="req-meta">
                        <i class="fas fa-hospital" style="color:var(--red)"></i> {{ $r->hospital_name }}{{ $r->ward ? ', '.$r->ward : '' }}
                        &nbsp;·&nbsp; {{ $r->units }} unit{{ $r->units > 1 ? 's' : '' }}
                        &nbsp;·&nbsp; {{ $r->created_at->diffForHumans() }}
                    </div>
                </div>
                <span class="urg-badge urg-{{ $r->urgency }}">{{ strtoupper($r->urgency) }}</span>
                <a href="https://wa.me/92{{ ltrim(preg_replace('/[^0-9]/', '', $r->phone), '0') }}?text=Hi+{{ urlencode($r->contact_name) }},+I+can+donate+{{ urlencode($r->blood_type) }}+blood+for+{{ urlencode($r->patient_name) }}" target="_blank" class="wa-btn">
                    <i class="fab fa-whatsapp"></i> Respond
                </a>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-check-circle" style="color:var(--success)"></i>
                <p>No urgent requests for <strong>{{ Auth::user()->blood_type }}</strong> in <strong>{{ Auth::user()->city }}</strong> right now.<br>
                You'll be contacted directly by patients via WhatsApp.</p>
            </div>
            @endforelse
        </div>

        @if($allCityRequests->count() > 0 && $allCityRequests->where('blood_type', '!=', Auth::user()->blood_type)->count() > 0)
        <div class="section-bar" style="margin-top:32px">
            <h3>OTHER REQUESTS IN {{ strtoupper(Auth::user()->city ?? '') }}</h3>
            <a href="{{ route('emergency.index', ['city' => Auth::user()->city]) }}">View All →</a>
        </div>
        <div class="req-list">
            @foreach($allCityRequests->where('blood_type', '!=', Auth::user()->blood_type)->take(3) as $r)
            <div class="req-item" style="border-left-color:#333;opacity:.75">
                <div class="req-blood" style="background:#333">{{ $r->blood_type }}</div>
                <div class="req-info">
                    <div class="req-title">{{ $r->patient_name }}</div>
                    <div class="req-meta">🏥 {{ $r->hospital_name }} · {{ $r->city }} · {{ $r->created_at->diffForHumans() }}</div>
                </div>
                <span class="urg-badge urg-{{ $r->urgency }}">{{ strtoupper($r->urgency) }}</span>
            </div>
            @endforeach
        </div>
        @endif

    </main>
</div>
@endsection

@push('scripts')
<script>
let avail = {{ Auth::user()->is_available ? 'true' : 'false' }};
function toggleAvail(){
    avail = !avail;
    const tog = document.getElementById('toggleEl');
    const txt = document.getElementById('availTxt');
    if(!tog) return;
    tog.classList.toggle('on', avail);
    txt.textContent = avail ? 'Available Now' : 'Not Available';
    txt.style.color  = avail ? 'var(--success)' : 'var(--muted)';
    fetch('/donor/toggle-availability',{
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},
        body:JSON.stringify({available:avail})
    });
}
</script>
@endpush
