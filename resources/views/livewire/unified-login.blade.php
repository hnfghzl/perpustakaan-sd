<div>
    <div style="text-align: center; margin-bottom: 32px;">
        <img src="{{ asset('asset/Logo.png') }}" alt="Logo" style="width: 75px; height: 75px; object-fit: contain; margin-bottom: 18px;">
        <h1 style="font-size: 1.75rem; font-weight: 700; color: #0f172a; margin: 0 0 6px;">Login Akun Anda</h1>
        <p style="font-size: 0.9rem; color: #64748b; margin: 0;">Masuk untuk mengakses dashboard Anda.</p>
    </div>

    {{-- Flash Messages --}}
    @if(session()->has('error'))
        <div class="ul-alert ul-alert-danger" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="flex-shrink:0">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.553.553 0 0 1-1.1 0L7.1 4.995z"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="ul-alert ul-alert-success" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="flex-shrink:0">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form wire:submit.prevent="proses">
        {{-- Identifier --}}
        <div class="ul-field-group">
            <label class="ul-label">
                Email / ID Anggota / NIS
                <span style="color: #ef4444;">*</span>
            </label>
            <div class="ul-input-wrapper">
                <span class="ul-input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    </svg>
                </span>
                <input
                    type="text"
                    wire:model="identifier"
                    class="ul-input"
                    id="identifier"
                    placeholder="Masukkan email, ID anggota, atau NIS"
                    autocomplete="username"
                >
            </div>
            @error('identifier')
                <span class="ul-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- Password --}}
        <div class="ul-field-group">
            <label class="ul-label">
                Password
                <span style="color: #ef4444;">*</span>
            </label>
            <div class="ul-input-wrapper">
                <span class="ul-input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                    </svg>
                </span>
                <input
                    type="{{ $showPassword ? 'text' : 'password' }}"
                    wire:model="password"
                    class="ul-input"
                    id="password"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                >
                <button type="button" class="ul-toggle-pw" wire:click="togglePassword" tabindex="-1">
                    @if($showPassword)
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                            <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                            <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                        </svg>
                    @endif
                </button>
            </div>
            @error('password')
                <span class="ul-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- Remember me --}}
        <div class="ul-remember-row">
            <label class="ul-remember-label">
                <input type="checkbox" wire:model="remember" class="ul-checkbox"> Ingat saya
            </label>
        </div>

        {{-- Submit --}}
        <button type="submit" class="ul-btn-login" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="proses">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" viewBox="0 0 16 16" style="margin-right:6px">
                    <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                    <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                </svg>
                Masuk
            </span>
            <span wire:loading wire:target="proses">
                <span class="ul-spinner"></span> Memproses...
            </span>
        </button>
    </form>

    <div class="ul-hint">
        <small>Admin/Pustakawan gunakan <strong>email</strong>. Anggota/Siswa gunakan <strong>NIS atau ID Anggota</strong>.</small>
    </div>
</div>
