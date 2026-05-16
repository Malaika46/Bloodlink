@extends('layouts.app')
@section('title', 'Donor Login')

@push('styles')
<style>
.login-wrap {
    min-height:calc(100vh - 68px);
    display:flex; align-items:center; justify-content:center;
    padding:40px 20px; position:relative;
}
.login-wrap::before {
    content:''; position:absolute; inset:0;
    background:radial-gradient(ellipse 55% 55% at 50% 40%, rgba(217,4,41,.1) 0%, transparent 70%);
    pointer-events:none;
}
.login-card {
    background:var(--bg3); border:1px solid var(--border);
    border-radius:18px; padding:52px 48px;
    width:100%; max-width:460px; position:relative; overflow:hidden;
}
.login-card::before {
    content:''; position:absolute; top:0; left:0; right:0; height:2px;
    background:linear-gradient(90deg, transparent, var(--red), transparent);
}
.login-logo { font-size:1.8rem; font-weight:900; letter-spacing:5px; text-align:center; margin-bottom:6px; }
.login-logo em { color:var(--red); font-style:normal; }
.login-sub  { text-align:center; font-family:var(--font-mono); font-size:.6rem; letter-spacing:2px; text-transform:uppercase; color:var(--muted); margin-bottom:36px; }
.login-sub a { color:var(--red); text-decoration:none; }

.login-divider {
    display:flex; align-items:center; gap:14px;
    margin:24px 0; color:var(--muted); font-family:var(--font-mono); font-size:.6rem; letter-spacing:2px; text-transform:uppercase;
}
.login-divider::before, .login-divider::after {
    content:''; flex:1; height:1px; background:var(--border);
}

@media(max-width:500px){
    .login-card { padding:32px 22px; }
}
</style>
@endpush

@section('content')
<div class="login-wrap">
    <div class="login-card">
        <div class="login-logo">BLOOD<em>LINK</em></div>
        <p class="login-sub">Donor Portal &nbsp;·&nbsp; <a href="{{ route('register') }}">Create account</a></p>

        @if(session('error'))
            <div class="alert alert-err">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-err">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
        @csrf
            <div class="f-group">
                <label class="f-label">Email Address</label>
                <input type="email" name="email" class="f-input" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="f-group">
                <label class="f-label">Password</label>
                <input type="password" name="password" class="f-input" required>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px">
                <label style="display:flex;align-items:center;gap:8px;font-size:.82rem;color:var(--muted);cursor:pointer">
                    <input type="checkbox" name="remember" style="accent-color:var(--red)"> Remember me
                </label>
                <a href="#" style="font-family:var(--font-mono);font-size:.6rem;letter-spacing:2px;text-transform:uppercase;color:var(--red);text-decoration:none">Forgot password?</a>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:14px">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>

        <div class="login-divider">Or</div>

        <a href="{{ route('emergency.form') }}" class="btn btn-outline" style="width:100%;justify-content:center;padding:14px">
            <i class="fas fa-exclamation-triangle" style="color:var(--red)"></i> Emergency Blood Request
        </a>
    </div>
</div>
@endsection
