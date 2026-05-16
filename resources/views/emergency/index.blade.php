@extends('layouts.app')
@section('title', 'Emergency Requests')

@push('styles')
<style>
.em-index { padding: 48px 0; min-height: calc(100vh - 68px); }

.em-index-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 32px; flex-wrap: wrap; gap: 16px;
}

.em-index-header h1 { font-size: 1.8rem; font-weight: 900; letter-spacing: -1px; }

.req-grid { display: flex; flex-direction: column; gap: 16px; }

.req-card {
    background: var(--bg3); border: 1px solid var(--border);
    border-radius: 16px; padding: 24px;
    border-left: 4px solid var(--red);
    transition: all .25s;
}

.req-card.urgent   { border-left-color: #F5A623; }
.req-card.normal   { border-left-color: var(--success); }
.req-card.fulfilled { opacity: .55; border-left-color: #333; }

.req-card:hover { transform: translateX(4px); box-shadow: 0 8px 32px rgba(0,0,0,.3); }

.req-row { display: flex; align-items: center; gap: 18px; flex-wrap: wrap; }

.req-blood-badge {
    width: 60px; height: 60px; border-radius: 12px;
    background: var(--red); display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; font-weight: 900;
    box-shadow: 0 4px 14px var(--red-glow);
    flex-shrink: 0;
}

.req-body { flex: 1; min-width: 200px; }
.req-title { font-size: 1rem; font-weight: 800; margin-bottom: 4px; }
.req-meta {
    font-family: var(--font-mono); font-size: .6rem;
    letter-spacing: 1px; text-transform: uppercase; color: var(--muted);
    display: flex; gap: 16px; flex-wrap: wrap;
}

.req-actions { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }

.urg-tag {
    padding: 4px 12px; border-radius: 100px;
    font-family: var(--font-mono); font-size: .6rem;
    letter-spacing: 1.5px; text-transform: uppercase; font-weight: 700;
}
.urg-tag.critical { background: rgba(217,4,41,.12); color: var(--red); }
.urg-tag.urgent   { background: rgba(245,166,35,.12); color: #F5A623; }
.urg-tag.normal   { background: rgba(0,212,164,.12); color: var(--success); }
.urg-tag.fulfilled { background: rgba(102,102,102,.1); color: var(--muted); }

.accept-btn {
    font-family: var(--font-mono); font-size: .62rem;
    letter-spacing: 1.5px; text-transform: uppercase;
    padding: 9px 18px; border-radius: 8px;
    background: var(--red); color: #fff; border: none;
    cursor: pointer; transition: all .2s;
    text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
}
.accept-btn:hover { background: #FF1A30; box-shadow: 0 4px 16px var(--red-glow); }

.req-notes {
    margin-top: 14px; padding: 12px 16px;
    background: var(--bg2); border-radius: 9px;
    font-size: .85rem; color: var(--muted); line-height: 1.65;
}

.empty-state {
    text-align: center; padding: 80px 20px; color: var(--muted);
}
.empty-state i { font-size: 3rem; color: var(--border); display: block; margin-bottom: 16px; }

/* Filter bar */
.em-filters {
    display: flex; gap: 10px; flex-wrap: wrap;
    margin-bottom: 28px;
}
.em-filters .f-group { flex: 1; min-width: 140px; margin-bottom: 0; }
</style>
@endpush

@section('content')
<div class="em-index">
    <div class="container">

        <div class="em-index-header">
            <div>
                <div class="tag" style="margin-bottom:10px"><div class="live"></div>Live Requests</div>
                <h1>🚨 EMERGENCY <span style="color:var(--red)">REQUESTS</span></h1>
            </div>
            <a href="{{ route('emergency.form') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Post Request
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-ok"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        {{-- Filters --}}
        <form method="GET" action="{{ route('emergency.index') }}">
        <div class="em-filters">
            <div class="f-group">
                <label class="f-label">Blood Type</label>
                <select name="blood_type" class="f-input" onchange="this.form.submit()">
                    <option value="">All</option>
                    @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)
                        <option value="{{ $bt }}" {{ request('blood_type') == $bt ? 'selected' : '' }}>{{ $bt }}</option>
                    @endforeach
                </select>
            </div>
            <div class="f-group">
                <label class="f-label">City</label>
                <select name="city" class="f-input" onchange="this.form.submit()">
                    <option value="">All Cities</option>
                    @foreach(['Lahore','Karachi','Islamabad','Rawalpindi','Peshawar','Multan','Faisalabad','Quetta'] as $c)
                        <option value="{{ $c }}" {{ request('city') == $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>
            <div class="f-group">
                <label class="f-label">Status</label>
                <select name="status" class="f-input" onchange="this.form.submit()">
                    <option value="pending" {{ request('status','pending') == 'pending' ? 'selected' : '' }}>Active</option>
                    <option value="" {{ request('status') === '' ? 'selected' : '' }}>All</option>
                    <option value="fulfilled" {{ request('status') == 'fulfilled' ? 'selected' : '' }}>Fulfilled</option>
                </select>
            </div>
        </div>
        </form>

        <div class="req-grid">
            @forelse($requests as $r)
            <div class="req-card {{ $r->urgency }} {{ $r->status == 'fulfilled' ? 'fulfilled' : '' }}">
                <div class="req-row">
                    <div class="req-blood-badge">{{ $r->blood_type }}</div>
                    <div class="req-body">
                        <div class="req-title">{{ $r->patient_name }}{{ $r->age ? ' · Age '.$r->age : '' }}</div>
                        <div class="req-meta">
                            <span><i class="fas fa-hospital" style="color:var(--red)"></i> {{ $r->hospital_name }}{{ $r->ward ? ', '.$r->ward : '' }}</span>
                            <span><i class="fas fa-map-marker-alt" style="color:var(--red)"></i> {{ $r->city }}</span>
                            <span><i class="fas fa-tint"></i> {{ $r->units }} unit{{ $r->units > 1 ? 's' : '' }}</span>
                            <span><i class="fas fa-clock"></i> {{ $r->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="req-actions">
                        <span class="urg-tag {{ $r->status == 'fulfilled' ? 'fulfilled' : $r->urgency }}">
                            {{ $r->status == 'fulfilled' ? '✅ Fulfilled' : strtoupper($r->urgency) }}
                        </span>
                        @if($r->status == 'pending')
                            <a href="tel:{{ $r->phone }}" class="accept-btn" style="background:transparent;border:1px solid var(--border-red);color:var(--red)">
                                <i class="fas fa-phone"></i> {{ $r->phone }}
                            </a>
                            <a href="https://wa.me/92{{ ltrim(preg_replace('/[^0-9]/', '', $r->phone), '0') }}?text=Hi+{{ urlencode($r->contact_name) }},+I+can+donate+{{ urlencode($r->blood_type) }}+blood+for+{{ urlencode($r->patient_name) }}" target="_blank" class="accept-btn">
                                <i class="fab fa-whatsapp"></i> I Can Donate
                            </a>
                        @endif
                    </div>
                </div>
                @if($r->notes)
                <div class="req-notes"><i class="fas fa-info-circle" style="color:var(--red)"></i> {{ $r->notes }}</div>
                @endif
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-heart"></i>
                <h3>No active emergency requests!</h3>
                <p>Great news — no one needs blood urgently right now.</p>
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
