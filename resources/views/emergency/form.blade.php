@extends('layouts.app')
@section('title', 'Emergency Blood Request')

@push('styles')
<style>
.em-page { min-height:calc(100vh - 68px); display:grid; grid-template-columns:1fr 600px; }
.em-left { background:var(--bg2); padding:80px 60px; display:flex; flex-direction:column; justify-content:center; position:relative; overflow:hidden; border-right:1px solid var(--border); }
.em-left-glow { position:absolute; bottom:-20%; left:-20%; width:500px; height:500px; background:radial-gradient(circle, rgba(217,4,41,.18) 0%, transparent 65%); pointer-events:none; }
.em-big { font-size:clamp(4rem,9vw,8rem); font-weight:900; line-height:.9; letter-spacing:-3px; }
.em-big em { color:var(--red); font-style:normal; }
.em-stat { display:flex; align-items:center; gap:14px; padding:16px 20px; background:var(--bg3); border:1px solid var(--border); border-radius:12px; margin-top:16px; }
.em-stat-icon { font-size:1.5rem; color:var(--red); }
.em-stat-val  { font-size:1.3rem; font-weight:900; }
.em-stat-lbl  { font-family:var(--font-mono); font-size:.58rem; letter-spacing:1.5px; text-transform:uppercase; color:var(--muted); }
.em-right { padding:60px 48px; overflow-y:auto; }
.em-right::-webkit-scrollbar { width:3px; }
.em-right::-webkit-scrollbar-thumb { background:var(--red); }
.form-card { background:var(--bg3); border:1px solid var(--border); border-radius:16px; padding:36px; position:relative; overflow:hidden; }
.fsec { font-family:var(--font-mono); font-size:.62rem; letter-spacing:3px; text-transform:uppercase; color:var(--red); margin:28px 0 16px; padding-bottom:8px; border-bottom:1px solid rgba(217,4,41,.15); display:flex; align-items:center; gap:8px; }
.fsec:first-child { margin-top:0; }
.f2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
.urgency-row { display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px; margin-top:6px; }
.urgency-opt { border:1px solid var(--border); border-radius:9px; padding:14px 10px; text-align:center; cursor:pointer; transition:all .2s; }
.urgency-opt input { display:none; }
.urgency-opt.sel { border-color:var(--red); background:rgba(217,4,41,.08); }
.urgency-icon { font-size:1.3rem; margin-bottom:6px; }
.urgency-name { font-size:.82rem; font-weight:700; margin-bottom:3px; }
.urgency-time { font-family:var(--font-mono); font-size:.58rem; letter-spacing:1px; text-transform:uppercase; color:var(--muted); }
@media(max-width:960px){ .em-page { grid-template-columns:1fr; } .em-left { display:none; } .em-right { padding:28px 16px; } .f2 { grid-template-columns:1fr; } .urgency-row { grid-template-columns:1fr; } }
</style>
@endpush

@section('content')
<div class="em-page">
    <div class="em-left">
        <div class="em-left-glow"></div>
        <div style="position:relative;z-index:2">
            <div class="tag" style="margin-bottom:24px"><div class="live"></div>Emergency Line Active</div>
            <div class="em-big">EVERY<br><em>SECOND</em><br>COUNTS</div>
            <p class="section-sub" style="margin-top:20px;max-width:380px">Fill the form. Your request will be saved and visible to all donors instantly.</p>
            <div class="em-stat" style="margin-top:32px">
                <div class="em-stat-icon"><i class="fas fa-clock"></i></div>
                <div><div class="em-stat-val">&lt; 4 min</div><div class="em-stat-lbl">Average Donor Response</div></div>
            </div>
            <div class="em-stat">
                <div class="em-stat-icon"><i class="fas fa-eye"></i></div>
                <div><div class="em-stat-val">Live</div><div class="em-stat-lbl">Request visible to all donors</div></div>
            </div>
        </div>
    </div>

    <div class="em-right">
        <div style="margin-bottom:28px">
            <h1 style="font-size:1.8rem;font-weight:900;letter-spacing:-1px;margin-bottom:6px">BLOOD <span style="color:var(--red)">EMERGENCY</span></h1>
            <p class="section-sub" style="font-size:.88rem">All fields marked * are required</p>
        </div>

        @if(session('success'))
            <div class="alert alert-ok" style="margin-bottom:20px"><i class="fas fa-check-circle"></i> {{ session('success') }}
            <br><a href="{{ route('emergency.index') }}" style="color:var(--success);font-weight:700">View all active requests →</a>
            </div>
        @endif

        <div class="form-card">
        <form id="emForm" action="{{ route('emergency.submit') }}" method="POST">
        @csrf
            <div class="fsec"><i class="fas fa-user-injured"></i> Patient Information</div>
            <div class="f2">
                <div class="f-group"><label class="f-label">Patient Name *</label><input type="text" name="patient_name" class="f-input" placeholder="Full name" required></div>
                <div class="f-group"><label class="f-label">Age</label><input type="number" name="age" class="f-input" placeholder="Years" min="1" max="120"></div>
            </div>
            <div class="f2">
                <div class="f-group">
                    <label class="f-label">Blood Type Required *</label>
                    <select name="blood_type" class="f-input" required>
                        <option value="">Select</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)
                            <option>{{ $bt }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="f-group">
                    <label class="f-label">Units Required *</label>
                    <select name="units" class="f-input" required>
                        @for($i=1;$i<=10;$i++)<option>{{ $i }}</option>@endfor
                    </select>
                </div>
            </div>

            <div class="fsec"><i class="fas fa-clock"></i> Urgency Level</div>
            <div class="urgency-row">
                <div class="urgency-opt sel" id="uOpt-critical" onclick="setUrgency('critical')">
                    <input type="radio" name="urgency" value="critical" checked>
                    <div class="urgency-icon">🔴</div>
                    <div class="urgency-name" style="color:var(--red)">Critical</div>
                    <div class="urgency-time">Within 1 hour</div>
                </div>
                <div class="urgency-opt" id="uOpt-urgent" onclick="setUrgency('urgent')">
                    <input type="radio" name="urgency" value="urgent">
                    <div class="urgency-icon">🟡</div>
                    <div class="urgency-name" style="color:var(--warning)">Urgent</div>
                    <div class="urgency-time">Within 6 hours</div>
                </div>
                <div class="urgency-opt" id="uOpt-normal" onclick="setUrgency('normal')">
                    <input type="radio" name="urgency" value="normal">
                    <div class="urgency-icon">🟢</div>
                    <div class="urgency-name" style="color:var(--success)">Normal</div>
                    <div class="urgency-time">Within 24 hours</div>
                </div>
            </div>

            <div class="fsec"><i class="fas fa-hospital"></i> Hospital Details</div>
            <div class="f-group"><label class="f-label">Hospital Name *</label><input type="text" name="hospital_name" class="f-input" placeholder="e.g. Services Hospital Lahore" required></div>
            <div class="f2">
                <div class="f-group">
                    <label class="f-label">City *</label>
                    <input list="city-list" name="city" class="f-input" placeholder="Search or select city" required autocomplete="off">
                    <datalist id="city-list">
                        @foreach(['Lahore','Karachi','Islamabad','Rawalpindi','Peshawar','Multan','Faisalabad','Quetta','Gujranwala','Sialkot','Hyderabad','Sukkur','Sargodha','Bahawalpur','Jhang','Sheikhupura','Larkana','Gujrat','Mardan','Kasur','Rahim Yar Khan','Sahiwal','Okara','Wah Cantonment','Dera Ghazi Khan','Mingora','Mirpur Khas','Chiniot','Nawabshah','Kamoke','Burewala','Jhelum','Shikarpur','Hafizabad','Kohat','Khanewal','Khuzdar','Dera Ismail Khan','Muridke','Gojra','Mandi Bahauddin','Abbottabad','Khairpur','Tando Adam','Daska','Pakpattan'] as $c)
                            <option value="{{ $c }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="f-group"><label class="f-label">Ward / Room</label><input type="text" name="ward" class="f-input" placeholder="e.g. ICU Ward 3"></div>
            </div>

            <div class="fsec"><i class="fas fa-phone"></i> Contact Details</div>
            <div class="f2">
                <div class="f-group"><label class="f-label">Contact Person *</label><input type="text" name="contact_name" class="f-input" placeholder="Your name" required></div>
                <div class="f-group"><label class="f-label">Phone / WhatsApp *</label><input type="tel" name="phone" class="f-input" placeholder="03XX-XXXXXXX" required></div>
            </div>
            <div class="f-group"><label class="f-label">Additional Notes</label><textarea name="notes" class="f-input" rows="2" placeholder="Any extra info for donors..."></textarea></div>

            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:15px;font-size:.78rem;margin-top:8px">
                <i class="fas fa-broadcast-tower"></i> BROADCAST EMERGENCY REQUEST
            </button>
            <p style="text-align:center;font-family:var(--font-mono);font-size:.58rem;letter-spacing:1px;color:var(--muted);margin-top:12px">
                Request will be visible on the emergency page instantly
            </p>
        </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function setUrgency(val){
    document.querySelectorAll('.urgency-opt').forEach(o=>o.classList.remove('sel'));
    document.getElementById('uOpt-'+val).classList.add('sel');
    document.querySelector(`input[value="${val}"]`).checked=true;
}
</script>
@endpush
