<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
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
            max-width: 560px;
            padding: 28px;
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.04);
        }

        form {
            display: grid;
            gap: 18px;
        }

        .field {
            display: grid;
            gap: 6px;
        }

        .field-label {
            font-size: 14px;
            color: #c6cff2;
        }

        .field-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.06);
            color: inherit;
            font: inherit;
        }

        .actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .action-button {
            padding: 10px 24px;
            border: 1px solid rgba(255, 255, 255, 0.55);
            border-radius: 999px;
            background: transparent;
            color: inherit;
            font: inherit;
            text-decoration: none;
            cursor: pointer;
        }

        .action-button--save {
            background: #4a95f2;
            border-color: #4a95f2;
        }

        .errors {
            margin-bottom: 18px;
            padding: 12px 16px;
            border: 1px solid #ff8a9b;
            border-radius: 10px;
            background: rgba(255, 138, 155, 0.12);
            color: #ffb3bf;
        }

        .errors ul {
            margin: 0;
            padding-left: 20px;
        }

        .status {
            margin-bottom: 18px;
            padding: 12px 16px;
            border: 1px solid #6fd39a;
            border-radius: 10px;
            background: rgba(111, 211, 154, 0.12);
            color: #a6efc6;
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
                    <a href="{{ route('settings.edit') }}" class="nav-link active">Settings</a>
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
            <h1>Settings</h1>

            <section class="panel">
                @if (session('status'))
                    <div class="status" role="status">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="errors" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="field">
                        <label class="field-label" for="name">Username admin</label>
                        <input class="field-control" id="name" name="name" type="text"
                               value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div class="field">
                        <label class="field-label" for="current_password">Password saat ini</label>
                        <input class="field-control" id="current_password" name="current_password"
                               type="password" autocomplete="current-password" required>
                    </div>

                    <div class="field">
                        <label class="field-label" for="password">Password baru</label>
                        <input class="field-control" id="password" name="password"
                               type="password" autocomplete="new-password" required>
                    </div>

                    <div class="field">
                        <label class="field-label" for="password_confirmation">Ulangi password baru</label>
                        <input class="field-control" id="password_confirmation" name="password_confirmation"
                               type="password" autocomplete="new-password" required>
                    </div>

                    <div class="actions">
                        <a class="action-button" href="{{ route('admin.index') }}">Kembali</a>
                        <button class="action-button action-button--save" type="submit">Simpan Perubahan</button>
                    </div>
                </form>
            </section>
        </main>
    </div>
</body>
</html>