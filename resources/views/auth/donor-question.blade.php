@extends('layouts.app')
@section('title', 'Will You Donate Blood?')

@push('styles')
<style>
.dq-page {
    min-height: calc(100vh - 68px);
    display: flex; align-items: center; justify-content: center;
    padding: 40px 20px;
    background: radial-gradient(ellipse 60% 60% at 50% 40%, rgba(217,4,41,.1) 0%, transparent 70%);
}

.dq-card {
    background: var(--bg3);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 52px 48px;
    max-width: 560px;
    width: 100%;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.dq-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, var(--red), transparent);
}

.dq-icon {
    font-size: 4rem;
    margin-bottom: 20px;
    animation: heartbeat 1.5s ease-in-out infinite;
}

@keyframes heartbeat {
    0%,100% { transform: scale(1); }
    14%     { transform: scale(1.15); }
    28%     { transform: scale(1); }
    42%     { transform: scale(1.08); }
}

.dq-card h1 {
    font-size: 2rem;
    font-weight: 900;
    letter-spacing: -1px;
    margin-bottom: 12px;
}

.dq-card h1 span { color: var(--red); }

.dq-card p {
    color: var(--muted);
    line-height: 1.75;
    margin-bottom: 36px;
    font-size: .95rem;
}

.dq-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 20px;
}

.dq-opt {
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 28px 20px;
    cursor: pointer;
    transition: all .25s;
    text-decoration: none;
    display: block;
    color: var(--text);
}

.dq-opt:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,.4); }

.dq-opt.yes:hover { border-color: var(--red); background: rgba(217,4,41,.07); }
.dq-opt.no:hover  { border-color: var(--border); background: var(--bg2); }

.dq-opt-emoji { font-size: 2.5rem; margin-bottom: 12px; }
.dq-opt-title { font-weight: 800; font-size: 1rem; margin-bottom: 6px; }
.dq-opt-sub   { font-size: .78rem; color: var(--muted); font-family: var(--font-mono); letter-spacing: 1px; text-transform: uppercase; }

.dq-note {
    font-family: var(--font-mono);
    font-size: .6rem;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--muted);
    margin-top: 8px;
}

@media(max-width: 500px) {
    .dq-card { padding: 32px 20px; }
    .dq-options { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="dq-page">
    <div class="dq-card">
        <div class="dq-icon">🩸</div>
        <h1>WILL YOU <span>DONATE</span>?</h1>
        <p>
            Welcome, <strong>{{ Auth::user()->first_name }}!</strong><br>
            One blood donation can save up to <strong style="color:var(--red)">3 lives</strong>.
            If you choose to donate, you'll be listed in our donor directory so patients in need can find you directly.
        </p>

        <div class="dq-options">
            <form method="POST" action="{{ route('donor.question.submit') }}" style="display:contents">
            @csrf
            <input type="hidden" name="wants_donate" value="yes">
            <button type="submit" class="dq-opt yes">
                <div class="dq-opt-emoji">✅</div>
                <div class="dq-opt-title">Yes, I'll Donate!</div>
                <div class="dq-opt-sub">Add me to donor list</div>
            </button>
            </form>

            <form method="POST" action="{{ route('donor.question.submit') }}" style="display:contents">
            @csrf
            <input type="hidden" name="wants_donate" value="no">
            <button type="submit" class="dq-opt no">
                <div class="dq-opt-emoji">🙏</div>
                <div class="dq-opt-title">Not Right Now</div>
                <div class="dq-opt-sub">Decide later from dashboard</div>
            </button>
            </form>
        </div>

        <p class="dq-note">You can change this anytime from your dashboard</p>
    </div>
</div>
@endsection
