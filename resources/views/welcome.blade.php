<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
        }

        .add-page {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            border: 2px dashed rgba(255, 255, 255, 0.4);
            border-radius: 12px;
            color: inherit;
            text-decoration: none;
            transition: background 0.2s;
        }

        .add-page:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .sites-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sites-table th {
            padding: 12px 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.24);
            color: #c6cff2;
            font-size: 13px;
            letter-spacing: 1px;
            text-align: left;
            text-transform: uppercase;
        }

        .sites-table td {
            padding: 18px 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .col-website {
            font-weight: 600;
        }

        .empty {
            color: #c6cff2;
            text-align: center;
        }

                .col-aksi {
            text-align: right;
        }

        .row-actions {
            display: flex;
            justify-content: flex-end;
            gap: 16px;
        }

        .row-actions form {
            margin: 0;
        }

        .row-actions button {
            padding: 0;
            border: 0;
            background: none;
            color: #ffb3bf;
            font: inherit;
            cursor: pointer;
        }

        .row-actions button:hover {
            text-decoration: underline;
        }

                .row-actions a {
            color: #eef1ff;
            text-decoration: none;
        }

        .row-actions a:hover {
            text-decoration: underline;
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
                    <a href="{{ route('admin.index') }}" class="nav-link active">Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('settings.edit') }}" class="nav-link">Settings</a>
                </li>
                <li>
                    <a href="{{ url('/activity-logs') }}" class="nav-link">Activity Log</a>
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
            <h1>Dashboard</h1>

            <section class="panel" aria-label="Daftar website">
                <a class="add-page" href="{{ url('/add') }}">+ Add page</a>

                <table class="sites-table">
                    <thead>
                        <tr>
                            <th scope="col">Website</th>
                            <th scope="col">Template</th>
                            <th scope="col">Slug</th>
                            <th scope="col" class="col-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($websites as $website)
                            <tr>
                                <td class="col-website">{{ $website->name_website }}</td>
                                <td>{{ $website->template?->name_template }}</td>
                                <td>{{ $website->slug }}</td>

                                    <td class="col-aksi">
                                        <div class="row-actions">
                                            <a href="{{ url('/edit/'.$website->id_website) }}">Edit</a>
                                            <form action="{{ url('/delete/'.$website->id_website) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Yakin ingin menghapus website ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                            <a href="{{ url('/template1/'.$website->slug) }}" target="_blank" rel="noopener">Lihat</a>
                                        </div>
                                    </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="empty">Belum ada website. Klik "+ Add page" untuk membuat yang pertama.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>