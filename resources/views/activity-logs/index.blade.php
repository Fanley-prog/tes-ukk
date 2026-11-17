<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background-color: #1c0f30;
            color: #eef1ff;
            font-family: sans-serif;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            position: sticky;
            top: 0;
            align-self: flex-start;
            flex: 0 0 260px;
            width: 260px;
            height: 100vh;
            padding: 32px 24px;
            background: rgba(7, 11, 30, 0.74);
            border-right: 1px solid rgba(255, 255, 255, 0.16);
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 14px;
            padding-bottom: 24px;
            margin-bottom: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.24);
        }

        .avatar {
            display: grid;
            place-items: center;
            flex: 0 0 44px;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #4a95f2;
            font-weight: bold;
        }

        .username {
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .nav-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .nav-link {
            display: block;
            width: 100%;
            padding: 12px 16px;
            border: 0;
            border-radius: 10px;
            background: transparent;
            color: #c6cff2;
            font: inherit;
            text-align: left;
            text-decoration: none;
            cursor: pointer;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.16);
            color: #fff;
        }

        /* ===== Konten ===== */
        .content {
            flex: 1;
            min-width: 0;
            padding: 32px;
        }

        .content h1 {
            margin: 0 0 24px;
            font-size: 22px;
        }

        .panel {
            padding: 28px;
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.04);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 12px 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.24);
            color: #c6cff2;
            font-size: 13px;
            letter-spacing: 1px;
            text-align: left;
            text-transform: uppercase;
        }

        td {
            padding: 14px 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            vertical-align: top;
        }

        .empty {
            color: #c6cff2;
            text-align: center;
        }

        .pagination {
            display: flex;
            gap: 8px;
            margin: 20px 0 0;
            padding: 0;
            list-style: none;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            padding: 8px 14px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            color: inherit;
            text-decoration: none;
        }

        .pagination .disabled span {
            opacity: 0.4;
        }
    </style>
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="profile">
                <div class="avatar">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="username">{{ auth()->user()->name }}</div>
            </div>

            <ul class="nav-list">
                <li>
                    <a href="{{ route('admin.index') }}" class="nav-link">Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('settings.edit') }}" class="nav-link">Settings</a>
                </li>
                <li>
                    <a href="{{ route('activity-logs.index') }}" class="nav-link active">Activity Log</a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link">Logout</button>
                    </form>
                </li>
            </ul>
        </aside>

        <main class="content">
            <h1>Activity Logs</h1>

            <section class="panel">
                <table>
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Admin</th>
                            <th>Aksi</th>
                            <th>Keterangan</th>
                            <th>IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $log->user?->name ?? 'Admin dihapus' }}</td>
                                <td>{{ $log->action }}</td>
                                <td>{{ $log->description }}</td>
                                <td>{{ $log->ip_address ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty">Belum ada aktivitas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $logs->links('pagination::simple-default') }}
            </section>
        </main>
    </div>
</body>
</html>