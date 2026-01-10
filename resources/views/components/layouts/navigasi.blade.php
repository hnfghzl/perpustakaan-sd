<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top shadow-sm px-3 px-md-4 py-2 py-md-3">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        {{-- Bagian kiri --}}
        <div class="d-flex align-items-center">
            <h4 class="fw-bold mb-0 d-none d-md-block">Dashboard</h4>
            <h5 class="fw-bold mb-0 d-md-none">Dashboard</h5>
        </div>

        {{-- Bagian kanan --}}
        <div class="d-flex align-items-center">
            {{-- User Profile Dropdown --}}
            <div class="dropdown">
                <button class="btn border-0 p-0 dropdown-toggle dropdown-toggle-no-caret d-flex align-items-center" 
                        type="button" 
                        id="userDropdown" 
                        data-toggle="dropdown" 
                        aria-haspopup="true" 
                        aria-expanded="false"
                        aria-label="User Menu">
                    {{-- Avatar Circle --}}
                    <div class="user-avatar" style="width: 40px; height: 40px;">
                        @if(Auth::user()->foto_profil)
                            <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" 
                                 alt="{{ Auth::user()->nama_user }}" 
                                 class="rounded-circle"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_user) }}&background=6366f1&color=fff&bold=true&size=128" 
                                 alt="{{ Auth::user()->nama_user }}" 
                                 class="rounded-circle"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    </div>
                </button>
                
                <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="userDropdown" style="min-width: 220px; max-width: 280px;">
                    {{-- User Info Header --}}
                    <div class="px-3 py-3 border-bottom bg-light">
                        <div class="d-flex align-items-center">
                            @if(Auth::user()->foto_profil)
                                <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" 
                                     alt="{{ Auth::user()->nama_user }}" 
                                     class="rounded-circle me-2" 
                                     style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_user) }}&background=6366f1&color=fff&bold=true&size=128" 
                                     alt="{{ Auth::user()->nama_user }}" 
                                     class="rounded-circle me-2" 
                                     style="width: 40px; height: 40px;">
                            @endif
                            <div>
                                <strong class="d-block text-truncate" style="max-width: 140px;">{{ Auth::user()->nama_user }}</strong>
                                <small class="text-muted d-block text-truncate" style="max-width: 140px;">{{ Auth::user()->email }}</small>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Dropdown Items --}}
                    <a class="dropdown-item py-2" href="{{ route('profil') }}">
                        <i data-feather="user" style="width: 16px; height: 16px;"></i>
                        <span class="ms-2">Edit Profil</span>
                    </a>
                    
                    <div class="dropdown-divider my-0"></div>
                    
                    <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}">
                        <i data-feather="log-out" style="width: 16px; height: 16px;"></i>
                        <span class="ms-2">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('menu-toggle');
        const sidebar = document.querySelector('.sidebar');
        toggleBtn.addEventListener('click', () => sidebar.classList.toggle('open'));
        
        // Initial feather icons replace
        feather.replace();
        
        // Re-replace feather icons when dropdown opens (for dynamic content)
        $('#userDropdown').on('shown.bs.dropdown', function () {
            feather.replace();
        });
    });
</script>

<style>
    /* User Avatar Styling */
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 2px solid #e0e0e0;
    }
    
    .user-avatar:hover {
        border-color: #1ABC9C;
        box-shadow: 0 0 0 3px rgba(26, 188, 156, 0.2);
    }
    
    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Remove default dropdown arrow */
    .dropdown-toggle-no-caret::after {
        display: none !important;
    }

    /* Dropdown styling */
    .dropdown-menu {
        border-radius: 0.75rem;
        border: 1px solid #e0e0e0;
        padding: 0;
        margin-top: 0.75rem !important;
        animation: slideDown 0.2s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .dropdown-item {
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        padding: 0.6rem 1rem;
    }
    
    .dropdown-item:hover {
        background: linear-gradient(135deg, rgba(26, 188, 156, 0.1) 0%, rgba(22, 160, 133, 0.1) 100%);
        padding-left: 1.25rem;
    }
    
    .dropdown-item.text-danger:hover {
        background-color: #fff5f5;
        color: #dc3545 !important;
    }
</style>
