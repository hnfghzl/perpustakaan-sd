# PANDUAN IMPLEMENTASI PERBAIKAN KEAMANAN

**Tanggal**: 2 Januari 2026  
**Project**: Sistem Perpustakaan Laravel 12 + Livewire 3  
**Berdasarkan**: ANALISA_KEAMANAN.md

---

## 🔧 CRITICAL FIXES (Priority 1)

### Fix #1: Authorization Check di CRUD Methods

**Problem**: Kepala bisa hapus data via browser console karena tidak ada role check di method.

**Files to Edit**:

1. `app/Livewire/AnggotaComponent.php`
2. `app/Livewire/BukuComponent.php`
3. `app/Livewire/KategoriComponent.php`
4. `app/Livewire/EksemplarComponent.php`

#### AnggotaComponent.php

```php
// BEFORE (line ~159)
#[On('deleteAnggota')]
public function deleteNow($id) {
    $anggota = Anggota::find($id);
    if ($anggota) {
        $anggota->delete();
        session()->flash('success', 'Anggota berhasil dihapus!');
    }
}

// AFTER - ADD AUTHORIZATION CHECK
#[On('deleteAnggota')]
public function deleteNow($id) {
    // CRITICAL: Only pustakawan can delete
    if (Auth::user()->role !== 'pustakawan') {
        session()->flash('error', 'Anda tidak memiliki izin untuk menghapus anggota!');
        return;
    }

    $anggota = Anggota::find($id);
    if ($anggota) {
        $anggota->delete();
        session()->flash('success', 'Anggota berhasil dihapus!');
    }
}

// ALSO ADD to store() method (line ~74)
public function store() {
    // Add at the beginning
    if (Auth::user()->role !== 'pustakawan') {
        session()->flash('error', 'Anda tidak memiliki izin untuk menambah anggota!');
        return;
    }

    // ... rest of code
}

// ALSO ADD to update() method (line ~127)
public function update() {
    // Add at the beginning
    if (Auth::user()->role !== 'pustakawan') {
        session()->flash('error', 'Anda tidak memiliki izin untuk mengupdate anggota!');
        return;
    }

    // ... rest of code
}
```

#### BukuComponent.php - Tambahkan di method destroy() (cari line dengan `public function destroy`)

```php
public function destroy($id) {
    // ADD THIS CHECK
    if (Auth::user()->role !== 'pustakawan') {
        session()->flash('error', 'Anda tidak memiliki izin untuk menghapus buku!');
        return;
    }

    // ... rest of existing code
}

// JUGA tambahkan di store(), update(), storeEksemplar(), updateEksemplar()
```

#### KategoriComponent.php (line ~140)

```php
public function destroy($id) {
    // ADD THIS CHECK
    if (Auth::user()->role !== 'pustakawan') {
        session()->flash('error', 'Anda tidak memiliki izin untuk menghapus kategori!');
        return;
    }

    DB::beginTransaction();
    try {
        // ... rest of existing code
    }
}

// JUGA tambahkan di store() (line ~55) dan update() (line ~99)
```

#### EksemplarComponent.php (line ~220)

```php
public function destroy($id) {
    // ADD THIS CHECK
    if (Auth::user()->role !== 'pustakawan') {
        session()->flash('error', 'Anda tidak memiliki izin untuk menghapus eksemplar!');
        return;
    }

    // ... rest of existing code
}

// JUGA tambahkan di store() (line ~108) dan update() (line ~169)
```

---

### Fix #2: Enkripsi Email Password di Database

**Problem**: Email password disimpan plain text di database dan .env.

**Files to Edit**:

1. `app/Livewire/PengaturanComponent.php`
2. `app/Providers/AppServiceProvider.php`
3. Create migration untuk enkripsi data existing

#### Step 1: Update PengaturanComponent.php

```php
// File: app/Livewire/PengaturanComponent.php
use Illuminate\Support\Facades\Crypt;

public function simpan()
{
    // ... existing validation ...

    try {
        foreach ($this->pengaturan as $key => $value) {
            // ENKRIPSI password sebelum simpan
            if ($key === 'email_password') {
                Pengaturan::set($key, Crypt::encryptString($value));
            } else {
                Pengaturan::set($key, $value);
            }
        }

        // HAPUS update .env untuk password (security risk)
        // $this->updateEnvFile(); // COMMENT OUT atau ubah logiknya

        // UPDATE: Only update non-sensitive configs to .env
        $this->updateEnvFileSecure();

        Log::info('Pengaturan diubah', [
            'user' => Auth::user()->nama_user,
            // JANGAN log password!
            'data' => array_diff_key($this->pengaturan, ['email_password' => ''])
        ]);

        session()->flash('success', 'Pengaturan berhasil disimpan!');
    } catch (\Exception $e) {
        Log::error('Gagal menyimpan pengaturan', ['error' => $e->getMessage()]);
        session()->flash('error', 'Gagal menyimpan pengaturan!');
    }
}

// NEW METHOD: Update .env tanpa password
private function updateEnvFileSecure()
{
    $envPath = base_path('.env');

    if (file_exists($envPath)) {
        $envContent = file_get_contents($envPath);

        // HANYA update non-sensitive configs
        $updates = [
            'MAIL_HOST' => $this->pengaturan['email_host'] ?? 'smtp.gmail.com',
            'MAIL_PORT' => $this->pengaturan['email_port'] ?? '465',
            'MAIL_ENCRYPTION' => $this->pengaturan['email_encryption'] ?? 'ssl',
            'MAIL_USERNAME' => $this->pengaturan['email_username'] ?? '',
            'MAIL_FROM_ADDRESS' => $this->pengaturan['email_from_address'] ?? '',
            'MAIL_FROM_NAME' => '"' . ($this->pengaturan['email_from_name'] ?? 'Perpustakaan') . '"',
            // PASSWORD TIDAK DITULIS KE .ENV!
        ];

        foreach ($updates as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}={$value}";

            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                $envContent .= "\n{$replacement}";
            }
        }

        file_put_contents($envPath, $envContent);
        \Artisan::call('config:clear');
    }
}
```

#### Step 2: Update AppServiceProvider.php

```php
// File: app/Providers/AppServiceProvider.php
use Illuminate\Support\Facades\Crypt;

public function boot(): void
{
    try {
        $emailSettings = DB::table('pengaturan')
            ->whereIn('key', [
                'email_host', 'email_port', 'email_encryption',
                'email_username', 'email_password',
                'email_from_address', 'email_from_name'
            ])
            ->pluck('value', 'key');

        if ($emailSettings->isNotEmpty()) {
            // DECRYPT password saat load
            $password = $emailSettings->get('email_password');
            $decryptedPassword = $password ? Crypt::decryptString($password) : '';

            Config::set([
                'mail.mailers.smtp.host' => $emailSettings->get('email_host', env('MAIL_HOST')),
                'mail.mailers.smtp.port' => $emailSettings->get('email_port', env('MAIL_PORT')),
                'mail.mailers.smtp.encryption' => $emailSettings->get('email_encryption', env('MAIL_ENCRYPTION')),
                'mail.mailers.smtp.username' => $emailSettings->get('email_username', env('MAIL_USERNAME')),
                'mail.mailers.smtp.password' => $decryptedPassword, // Use decrypted password
                'mail.from.address' => $emailSettings->get('email_from_address', env('MAIL_FROM_ADDRESS')),
                'mail.from.name' => $emailSettings->get('email_from_name', env('MAIL_FROM_NAME'))
            ]);
        }
    } catch (\Exception $e) {
        Log::warning('Failed to load email config from database', ['error' => $e->getMessage()]);
    }
}
```

#### Step 3: Create Migration untuk Enkripsi Data Existing

```bash
php artisan make:migration encrypt_existing_email_passwords
```

```php
// File: database/migrations/2026_01_02_xxxxx_encrypt_existing_email_passwords.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

return new class extends Migration
{
    public function up(): void
    {
        // Enkripsi password yang sudah ada
        $emailPassword = DB::table('pengaturan')
            ->where('key', 'email_password')
            ->first();

        if ($emailPassword && $emailPassword->value) {
            // Cek apakah sudah terenkripsi (jika sudah pernah dijalankan)
            try {
                Crypt::decryptString($emailPassword->value);
                // Sudah terenkripsi, skip
            } catch (\Exception $e) {
                // Belum terenkripsi, enkripsi sekarang
                DB::table('pengaturan')
                    ->where('key', 'email_password')
                    ->update(['value' => Crypt::encryptString($emailPassword->value)]);
            }
        }
    }

    public function down(): void
    {
        // Rollback: Decrypt kembali
        $emailPassword = DB::table('pengaturan')
            ->where('key', 'email_password')
            ->first();

        if ($emailPassword && $emailPassword->value) {
            try {
                $decrypted = Crypt::decryptString($emailPassword->value);
                DB::table('pengaturan')
                    ->where('key', 'email_password')
                    ->update(['value' => $decrypted]);
            } catch (\Exception $e) {
                // Already decrypted or invalid
            }
        }
    }
};
```

**Jalankan Migration**:

```bash
php artisan migrate
```

---

### Fix #3: Login Rate Limiting

**Problem**: Tidak ada proteksi brute force attack pada login.

**File to Edit**: `app/Livewire/LoginComponent.php`

```php
// File: app/Livewire/LoginComponent.php
use Illuminate\Support\Facades\RateLimiter;

public function proses()
{
    // RATE LIMITING: 5 attempts per minute per email+IP
    $throttleKey = 'login-' . $this->email . '-' . request()->ip();

    if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
        $seconds = RateLimiter::availableIn($throttleKey);
        session()->flash('error', "Terlalu banyak percobaan login gagal. Silakan coba lagi dalam {$seconds} detik.");
        $this->reset('password');
        return;
    }

    // Cek apakah user sudah login
    if (Auth::check()) {
        session()->flash('info', 'Anda sudah login!');
        return redirect()->route('home');
    }

    $credentials = $this->validate([
        'email' => 'required|email',
        'password' => 'required',
    ], [
        'email.required' => 'Email tidak boleh kosong!',
        'email.email' => 'Format email tidak valid!',
        'password.required' => 'Password tidak boleh kosong!',
    ]);

    if (Auth::attempt($credentials)) {
        // CLEAR rate limit on successful login
        RateLimiter::clear($throttleKey);

        session()->regenerate();
        $user = Auth::user();
        $roleLabel = match ($user->role) {
            'pustakawan' => 'Pustakawan',
            'kepala' => 'Kepala Sekolah',
            default => ucfirst($user->role)
        };

        session()->flash('success', "Login berhasil! Selamat datang {$user->nama_user} sebagai {$roleLabel}.");
        return redirect()->route('home');
    }

    // INCREMENT rate limit on failed login
    RateLimiter::hit($throttleKey, 60); // 60 seconds decay

    session()->flash('error', 'Email atau password yang Anda masukkan salah!');
    $this->reset('password');
}
```

---

### Fix #4: Remove Sensitive Data from Logs

**Problem**: Password dan kredensial ter-log dalam plain text.

**Files to Edit**:

1. `app/Livewire/PengaturanComponent.php` (sudah diperbaiki di Fix #2)
2. Create helper function untuk sanitize logs

#### Create LogHelper.php

```php
// File: app/Helpers/LogHelper.php
<?php

namespace App\Helpers;

class LogHelper
{
    /**
     * Remove sensitive keys from array before logging
     */
    public static function sanitize(array $data): array
    {
        $sensitiveKeys = [
            'password',
            'password_confirmation',
            'old_password',
            'new_password',
            'email_password',
            'current_password',
            'token',
            'api_key',
            'secret'
        ];

        foreach ($sensitiveKeys as $key) {
            if (isset($data[$key])) {
                $data[$key] = '***REDACTED***';
            }
        }

        return $data;
    }
}
```

#### Register Helper di composer.json

```json
// File: composer.json
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Database\\Factories\\": "database/factories/",
        "Database\\Seeders\\": "database/seeders/"
    },
    "files": [
        "app/Helpers/LogHelper.php"
    ]
}
```

**Jalankan**:

```bash
composer dump-autoload
```

#### Update PengaturanComponent.php (tambahan dari Fix #2)

```php
use App\Helpers\LogHelper;

public function simpan()
{
    // ... existing code ...

    Log::info('Pengaturan diubah', [
        'user' => Auth::user()->nama_user,
        'data' => LogHelper::sanitize($this->pengaturan) // Use sanitizer
    ]);
}
```

---

## 🔨 HIGH PRIORITY FIXES (Priority 2)

### Fix #5: XSS Input Sanitization

**Problem**: User bisa inject `<script>` tag di nama anggota, judul buku, dll.

**Solution**: Strip HTML tags sebelum save.

**Files to Edit**: Semua component dengan user input

#### AnggotaComponent.php

```php
public function store()
{
    // ... existing authorization check ...

    $this->validate([...]);

    // SANITIZE INPUT - strip HTML tags
    $this->nama_anggota = strip_tags($this->nama_anggota);
    $this->alamat = strip_tags($this->alamat);
    $this->institusi = strip_tags($this->institusi);

    Anggota::create([
        'nama_anggota' => $this->nama_anggota,
        'email' => $this->email,
        // ... rest
    ]);
}

// ALSO in update() method
public function update()
{
    // ... existing validation ...

    // SANITIZE
    $this->nama_anggota = strip_tags($this->nama_anggota);
    $this->alamat = strip_tags($this->alamat);

    // ... rest of code
}
```

#### BukuComponent.php

```php
public function store()
{
    // ... existing code ...

    // SANITIZE judul buku
    $this->judul = strip_tags($this->judul);

    $buku = Buku::create([
        'judul' => $this->judul,
        // ... rest
    ]);
}
```

#### KategoriComponent.php

```php
public function store()
{
    // ... existing code ...

    // SANITIZE
    $this->nama = strip_tags($this->nama);
    $this->deskripsi = strip_tags($this->deskripsi);

    Kategori::create([...]);
}
```

**Apply same pattern to**: UserComponent, EksemplarComponent, ProfilComponent

---

### Fix #6: Password Complexity Rules

**Problem**: Password hanya butuh 6 karakter.

**Files to Edit**:

1. `app/Livewire/UserComponent.php`
2. `app/Livewire/ProfilComponent.php`

```php
// UserComponent::store() - line ~72
$this->validate([
    'nama_user' => 'required',
    'email' => 'required|email|unique:users,email',
    'password' => [
        'required',
        'min:8', // Naik dari 6
        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/' // Min 1 huruf besar, kecil, angka
    ],
    'role' => 'required|in:kepala,pustakawan'
], [
    // ... existing messages ...
    'password.min' => 'Password minimal 8 karakter!',
    'password.regex' => 'Password harus mengandung minimal 1 huruf besar, 1 huruf kecil, dan 1 angka!'
]);

// Apply same to ProfilComponent::updatePassword()
```

---

### Fix #7: Date Validation Enhancement

**Problem**: User bisa input tanggal pinjam 10 tahun lalu.

**Files to Edit**:

1. `app/Livewire/PeminjamanComponent.php`
2. `app/Livewire/PengembalianComponent.php`

```php
// PeminjamanComponent::store() - line ~227
$this->validate([
    'id_anggota' => 'required|exists:anggota,id_anggota',
    'tgl_pinjam' => [
        'required',
        'date',
        'before_or_equal:today' // TAMBAHKAN INI
    ],
    'tgl_jatuh_tempo' => 'required|date|after_or_equal:tgl_pinjam',
    'selectedEksemplar' => 'required|array|min:1|max:' . $maxBuku
], [
    // ... existing messages ...
    'tgl_pinjam.before_or_equal' => 'Tanggal pinjam tidak boleh tanggal masa depan!'
]);

// PengembalianComponent::prosesKembalikan() - line ~187
$this->validate([
    'tgl_kembali' => [
        'required',
        'date',
        'before_or_equal:today' // TAMBAHKAN INI
    ],
], [
    'tgl_kembali.required' => 'Tanggal kembali harus diisi!',
    'tgl_kembali.date' => 'Format tanggal tidak valid!',
    'tgl_kembali.before_or_equal' => 'Tanggal kembali tidak boleh tanggal masa depan!'
]);
```

---

### Fix #8: File Upload MIME Type Validation

**Problem**: Attacker bisa upload shell.php dengan rename ke .jpg.

**File to Edit**: `app/Livewire/ProfilComponent.php`

```php
// ProfilComponent::updateProfil() - line ~37
$this->validate([
    'nama_user' => 'required|max:255',
    'email' => 'required|email|unique:users,email,' . Auth::id() . ',id_user',
    'foto_profil' => [
        'nullable',
        'image',
        'mimes:jpeg,png,jpg', // Eksplisit MIME types
        'max:2048',
        // Custom validation untuk MIME type
        function ($attribute, $value, $fail) {
            if ($value) {
                $mimeType = $value->getMimeType();
                $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg'];

                if (!in_array($mimeType, $allowedMimes)) {
                    $fail('File harus berupa gambar JPG atau PNG!');
                }
            }
        }
    ]
], [
    // ... existing messages ...
    'foto_profil.mimes' => 'File harus berupa gambar JPG atau PNG!',
]);

// Handle upload
if ($this->foto_profil) {
    // ... existing delete old file code ...

    // IMPROVED filename generation
    $extension = $this->foto_profil->extension();
    $filename = 'profil_' . Auth::id() . '_' . time() . '_' . Str::random(10) . '.' . $extension;
    $path = $this->foto_profil->storeAs('foto_profil', $filename, 'public');
    $dataUpdate['foto_profil'] = $path;
}
```

---

## 🛠️ MEDIUM PRIORITY FIXES (Priority 3)

### Fix #9: Password Reset Feature

**Implementation**: Gunakan Laravel's built-in password reset.

**Step 1**: Generate password reset migrations

```bash
php artisan make:migration create_password_reset_tokens_table
```

**Step 2**: Create PasswordResetComponent

```bash
php artisan make:livewire PasswordResetComponent
```

```php
// app/Livewire/PasswordResetComponent.php
<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetComponent extends Component
{
    public $email;
    public $token;
    public $password;
    public $password_confirmation;

    public function requestReset()
    {
        $this->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('success', 'Link reset password telah dikirim ke email Anda!');
        } else {
            session()->flash('error', 'Email tidak ditemukan!');
        }
    }

    public function resetPassword()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ]
        ]);

        $status = Password::reset([
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'token' => $this->token
        ], function ($user, $password) {
            $user->password = Hash::make($password);
            $user->setRememberToken(Str::random(60));
            $user->save();
        });

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('success', 'Password berhasil direset!');
            return redirect()->route('login');
        } else {
            session()->flash('error', 'Token reset tidak valid!');
        }
    }

    public function render()
    {
        return view('livewire.password-reset-component');
    }
}
```

---

### Fix #10: Form Submission Rate Limiting

**Implementation**: Throttle CRUD operations untuk prevent spam.

**Create Middleware**: `ThrottleFormSubmissions.php`

```php
// app/Http/Middleware/ThrottleFormSubmissions.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\RateLimiter;

class ThrottleFormSubmissions
{
    public function handle($request, Closure $next)
    {
        $key = 'form-submit-' . auth()->id() . '-' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 20)) { // 20 submissions per minute
            return response()->json([
                'message' => 'Terlalu banyak request! Tunggu sebentar.'
            ], 429);
        }

        RateLimiter::hit($key, 60);

        return $next($request);
    }
}
```

**Register Middleware** di `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->web([
        \App\Http\Middleware\ThrottleFormSubmissions::class,
    ]);
})
```

---

### Fix #11: Comprehensive Audit Trail

**Create Migration**:

```bash
php artisan make:migration add_metadata_to_log_aktivitas_table
```

```php
// Migration file
public function up(): void
{
    Schema::table('log_aktivitas', function (Blueprint $table) {
        $table->string('ip_address', 45)->nullable()->after('aktivitas');
        $table->string('user_agent')->nullable()->after('ip_address');
        $table->string('action_type', 50)->nullable()->after('user_agent'); // CREATE, UPDATE, DELETE, READ
        $table->string('target_model', 100)->nullable()->after('action_type'); // Model name
        $table->unsignedBigInteger('target_id')->nullable()->after('target_model'); // Record ID
        $table->json('changes')->nullable()->after('target_id'); // JSON old/new values
    });
}
```

**Create LogActivity Helper**:

```php
// app/Helpers/ActivityLogger.php
<?php

namespace App\Helpers;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log(
        string $aktivitas,
        string $actionType = 'READ',
        ?string $targetModel = null,
        ?int $targetId = null,
        ?array $changes = null
    ): void {
        LogAktivitas::create([
            'id_user' => Auth::id(),
            'aktivitas' => $aktivitas,
            'waktu' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'action_type' => $actionType,
            'target_model' => $targetModel,
            'target_id' => $targetId,
            'changes' => $changes ? json_encode($changes) : null
        ]);
    }
}
```

**Usage Example** di AnggotaComponent:

```php
use App\Helpers\ActivityLogger;

public function store()
{
    // ... existing code ...

    $anggota = Anggota::create([...]);

    // LOG ACTIVITY
    ActivityLogger::log(
        'Menambah anggota: ' . $this->nama_anggota,
        'CREATE',
        'Anggota',
        $anggota->id_anggota
    );
}

public function update()
{
    // ... existing code ...

    $old = $anggota->getOriginal();
    $anggota->update([...]);

    // LOG ACTIVITY with changes
    ActivityLogger::log(
        'Mengupdate anggota: ' . $anggota->nama_anggota,
        'UPDATE',
        'Anggota',
        $anggota->id_anggota,
        [
            'old' => $old,
            'new' => $anggota->toArray()
        ]
    );
}
```

---

## 📋 IMPLEMENTATION CHECKLIST

### Critical Fixes (Week 1)

-   [ ] **Fix #1**: Authorization checks di CRUD (4 files)
    -   [ ] AnggotaComponent.php
    -   [ ] BukuComponent.php
    -   [ ] KategoriComponent.php
    -   [ ] EksemplarComponent.php
-   [ ] **Fix #2**: Email password encryption (3 steps)
    -   [ ] Update PengaturanComponent.php
    -   [ ] Update AppServiceProvider.php
    -   [ ] Run encryption migration
-   [ ] **Fix #3**: Login rate limiting
    -   [ ] Update LoginComponent.php
-   [ ] **Fix #4**: Remove sensitive logs
    -   [ ] Create LogHelper.php
    -   [ ] Update PengaturanComponent.php

### High Priority (Week 2)

-   [ ] **Fix #5**: XSS sanitization (6 files)

    -   [ ] AnggotaComponent.php
    -   [ ] BukuComponent.php
    -   [ ] KategoriComponent.php
    -   [ ] UserComponent.php
    -   [ ] ProfilComponent.php
    -   [ ] EksemplarComponent.php

-   [ ] **Fix #6**: Password complexity

    -   [ ] UserComponent.php
    -   [ ] ProfilComponent.php

-   [ ] **Fix #7**: Date validation

    -   [ ] PeminjamanComponent.php
    -   [ ] PengembalianComponent.php

-   [ ] **Fix #8**: File upload MIME validation
    -   [ ] ProfilComponent.php

### Medium Priority (Week 3-4)

-   [ ] **Fix #9**: Password reset feature

    -   [ ] Create migration
    -   [ ] Create PasswordResetComponent
    -   [ ] Create views
    -   [ ] Add routes

-   [ ] **Fix #10**: Form submission throttling

    -   [ ] Create ThrottleFormSubmissions middleware
    -   [ ] Register middleware
    -   [ ] Test

-   [ ] **Fix #11**: Comprehensive audit trail
    -   [ ] Create migration for log_aktivitas
    -   [ ] Create ActivityLogger helper
    -   [ ] Update all CRUD components
    -   [ ] Create audit report view

### Testing

-   [ ] Security testing untuk setiap fix
-   [ ] Manual testing semua form
-   [ ] Browser console testing (authorization bypass)
-   [ ] SQL injection testing
-   [ ] XSS testing
-   [ ] File upload testing
-   [ ] Rate limiting testing

---

## 🧪 TESTING COMMANDS

```bash
# Test login rate limiting
# Try login 6 times with wrong password → should get throttled

# Test authorization bypass
# Login as Kepala → open browser console → try:
Livewire.dispatch('deleteAnggota', { id: 1 })

# Test XSS
# Input di nama anggota: <script>alert('XSS')</script>
# Should be stripped or escaped

# Test file upload
# Try upload shell.php renamed to shell.jpg
# Should be rejected by MIME validation

# Test password complexity
# Try create user with password "test123"
# Should fail validation

# Run security audit
composer audit
php artisan security:check

# Static analysis
./vendor/bin/phpstan analyse app
```

---

## 📞 SUPPORT

Jika ada pertanyaan atau issue saat implementasi, dokumentasikan di:

-   **Issue Tracker**: Project GitHub Issues
-   **Contact**: Developer Team

---

**Next Todo**: Setelah semua fixes diimplementasi, lanjut ke **Todo #3: Code Quality & Best Practices**.
