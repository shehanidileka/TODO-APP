<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>To-Do App</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📝</text></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #eef0fe;
            --accent: #ec4899;
            --bg: #f6f7fc;
            --text-dark: #1e1b4b;
        }

        * { font-family: 'Poppins', sans-serif; }

        html, body {
            height: 100%;
        }

        body {
            background: var(--bg);
            background-image: radial-gradient(circle at 10% 0%, #e9e7fd 0%, transparent 40%),
                               radial-gradient(circle at 90% 10%, #fce7f3 0%, transparent 35%);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .page-wrap {
            width: 100%;
            max-width: 640px;
            padding: 40px 20px;
            margin: 0 auto;
        }

        .page-wrap.wide {
            max-width: 900px;
        }

        .app-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 28px;
            justify-content: center;
            text-align: left;
        }

        .app-header h1 {
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
            letter-spacing: -0.5px;
        }

        .app-header p {
            margin: 0;
            font-size: 0.85rem;
            color: #8886b8;
            font-weight: 500;
        }

        .app-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.35);
            flex-shrink: 0;
        }

        .card-panel {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(99, 102, 241, 0.10);
            padding: 28px;
            border: 1px solid rgba(255,255,255,0.6);
            animation: fadeUp 0.35s ease;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            border-radius: 12px;
            padding: 10px 22px;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 6px 16px rgba(99, 102, 241, 0.3);
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            border-radius: 12px;
            font-weight: 600;
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
            transition: all 0.2s ease;
        }
        .btn-success:hover { transform: translateY(-2px); }

        .btn-warning {
            background: #fef3c7;
            color: #92400e;
            border: none;
            border-radius: 10px;
            font-weight: 600;
        }
        .btn-warning:hover { background: #fde68a; color: #78350f; }

        .btn-danger {
            background: #fee2e2;
            color: #b91c1c;
            border: none;
            border-radius: 10px;
            font-weight: 600;
        }
        .btn-danger:hover { background: #fecaca; color: #991b1b; }

        .btn-secondary {
            background: #f1f2fb;
            color: #4b4a75;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-secondary:hover { background: #e4e5f8; }

        .form-control {
            border-radius: 12px;
            border: 1.5px solid #e6e7f5;
            padding: 10px 14px;
            font-size: 0.92rem;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
        }

        .form-label {
            font-size: 0.85rem;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .alert {
            border-radius: 14px;
            border: none;
            font-weight: 500;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.15);
        }
        .alert-success {
            background: #ecfdf5;
            color: #065f46;
        }

        @media (max-width: 576px) {
            .page-wrap { padding: 24px 14px; }
            .app-header h1 { font-size: 1.4rem; }
            .card-panel { padding: 18px; border-radius: 16px; }
        }
    </style>
</head>
<body>
    <div class="page-wrap @yield('wrap-class')">
        <div class="app-header">
            <div class="app-icon">📝</div>
            <div>
                <h1>To-Do App</h1>
                <p>Stay organized, stay on track</p>
            </div>
        </div>

        @if(session('success'))
            <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                ✅ {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(function () {
            const alertBox = document.getElementById('successAlert');
            if (alertBox) {
                alertBox.classList.remove('show');
                alertBox.classList.add('hide');
                setTimeout(() => alertBox.remove(), 300);
            }
        }, 3000);
    </script>

    @stack('scripts')
</body>
</html>