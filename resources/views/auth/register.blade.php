@extends('layouts.app')
@section('title', 'Register as Donor')

@push('styles')
<style>
.auth-grid { min-height:calc(100vh - 68px); display:grid; grid-template-columns:1fr 1fr; }

.auth-left {
    background:var(--bg2); border-right:1px solid var(--border);
    padding:80px 60px; display:flex; flex-direction:column; justify-content:center;
    position:relative; overflow:hidden;
}
.auth-left-gfx {
    position:absolute; bottom:-10%; right:-10%;
    width:420px; height:420px;
    background:radial-gradient(circle, rgba(217,4,41,.15) 0%, transparent 70%);
    pointer-events:none;
}

.auth-big { font-size:clamp(3rem,7vw,5.5rem); font-weight:900; line-height:.95; letter-spacing:-2px; margin-bottom:20px; }
.auth-big em { color:var(--red); font-style:normal; }

.perk { display:flex; align-items:flex-start; gap:14px; margin-bottom:18px; }
.perk-icon {
    width:38px; height:38px; border-radius:9px;
    background:rgba(217,4,41,.1); display:flex; align-items:center; justify-content:center;
    color:var(--red); font-size:.9rem; flex-shrink:0; margin-top:2px;
}
.perk-text { font-size:.88rem; color:var(--muted); line-height:1.65; }
.perk-text strong { color:var(--text); }

.auth-right {
    padding:60px 56px; display:flex; flex-direction:column; justify-content:center;
    overflow-y:auto;
}
.auth-right::-webkit-scrollbar { width:3px; }
.auth-right h2 { font-size:1.8rem; font-weight:900; letter-spacing:-1px; margin-bottom:6px; }
.auth-right p  { color:var(--muted); font-size:.88rem; margin-bottom:32px; }
.auth-right p a { color:var(--red); text-decoration:none; }
.f2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }

@media(max-width:900px){
    .auth-grid { grid-template-columns:1fr; }
    .auth-left { display:none; }
    .auth-right { padding:32px 20px; }
    .f2 { grid-template-columns:1fr; }
}
</style>
@endpush

@section('content')
<div class="auth-grid">
    <div class="auth-left">
        <div class="auth-left-gfx"></div>
        <div style="position:relative;z-index:2">
            <div class="tag" style="margin-bottom:24px"><div class="live"></div>Join BloodLink</div>
            <div class="auth-big">BE A<br><em>HERO</em><br>TODAY</div>
            <p class="section-sub" style="margin-bottom:36px;max-width:380px">Register as a blood donor and become part of Pakistan's largest verified donor network. Free, fast, and life-saving.</p>
            <div class="perk"><div class="perk-icon"><i class="fas fa-shield-alt"></i></div><div class="perk-text"><strong>Verified Badge</strong> after your first confirmed donation</div></div>
            <div class="perk"><div class="perk-icon"><i class="fas fa-bell"></i></div><div class="perk-text"><strong>WhatsApp Alerts</strong> for matching emergencies near you</div></div>
            <div class="perk"><div class="perk-icon"><i class="fas fa-chart-bar"></i></div><div class="perk-text"><strong>Impact Dashboard</strong> — track every life you've helped save</div></div>
            <div class="perk"><div class="perk-icon"><i class="fas fa-map-marker-alt"></i></div><div class="perk-text"><strong>Live Map Listing</strong> so patients can find you instantly</div></div>
        </div>
    </div>

    <div class="auth-right">
        <h2>CREATE <span style="color:var(--red)">ACCOUNT</span></h2>
        <p>Already registered? <a href="{{ route('login') }}">Sign in here</a></p>

        @if($errors->any())
            <div class="alert alert-err">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}">
        @csrf
            <div class="f2">
                <div class="f-group">
                    <label class="f-label">First Name *</label>
                    <input type="text" name="first_name" class="f-input" value="{{ old('first_name') }}" required>
                </div>
                <div class="f-group">
                    <label class="f-label">Last Name *</label>
                    <input type="text" name="last_name" class="f-input" value="{{ old('last_name') }}" required>
                </div>
            </div>
            <div class="f-group">
                <label class="f-label">Email Address *</label>
                <input type="email" name="email" class="f-input" value="{{ old('email') }}" required>
            </div>
            <div class="f2">
                <div class="f-group">
                    <label class="f-label">Blood Type *</label>
                    <select name="blood_type" class="f-input" required>
                        <option value="">Select</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)
                            <option value="{{ $bt }}" {{ old('blood_type')==$bt?'selected':'' }}>{{ $bt }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="f-group">
                    <label class="f-label">City *</label>
                    <input list="city-list" name="city" class="f-input" placeholder="Search or select city" value="{{ old('city') }}" required autocomplete="off">
                    <datalist id="city-list">
                        @foreach(['Lahore','Karachi','Islamabad','Rawalpindi','Peshawar','Multan','Faisalabad','Quetta','Gujranwala','Sialkot','Hyderabad','Sukkur','Sargodha','Bahawalpur','Jhang','Sheikhupura','Larkana','Gujrat','Mardan','Kasur','Rahim Yar Khan','Sahiwal','Okara','Wah Cantonment','Dera Ghazi Khan','Mingora','Mirpur Khas','Chiniot','Nawabshah','Kamoke','Burewala','Jhelum','Shikarpur','Hafizabad','Kohat','Khanewal','Khuzdar','Dera Ismail Khan','Muridke','Gojra','Mandi Bahauddin','Abbottabad','Khairpur','Tando Adam','Daska','Pakpattan'] as $c)
                            <option value="{{ $c }}">
                        @endforeach
                    </datalist>
                </div>
            </div>
            <div class="f-group">
                <label class="f-label">WhatsApp Number *</label>
                <input type="tel" name="phone" class="f-input" placeholder="+92 300 0000000" value="{{ old('phone') }}" required>
            </div>
            <div class="f2">
                <div class="f-group">
                    <label class="f-label">Password *</label>
                    <input type="password" name="password" class="f-input" required>
                </div>
                <div class="f-group">
                    <label class="f-label">Confirm Password *</label>
                    <input type="password" name="password_confirmation" class="f-input" required>
                </div>
            </div>
            <div style="display:flex;align-items:flex-start;gap:10px;margin:8px 0 20px">
                <input type="checkbox" name="agree" id="agree" required style="margin-top:3px;accent-color:var(--red);width:15px;height:15px;flex-shrink:0">
                <label for="agree" style="font-size:.82rem;color:var(--muted);line-height:1.6;cursor:pointer">
                    I confirm I am fit to donate blood and agree to be contacted by patients matching my blood type.
                </label>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:15px">
                <i class="fas fa-user-plus"></i> Register as Donor
            </button>
        </form>
    </div>
</div>
@endsection
