<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title ?? 'Dashboard'); ?></title>

    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('asset/admin-dashboard.css')); ?>">

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>


    <style>
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            overflow-y: auto;
            z-index: 100;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.closed {
            transform: translateX(-100%);
        }

        /* Konten utama */
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            background-color: #ffffff;
            transition: margin-left 0.3s ease-in-out;
        }

        .main-content.full-width {
            margin-left: 0;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }
        }

        .menu-toggle {
            position: fixed;
            top: 15px;
            left: 15px;
            background-color: #343a40;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            z-index: 101;
            display: none;
        }

        .active {
            background-color: #495057 !important;
        }
    </style>
</head>

<body>
    
    <button class="menu-toggle" onclick="toggleSidebar()">☰</button>

    
    <?php echo $__env->make('components.layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div class="main-content">
        <?php echo $__env->make('components.layouts.navigasi', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="container-fluid mt-4">
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>✓</strong> <?php echo e(session('success')); ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(session()->has('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>✗</strong> <?php echo e(session('error')); ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(session()->has('info')): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>ℹ</strong> <?php echo e(session('info')); ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(session()->has('warning')): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>⚠</strong> <?php echo e(session('warning')); ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php echo e($slot); ?>

        </div>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        // Cek apakah Livewire ter-load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Livewire !== 'undefined') {
                console.log('✅ Livewire loaded successfully!');
            } else {
                console.error('❌ Livewire NOT loaded!');
            }
        });

        feather.replace();

        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('open');
        }

        // Auto-hide alert setelah 5 detik
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000); // 5000ms = 5 detik
        });
    </script>
</body>

</html><?php /**PATH D:\Belajar\laragon\www\iscp\Projek_Perpus\resources\views/components/layouts/app.blade.php ENDPATH**/ ?>