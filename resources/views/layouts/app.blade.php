<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Activity Manager v1' }}</title>
    <style>
        :root {
            --bg-color: #f8fafc;
            --surface-color: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --border-color: #e2e8f0;
            --success-bg: #dcfce7;
            --success-text: #166534;
            --error-bg: #fee2e2;
            --error-text: #991b1b;
            --font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--bg-color);
            color: var(--text-main);
            line-height: 1.6;
            padding: 2rem 1rem;
        }

        .container {
            max-width: 860px;
            margin: 0 auto;
        }

        header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        header h1 {
            font-size: 1.75rem;
            color: #0f172a;
        }

        header nav a {
            text-decoration: none;
            color: var(--primary);
            font-weight: 600;
        }

        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid transparent;
            transition: background-color 0.2s;
        }

        .btn-primary {
            background-color: var(--primary);
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-secondary {
            background-color: #e2e8f0;
            color: #334155;
        }

        .btn-secondary:hover {
            background-color: #cbd5e1;
        }

        .btn-danger {
            background-color: #ef4444;
            color: #ffffff;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .alert {
            padding: 0.875rem 1.25rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .alert-success {
            background-color: var(--success-bg);
            color: var(--success-text);
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background-color: var(--error-bg);
            color: var(--error-text);
            border: 1px solid #fecaca;
        }

        .card {
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-planned {
            background-color: #e0e7ff;
            color: #3730a3;
        }

        .badge-ongoing {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-done {
            background-color: #dcfce7;
            color: #166534;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            margin-bottom: 0.375rem;
            font-weight: 600;
            font-size: 0.875rem;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        input[type="email"],
        input[type="file"],
        textarea,
        select {
            width: 100%;
            padding: 0.625rem;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-family: inherit;
            font-size: 0.95rem;
            background-color: #fff;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .form-row-2 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .form-row-2-1 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        @media (min-width: 640px) {
            .form-row-2 {
                grid-template-columns: 1fr 1fr;
            }

            .form-row-2-1 {
                grid-template-columns: 2fr 1fr;
            }
        }

        .search-filter-card {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.75rem;
            align-items: flex-end;
        }

        @media (min-width: 768px) {
            .filter-grid {
                grid-template-columns: 2fr 1fr 1fr 1fr auto;
            }
        }

        .pagination-container {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .pagination-container nav {
            width: 100%;
        }

        /* Sembunyikan baris duplikat mobile agar tidak bertumpuk */
        .pagination-container nav > div:first-child {
            display: none;
        }

        /* Baris utama pagination */
        .pagination-container nav > div:last-child {
            display: flex !important;
            flex-direction: column;
            gap: 1rem;
            align-items: center;
            justify-content: space-between;
        }

        @media (min-width: 640px) {
            .pagination-container nav > div:last-child {
                flex-direction: row;
            }
        }

        .pagination-container p {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin: 0;
        }

        .pagination-container p span {
            font-weight: 600;
            color: var(--text-main);
        }

        .pagination-container span.shadow-sm {
            display: inline-flex;
            border-radius: 6px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            background: #ffffff;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .pagination-container span.shadow-sm a,
        .pagination-container span.shadow-sm span > span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.25rem;
            height: 2.25rem;
            padding: 0 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-main);
            text-decoration: none;
            background: #ffffff;
            border-right: 1px solid var(--border-color);
            transition: background-color 0.15s ease, color 0.15s ease;
        }

        .pagination-container span.shadow-sm > :last-child,
        .pagination-container span.shadow-sm > :last-child > span {
            border-right: none !important;
        }

        .pagination-container span.shadow-sm a:hover {
            background-color: #f1f5f9;
            color: var(--primary);
        }

        .pagination-container span.shadow-sm [aria-current="page"] span {
            background-color: var(--primary) !important;
            color: #ffffff !important;
            font-weight: 600;
        }

        .pagination-container span.shadow-sm [aria-disabled="true"] span {
            color: #94a3b8;
            background-color: #f8fafc;
            cursor: not-allowed;
        }

        .pagination-container svg {
            width: 1.125rem;
            height: 1.125rem;
            display: inline-block;
            vertical-align: middle;
        }

        .error {
            color: var(--error-text);
            font-size: 0.85rem;
            margin-top: 0.25rem;
            font-weight: 500;
        }

        .filter-bar {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-link {
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted);
            background: #fff;
            border: 1px solid var(--border-color);
        }

        .filter-link.active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div>
                <h1><a href="{{ route('activities.index') }}" style="text-decoration: none; color: inherit;">Activity Manager</a></h1>
            </div>
            <nav>
                <a href="{{ route('activities.index') }}" class="btn btn-secondary">Daftar Kegiatan</a>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kategori</a>
                <a href="{{ route('activities.trash') }}" class="btn btn-secondary">Tong Sampah</a>
                <a href="{{ route('activities.create') }}" class="btn btn-primary">+ Tambah Kegiatan</a>
            </nav>
        </header>

        <main>
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error" role="alert">
                    <strong>Terdapat kesalahan:</strong>
                    <ul style="margin-left: 1.25rem; margin-top: 0.5rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
