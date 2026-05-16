@extends('layouts.app')
@section('title', 'Find a Donor')

@push('styles')
<style>
.find-page {
    padding: 48px 0;
    min-height: calc(100vh - 68px);
}

.filter-section {
    background: var(--bg2);
    border-bottom: 1px solid var(--border);
    padding: 24px 0;
    margin-bottom: 40px;
}

.filter-row {
    display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap;
}

.filter-row .f-group { flex: 1; min-width: 150px; margin-bottom: 0; }

.result-meta {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 24px;
}

.result-meta h2 { font-size: 1.1rem; font-weight: 900; letter-spacing: 1px; }
.result-meta span {
    font-family: var(--font-mono); font-size: .6rem;
    letter-spacing: 2px; text-transform: uppercase; color: var(--red);
}

/* Donor Grid */
.donor-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.d-card {
    background: var(--bg3);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
    transition: all .25s;
    position: relative;
    overflow: hidden;
}

.d-card:hover {
    border-color: var(--border-red);
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(0,0,0,.4);
}

.d-card::after {
    content: '';
    position: absolute; bottom: 0; left: 0; right: 0; height: 2px;
    background: var(--red);
    transform: scaleX(0);
    transition: transform .3s;
    transform-origin: left;
}
.d-card:hover::after { transform: scaleX(1); }

.d-top {
    display: flex; align-items: center; gap: 14px; margin-bottom: 16px;
}

.d-avatar {
    width: 54px; height: 54px;
    border-radius: 12px;
    background: var(--red);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; font-weight: 900;
    box-shadow: 0 4px 14px var(--red-glow);
    flex-shrink: 0;
}

.d-name { font-size: .95rem; font-weight: 800; margin-bottom: 3px; }
.d-loc  {
    font-family: var(--font-mono); font-size: .6rem;
    letter-spacing: 1px; text-transform: uppercase; color: var(--muted);
}

.d-blood-badge {
    margin-left: auto;
    background: rgba(217,4,41,.1);
    color: var(--red);
    border: 1px solid var(--border-red);
    padding: 6px 14px;
    border-radius: 100px;
    font-size: 1rem;
    font-weight: 900;
    flex-shrink: 0;
}

.d-pills { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 18px; }

.pill {
    font-family: var(--font-mono); font-size: .58rem;
    letter-spacing: 1px; text-transform: uppercase;
    padding: 4px 10px; border-radius: 100px;
    display: flex; align-items: center; gap: 4px;
}
.pill.avail { background: rgba(0,212,164,.1); color: var(--success); border: 1px solid rgba(0,212,164,.2); }
.pill.busy  { background: rgba(102,102,102,.1); color: var(--muted); border: 1px solid rgba(102,102,102,.2); }
.pill.count { background: rgba(217,4,41,.1); color: var(--red); border: 1px solid var(--border-red); }

.d-actions { display: flex; gap: 10px; }

.wa-btn {
    flex: 1;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 10px;
    background: rgba(37,211,102,.1); color: #25d366;
    border: 1px solid rgba(37,211,102,.2);
    border-radius: 9px;
    font-family: var(--font-mono); font-size: .62rem;
    letter-spacing: 1.5px; text-transform: uppercase;
    text-decoration: none;
    transition: all .2s;
}
.wa-btn:hover { background: #25d366; color: #fff; }

.call-btn {
    padding: 10px 14px;
    background: rgba(217,4,41,.1); color: var(--red);
    border: 1px solid var(--border-red);
    border-radius: 9px;
    font-family: var(--font-mono); font-size: .65rem;
    text-decoration: none;
    transition: all .2s;
    display: flex; align-items: center; gap: 6px;
}
.call-btn:hover { background: var(--red); color: #fff; }

/* Empty state */
.empty-donors {
    grid-column: 1 / -1;
    text-align: center;
    padding: 64px 20px;
    color: var(--muted);
}
.empty-donors i { font-size: 2.5rem; color: var(--border); display: block; margin-bottom: 16px; }
.empty-donors h3 { font-size: 1.1rem; margin-bottom: 8px; }
.empty-donors p { font-size: .88rem; line-height: 1.7; }

@media(max-width: 768px) {
    .filter-row { flex-direction: column; }
    .filter-row .f-group { min-width: 100%; }
}
</style>
@endpush

@section('content')

<div class="find-page">

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="container">
            <h2 style="font-size:1.4rem;font-weight:900;letter-spacing:-0.5px;margin-bottom:20px">
                FIND A <span style="color:var(--red)">DONOR</span>
            </h2>
            <form method="GET" action="{{ route('donor.find') }}">
                <div class="filter-row">
                    <div class="f-group">
                        <label class="f-label">Blood Type</label>
                        <select name="blood_type" class="f-input" onchange="this.form.submit()">
                            <option value="">All Blood Types</option>
                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)
                                <option value="{{ $bt }}" {{ request('blood_type') == $bt ? 'selected' : '' }}>{{ $bt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="f-group">
                        <label class="f-label">City</label>
                        <select name="city" class="f-input" onchange="this.form.submit()">
                            <option value="">All Cities</option>
                            @foreach(['Lahore','Karachi','Islamabad','Rawalpindi','Peshawar','Multan','Faisalabad','Quetta','Sialkot','Gujranwala'] as $c)
                                <option value="{{ $c }}" {{ request('city') == $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="f-group">
                        <label class="f-label">Availability</label>
                        <select name="available" class="f-input" onchange="this.form.submit()">
                            <option value="">Any</option>
                            <option value="1" {{ request('available') == '1' ? 'selected' : '' }}>Available Now</option>
                        </select>
                    </div>
                    <div class="f-group" style="flex:0">
                        <label class="f-label">&nbsp;</label>
                        <a href="{{ route('donor.find') }}" class="btn btn-outline" style="padding:12px 18px;font-size:.65rem">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="result-meta">
            <h2>{{ $donors->count() }} DONOR{{ $donors->count() != 1 ? 'S' : '' }} FOUND</h2>
            <span><i class="fas fa-circle" style="font-size:.4rem;color:var(--red)"></i> Live Database</span>
        </div>

        <div class="donor-grid">
            @forelse($donors as $donor)
            @php $user = $donor->user; @endphp
            <div class="d-card">
                <div class="d-top">
                    <div class="d-avatar">
                        {{ strtoupper(substr($user->first_name ?? $user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="d-name">{{ $user->first_name ?? '' }} {{ $user->last_name ?? '' }}</div>
                        <div class="d-loc">
                            <i class="fas fa-map-marker-alt" style="color:var(--red)"></i>
                            {{ $donor->city }}
                        </div>
                    </div>
                    <div class="d-blood-badge">{{ $donor->blood_type }}</div>
                </div>

                <div class="d-pills">
                    @if($donor->is_available)
                        <span class="pill avail"><i class="fas fa-circle" style="font-size:.35rem"></i> Available Now</span>
                    @else
                        <span class="pill busy"><i class="fas fa-circle" style="font-size:.35rem"></i> Unavailable</span>
                    @endif

                    @if($donor->donations_count > 0)
                        <span class="pill count">🩸 {{ $donor->donations_count }} donations</span>
                    @endif
                </div>

                @if($donor->is_available)
                <div class="d-actions">
                    <a href="https://wa.me/92{{ ltrim(preg_replace('/[^0-9]/', '', $donor->phone), '0') }}?text=Hi+{{ urlencode($user->first_name ?? 'Donor') }},+I+need+{{ urlencode($donor->blood_type) }}+blood+urgently.+Please+help!" target="_blank" class="wa-btn">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                    <a href="tel:{{ $donor->phone }}" class="call-btn">
                        <i class="fas fa-phone"></i> Call
                    </a>
                </div>
                @else
                <div style="text-align:center;padding:10px;font-family:var(--font-mono);font-size:.6rem;letter-spacing:1px;text-transform:uppercase;color:var(--muted)">
                    Currently not available
                </div>
                @endif
            </div>
            @empty
            <div class="empty-donors">
                <i class="fas fa-users-slash"></i>
                <h3>No donors found</h3>
                <p>
                    @if(request('blood_type') || request('city'))
                        No donors match your filters. Try different criteria or
                    @else
                        No donors registered yet.
                    @endif
                    <br>
                    <a href="{{ route('emergency.form') }}" style="color:var(--red)">Post an emergency request</a>
                    instead.
                </p>
            </div>
            @endforelse
        </div>
    </div>

</div>

@endsection
