<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
                    <a href="{{ route('admin.index') }}" class="nav-link active">Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('settings.edit') }}" class="nav-link">Settings</a>
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
            <h1>Dashboard</h1>

            <section class="panel" aria-label="Daftar website">
                <div class="stat-card">
                    <span class="stat-number">{{ $totalWebsites }}</span>
                    <span class="stat-label">Jumlah UMKM</span>
                </div>
                <a class="add-page" href="{{ url('/add') }}">+ Add page</a>

                <table class="sites-table">
                    <thead>
                        <tr>
                            <th scope="col">Website</th>
                            <th scope="col">Template</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="col-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($websites as $website)
                            <tr>
                                <td class="col-website">{{ $website->name_website }}</td>
                                <td>{{ $website->template?->name_template }}</td>
                                <td>{{ $website->slug }}</td>
                                <td>
                                    <span class="badge {{ $website->is_published ? 'published' : '' }}">
                                        {{ $website->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </td>

                                    <td class="col-aksi">
                                        <div class="row-actions">
                                            <form action="{{ route('websites.publish', $website->id_website) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="switch {{ $website->is_published ? 'on' : '' }}"
                                                        role="switch"
                                                        aria-checked="{{ $website->is_published ? 'true' : 'false' }}"
                                                        title="{{ $website->is_published ? 'Klik untuk unpublish' : 'Klik untuk publish' }}">
                                                    <span class="switch-knob"></span>
                                                </button>
                                            </form>
                                                <a href="{{ url('/edit/'.$website->id_website) }}">Edit</a>
                                                <form action="{{ url('/delete/'.$website->id_website) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-delete"
                                                            onclick="return confirm('Yakin ingin menghapus website ini?')">
                                                        Hapus
                                                    </button>
                                                </form>
                                                <a href="{{ url('/site/'.$website->slug) }}" target="_blank" rel="noopener">Lihat</a>                                        
                                        </div>
                                    </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty">Belum ada website. Klik "+ Add page" untuk membuat yang pertama.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>