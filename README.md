# 🩸 BloodLink v2 — Blood Donor Network Platform
### Laravel 9 · Google Maps · Three.js 3D · Professional Dark Theme

---

## ✨ What's New in v2

- ✅ **Google Maps** — dark-styled map with custom blood-drop markers, InfoWindows, filter-fitted bounds
- ✅ **Three.js Optimized** — no lag, smooth 60fps, reduced particle count, delta-based animation
- ✅ **3D on About Page** — DNA helix visualization with blood-red spheres
- ✅ **Floating 3D Badges** — stat cards that float around the hero canvas
- ✅ **Premium Dark Theme** — deeper blacks, sharper typography (Montserrat + Space Mono)
- ✅ **No dummy content** — removed placeholder team/fake sections
- ✅ **Emergency ticker** — live scrolling emergency alerts banner
- ✅ **Smooth scroll reveal** — IntersectionObserver based, no library needed

---

## 🗂️ File Structure (23 files)

```
bloodlink2/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── DonorController.php
│   │   ├── EmergencyController.php
│   │   └── HomeController.php
│   └── Models/
│       ├── Donor.php
│       ├── EmergencyRequest.php
│       └── User.php
├── database/migrations/
│   ├── ..._create_users_table.php
│   ├── ..._create_emergency_requests_table.php
│   └── ..._create_donors_table.php
├── resources/views/
│   ├── layouts/app.blade.php        ← Master layout
│   ├── home/index.blade.php         ← Hero + 3D + process + blood types
│   ├── donor/find.blade.php         ← Google Maps + sidebar filters
│   ├── emergency/form.blade.php     ← Emergency broadcast form
│   ├── auth/register.blade.php      ← Donor registration
│   ├── auth/login.blade.php         ← Login
│   ├── dashboard/index.blade.php    ← Donor dashboard
│   └── about/index.blade.php        ← Mission + 3D helix + values
├── routes/web.php
├── composer.json
└── .env.example
```

---

## 🚀 Installation

### 1. Extract & Install
```bash
cd bloodlink2
composer install
```

### 2. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Configure `.env`
```env
DB_DATABASE=bdname
DB_USERNAME=root
DB_PASSWORD=password

# Required for the Find Donor map
GOOGLE_MAPS_KEY=google_maps_api_key_here
```

### 4. Database
```sql
CREATE DATABASE bloodlink;
```
```bash
php artisan migrate
```

### 5. Run
```bash
php artisan serve
```
→ Open **http://localhost:8000**

---

## 🗺️ Google Maps API Key Setup

1. Go to https://console.cloud.google.com
2. Create a project → Enable **Maps JavaScript API**
3. Create credentials → API Key
4. Add the key to `.env`:
   ```
   GOOGLE_MAPS_KEY=AIzaSyXXXXXXXXXXXXXXXXXX
   ```
5. In `find.blade.php`, the key is automatically loaded via `{{ env('GOOGLE_MAPS_KEY') }}`

**Map Features:**
- Custom dark-styled map (matches app theme perfectly)
- Blood-type labeled drop markers (red = available, grey = unavailable)
- InfoWindow popups with WhatsApp contact button
- Auto-fits bounds when filtering donors
- Smooth pan/zoom animations

---

## 🎨 Design Tokens

| Token       | Value               |
|-------------|---------------------|
| Primary Red | `#D0021B`           |
| Background  | `#080808`           |
| Surface     | `#161616`           |
| Headings    | Montserrat 900      |
| Mono        | Space Mono          |

---

## ⚡ Tech Stack

| Layer    | Technology               |
|----------|--------------------------|
| Backend  | Laravel 9, PHP 8.0+      |
| Frontend | Blade, Vanilla JS        |
| 3D       | Three.js r128            |
| Maps     | Google Maps JS API v3    |
| Icons    | Font Awesome 6           |
| Fonts    | Google Fonts             |

---

Made with ❤️ · BloodLink © {{ date('Y') }}
