<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
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
                @if (auth()->user()->isSuperAdmin())
                    <li>
                        <a href="{{ route('admins.index') }}" class="nav-link">Kelola Admin</a>
                    </li>
                @endif
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