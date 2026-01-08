    <div class="login-container">
        <div class="login-header">
            <img src="{{asset('asset/Logo.png')}}" alt="">
            <h2>Perpustakaan Login</h2>
        </div>

        {{-- Alert untuk pesan flash --}}
        @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session()->has('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <form>
            <div class="form-group">
                <input type="text" wire:model="email" class="form-control" id="email" placeholder="Email Address">
                @error('email')
                <div class="alert alert-danger" role="alert">{{ $message }} </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="password" wire:model="password" class="form-control" id="password" placeholder="Password">
                @error('password')
                <div class="alert alert-danger" role="alert">{{ $message }} </div>
                @enderror
            </div>
            <button type="button" wire:click="proses" class="btn btn-primary btn-login">Login</button>
        </form>
        <div class="text-center">
            <a href="#">Forgot password?</a>
        </div>
    </div>