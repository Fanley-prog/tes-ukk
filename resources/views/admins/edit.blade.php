<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
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
                    <a href="{{ route('settings.edit') }}" class="nav-link">Settings</a>
                </li>
                <li>
                    <a href="{{ route('admins.index') }}" class="nav-link active">Kelola Admin</a>
                </li>
                <li>
                    <a href="{{ route('activity-logs.index') }}" class="nav-link">Activity Log</a>
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
            <h1>Edit Admin</h1>

            @if ($errors->any())
                <div class="errors" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="panel">
                <form class="form-add" action="{{ route('admins.update', $admin->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="field">
                        <label class="field-label" for="name">Username</label>
                        <input class="field-control" id="name" name="name" type="text"
                               value="{{ old('name', $admin->name) }}" required>
                    </div>

                    <div class="field">
                        <label class="field-label" for="password">Password baru</label>
                        <input class="field-control" id="password" name="password" type="password"
                               autocomplete="new-password">
                        <span class="field-hint">Kosongkan kalau tidak ingin mengganti password.</span>
                    </div>

                    <div class="field">
                        <label class="field-label" for="password_confirmation">Ulangi password baru</label>
                        <input class="field-control" id="password_confirmation" name="password_confirmation"
                               type="password" autocomplete="new-password">
                    </div>

                    <div class="actions">
                        <button class="action-button" type="submit">Simpan perubahan</button>
                        <a class="link-back" href="{{ route('admins.index') }}">Batal</a>
                    </div>
                </form>
            </section>
        </main>
    </div>
</body>
</html>