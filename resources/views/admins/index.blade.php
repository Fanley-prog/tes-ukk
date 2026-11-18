<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Admin</title>
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
            <h1>Kelola Admin</h1>

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

            <section class="panel">
                <h2>Tambah admin baru</h2>

                <form class="form-add" action="{{ route('admins.store') }}" method="POST">
                    @csrf

                    <div class="field">
                        <label class="field-label" for="name">Username</label>
                        <input class="field-control" id="name" name="name" type="text"
                               value="{{ old('name') }}" required>
                    </div>

                    <div class="field">
                        <label class="field-label" for="password">Password</label>
                        <input class="field-control" id="password" name="password" type="password"
                               autocomplete="new-password" required>
                    </div>

                    <div class="field">
                        <label class="field-label" for="password_confirmation">Ulangi password</label>
                        <input class="field-control" id="password_confirmation" name="password_confirmation"
                               type="password" autocomplete="new-password" required>
                    </div>

                    <button class="action-button" type="submit">Tambah admin</button>
                </form>
            </section>

            <section class="panel">
                <h2>Daftar akun</h2>

                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr>
                                <td>{{ $admin->name }}</td>
                                <td><span class="badge">{{ $admin->role }}</span></td>
                                <td>{{ $admin->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                <td>
                                    @if (! $admin->isSuperAdmin())
                                        <div class="row-actions">
                                            <a href="{{ route('admins.edit', $admin->id) }}">Edit</a>

                                            <form action="{{ route('admins.destroy', $admin->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-delete" type="submit"
                                                        onclick="return confirm('Yakin ingin menghapus admin ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>