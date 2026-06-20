<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk – Perpustakaan</title>
    <link rel="icon" type="image/png" href="{{ asset('asset/Logo.png') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Livewire styles --}}
    @livewireStyles

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* ── Card ── */
        .ul-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 42px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 4px 24px rgba(15, 23, 42, 0.08);
        }

        /* ── Alerts ── */
        .ul-alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            line-height: 1.45;
        }
        .ul-alert-danger  { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .ul-alert-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }

        /* ── Field Group ── */
        .ul-field-group { margin-bottom: 18px; }

        .ul-label {
            display: block;
            font-size: 0.83rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 7px;
        }

        /* ── Input wrapper ── */
        .ul-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .ul-input-icon {
            position: absolute;
            left: 14px;
            color: #9ca3af;
            display: flex;
            pointer-events: none;
        }
        .ul-input {
            width: 100%;
            padding: 11px 44px 11px 42px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.9rem;
            color: #0f172a;
            background: #f8fafc;
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
            font-family: 'Inter', sans-serif;
        }
        .ul-input:focus {
            border-color: #3b82f6;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }
        .ul-input::placeholder { color: #cbd5e1; }

        /* ── Toggle password ── */
        .ul-toggle-pw {
            position: absolute;
            right: 13px;
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            display: flex;
            align-items: center;
            padding: 0;
            transition: color .15s;
        }
        .ul-toggle-pw:hover { color: #3b82f6; }

        /* ── Error ── */
        .ul-error {
            display: block;
            font-size: 0.78rem;
            color: #ef4444;
            margin-top: 5px;
            padding-left: 2px;
        }

        /* ── Remember row ── */
        .ul-remember-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }
        .ul-remember-label {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 0.83rem;
            color: #64748b;
            cursor: pointer;
            user-select: none;
            margin: 0;
        }
        .ul-checkbox {
            width: 15px;
            height: 15px;
            cursor: pointer;
            accent-color: #3b82f6;
        }

        /* ── Login Button ── */
        .ul-btn-login {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: #fff;
            font-size: 0.95rem;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: background .2s, transform .1s;
            font-family: 'Inter', sans-serif;
        }
        .ul-btn-login:hover:not(:disabled) { background: #1d4ed8; }
        .ul-btn-login:active:not(:disabled) { transform: scale(0.98); }
        .ul-btn-login:disabled { opacity: .7; cursor: not-allowed; }

        /* ── Spinner ── */
        .ul-spinner {
            display: inline-block;
            width: 15px;
            height: 15px;
            border: 2px solid rgba(255,255,255,.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: ul-spin .7s linear infinite;
            vertical-align: middle;
        }
        @keyframes ul-spin { to { transform: rotate(360deg); } }

        /* ── Hint ── */
        .ul-hint {
            margin-top: 20px;
            text-align: center;
            font-size: 0.76rem;
            color: #94a3b8;
            line-height: 1.5;
        }

        /* ── Old Bootstrap overrides (if any) ── */
        .login-container { display: none !important; }
    </style>
</head>

<body>
    <div class="ul-card">
        {{ $slot }}
    </div>

    {{-- Livewire scripts --}}
    @livewireScripts
</body>
</html>
