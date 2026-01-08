<nav class="sidebar d-flex flex-column text-white p-3">
    
    <div class="text-center mb-4" style="padding: 12px 0;">
        <a href="<?php echo e(route('home')); ?>" style="text-decoration: none;">
            <img src="<?php echo e(asset('asset/logo.png')); ?>" alt="App Logo" class="img-fluid mb-3" style="max-width: 80px; border-radius: 50%; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
        </a>
        <h6 class="fw-bold text-white mb-0" style="font-size: 13px; letter-spacing: 0.5px; line-height: 1.4;">SD MUHAMMADIYAH<br>KARANGWARU</h6>
    </div>

    
    <div style="height: 1px; background: rgba(255, 255, 255, 0.15); margin: 0 0 20px 0;"></div>

    
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a class="nav-link text-white d-flex align-items-center <?php echo e(request()->is('home') ? 'menu-active' : ''); ?>" href="<?php echo e(route('home')); ?>">
                <i data-feather="home" class="me-2"></i> 
                <span>Dashboard</span>
            </a>
        </li>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->role === 'kepala'): ?>
            
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center <?php echo e(request()->is('laporan') ? 'menu-active' : ''); ?>" href="<?php echo e(route('laporan')); ?>">
                    <i data-feather="bar-chart-2" class="me-2"></i>
                    <span>Laporan</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center <?php echo e(request()->is('user') ? 'menu-active' : ''); ?>" href="<?php echo e(route('user')); ?>">
                    <i data-feather="users" class="me-2"></i>
                    <span>Kelola User</span>
                </a>
            </li>
        <?php else: ?>
            
            
            
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex justify-content-between align-items-center menu-parent <?php echo e(request()->is('anggota', 'buku', 'kategori', 'history-peminjaman', 'history-pengembalian') ? 'menu-parent-active' : ''); ?>" 
                   data-toggle="collapse" 
                   href="#masterDataMenu" 
                   role="button" 
                   aria-expanded="<?php echo e(request()->is('anggota', 'buku', 'kategori', 'history-peminjaman', 'history-pengembalian') ? 'true' : 'false'); ?>"
                   aria-controls="masterDataMenu">
                    <span class="d-flex align-items-center">
                        <i data-feather="database" class="me-2"></i>
                        <span>Master Data</span>
                    </span>
                    <i data-feather="chevron-down" class="chevron-icon"></i>
                </a>
                <div class="collapse <?php echo e(request()->is('anggota', 'buku', 'kategori', 'history-peminjaman', 'history-pengembalian') ? 'show' : ''); ?>" id="masterDataMenu">
                    <ul class="nav flex-column ms-2 mt-1">
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center submenu-item <?php echo e(request()->is('anggota') ? 'menu-active' : ''); ?>" href="<?php echo e(route('anggota')); ?>">
                                <i data-feather="users" class="me-2"></i>
                                <span>Anggota</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center submenu-item <?php echo e(request()->is('buku') ? 'menu-active' : ''); ?>" href="<?php echo e(route('buku')); ?>">
                                <i data-feather="book" class="me-2"></i>
                                <span>Buku & Eksemplar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center submenu-item <?php echo e(request()->is('kategori') ? 'menu-active' : ''); ?>" href="<?php echo e(route('kategori')); ?>">
                                <i data-feather="tag" class="me-2"></i>
                                <span>Kategori</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center submenu-item <?php echo e(request()->is('history-peminjaman') ? 'menu-active' : ''); ?>" href="<?php echo e(route('history-peminjaman')); ?>">
                                <i data-feather="archive" class="me-2"></i>
                                <span>History Peminjaman</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center submenu-item <?php echo e(request()->is('history-pengembalian') ? 'menu-active' : ''); ?>" href="<?php echo e(route('history-pengembalian')); ?>">
                                <i data-feather="clock" class="me-2"></i>
                                <span>History Pengembalian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex justify-content-between align-items-center menu-parent <?php echo e(request()->is('peminjaman', 'pengembalian') ? 'menu-parent-active' : ''); ?>" 
                   data-toggle="collapse" 
                   href="#transaksiMenu" 
                   role="button" 
                   aria-expanded="<?php echo e(request()->is('peminjaman', 'pengembalian') ? 'true' : 'false'); ?>"
                   aria-controls="transaksiMenu">
                    <span class="d-flex align-items-center">
                        <i data-feather="activity" class="me-2"></i>
                        <span>Transaksi</span>
                    </span>
                    <i data-feather="chevron-down" class="chevron-icon"></i>
                </a>
                <div class="collapse <?php echo e(request()->is('peminjaman', 'pengembalian') ? 'show' : ''); ?>" id="transaksiMenu">
                    <ul class="nav flex-column ms-2 mt-1">
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center submenu-item <?php echo e(request()->is('peminjaman') ? 'menu-active' : ''); ?>" href="<?php echo e(route('peminjaman')); ?>">
                                <i data-feather="file-text" class="me-2"></i>
                                <span>Peminjaman</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center submenu-item <?php echo e(request()->is('pengembalian') ? 'menu-active' : ''); ?>" href="<?php echo e(route('pengembalian')); ?>">
                                <i data-feather="rotate-ccw" class="me-2"></i>
                                <span>Pengembalian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center <?php echo e(request()->is('pengaturan') ? 'menu-active' : ''); ?>" href="<?php echo e(route('pengaturan')); ?>">
                    <i data-feather="settings" class="me-2"></i>
                    <span>Pengaturan</span>
                </a>
            </li>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </ul>

</nav>

<style>
    /* Base Sidebar Styling */
    .sidebar .nav-link {
        font-size: 14px;
        padding: 10px 14px;
        border-radius: 10px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 500;
        position: relative;
        overflow: hidden;
    }

    .sidebar .nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        transform: scaleY(0);
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar .nav-link:hover::before,
    .sidebar .nav-link.menu-active::before {
        transform: scaleY(1);
    }

    /* Normal Menu Hover */
    .sidebar .nav-link:hover {
        background: rgba(59, 130, 246, 0.15);
        padding-left: 18px;
    }

    /* Active Menu */
    .sidebar .nav-link.menu-active {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    /* Parent Menu Styling */
    .sidebar .nav-link.menu-parent {
        cursor: pointer;
    }

    .sidebar .nav-link.menu-parent:hover {
        background: rgba(59, 130, 246, 0.12);
    }

    .sidebar .nav-link.menu-parent-active {
        background: rgba(59, 130, 246, 0.2);
        font-weight: 600;
    }

    /* Submenu Styling */
    .sidebar .submenu-item {
        font-size: 13px;
        padding: 8px 14px;
        margin-bottom: 4px;
        border-radius: 8px;
    }

    .sidebar .submenu-item::before {
        display: none;
    }

    .sidebar .submenu-item:hover {
        background: rgba(59, 130, 246, 0.12);
        padding-left: 18px;
    }

    .sidebar .submenu-item.menu-active {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
    }

    /* Icon Sizing */
    .sidebar .nav-link i[data-feather] {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
    }

    .sidebar .submenu-item i[data-feather] {
        width: 16px;
        height: 16px;
    }

    /* Chevron Animation */
    .chevron-icon {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 16px !important;
        height: 16px !important;
        flex-shrink: 0;
    }

    a[aria-expanded="true"] .chevron-icon {
        transform: rotate(180deg);
    }

    /* Collapse Animation */
    .collapse {
        transition: height 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .collapsing {
        transition: height 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Spacing */
    .sidebar .nav-item {
        margin-bottom: 2px;
    }

    .sidebar .nav-item .collapse {
        margin-top: 4px;
    }

    /* Link Text */
    .sidebar .nav-link span {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Smooth Scrollbar for Sidebar */
    .sidebar {
        scrollbar-width: thin;
        scrollbar-color: rgba(59, 130, 246, 0.3) transparent;
    }

    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(59, 130, 246, 0.3);
        border-radius: 10px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(59, 130, 246, 0.5);
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        feather.replace();
        
        // Re-replace feather icons after collapse animation
        $('.collapse').on('shown.bs.collapse hidden.bs.collapse', function () {
            setTimeout(() => feather.replace(), 100);
        });

        // Auto-close other accordions when one is opened
        $('.collapse').on('show.bs.collapse', function () {
            $('.collapse.show').not(this).collapse('hide');
        });
    });
</script><?php /**PATH D:\Belajar\laragon\www\iscp\Projek_Perpus\resources\views/components/layouts/sidebar.blade.php ENDPATH**/ ?>