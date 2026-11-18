<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Website</title>
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
            <h1>Edit Website</h1>

            <section class="panel">
                @if ($errors->any())
                    <div class="errors" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('/edit/'.$website->id_website) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="field">
                        <label class="field-label" for="name_website">Nama website</label>
                        <input class="field-control" id="name_website" name="name_website" type="text"
                               value="{{ old('name_website', $website->name_website) }}">
                    </div>

                    <div class="field">
                        <label class="field-label" for="bio">Bio</label>
                        <textarea class="field-control" id="bio" name="bio">{{ old('bio', $website->bio) }}</textarea>
                    </div>

                    <div class="field">
                        <label class="field-label" for="slug">Slug</label>
                        <input class="field-control" id="slug" name="slug" type="text"
                               value="{{ old('slug', $website->slug) }}">
                    </div>

                    <div class="field">
                        <label class="field-label" for="id_template">Pilih template</label>
                        <select class="field-control" id="id_template" name="id_template">
                            @foreach ($templates as $template)
                                <option value="{{ $template->id_template }}"
                                    @selected(old('id_template', $website->id_template) == $template->id_template)>
                                    {{ $template->name_template }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <label class="field-label" for="logo">Logo</label>
                        @if ($website->logo_path)
                            <img class="preview" src="{{ asset('storage/'.$website->logo_path) }}" alt="Logo saat ini">
                        @endif
                        <input class="field-control" id="logo" name="logo" type="file" accept="image/*">
                        <span class="field-hint">Kosongkan kalau tidak ingin mengganti.</span>
                    </div>

                    @for ($i = 0; $i < 5; $i++)
                        @php
                            $currentPath = $website->gallery_photos[$i] ?? null;
                            $extension = $currentPath ? strtolower(pathinfo($currentPath, PATHINFO_EXTENSION)) : null;
                        @endphp

                        <div class="field">
                            <label class="field-label" for="gallery_photo_{{ $i + 1 }}">
                                {{ $i === 4 ? 'Galeri 5 (foto atau video)' : 'Galeri ' . ($i + 1) . ' (foto)' }}
                            </label>

                            @if ($currentPath)
                                @if (in_array($extension, ['mp4', 'webm'], true))
                                    <video class="preview" src="{{ asset('storage/'.$currentPath) }}" muted controls></video>
                                @else
                                    <img class="preview" src="{{ asset('storage/'.$currentPath) }}" alt="Galeri {{ $i + 1 }} saat ini">
                                @endif
                            @endif

                            <input class="field-control" id="gallery_photo_{{ $i + 1 }}"
                                   name="gallery_photos[{{ $i }}]" type="file"
                                   accept="{{ $i === 4 ? 'image/*,video/mp4,video/webm' : 'image/*' }}">
                            <span class="field-hint">Kosongkan kalau tidak ingin mengganti.</span>

                            <input class="field-control" name="gallery_prices[{{ $i }}]" type="text"
                                   value="{{ old('gallery_prices.'.$i, $website->gallery_prices[$i] ?? '') }}"
                                   placeholder="Teks harga, contoh: Rp 500.000">
                        </div>
                    @endfor

                    <div class="field">
                        <label class="field-label" for="whatsapp">WhatsApp</label>
                        <input class="field-control" id="whatsapp" name="whatsapp" type="text"
                               value="{{ old('whatsapp', $website->whatsapp) }}">
                    </div>

                    <div class="field">
                        <label class="field-label" for="instagram">Instagram</label>
                        <input class="field-control" id="instagram" name="instagram" type="text"
                               value="{{ old('instagram', $website->instagram) }}">
                    </div>
                    
                    <div class="field">
                        <label class="field-label" for="color_primary">Warna background</label>
                        <input id="color_primary" name="color_primary" type="color"
                            value="{{ old('color_primary', $website->color_primary) }}">
                    </div>

                    <div class="field">
                        <label class="field-label" for="color_text">Warna teks</label>
                        <input id="color_text" name="color_text" type="color"
                            value="{{ old('color_text', $website->color_text) }}">
                    </div>

                    <div class="actions">
                        <a class="action-button" href="{{ route('admin.index') }}">Batal</a>
                        <button class="action-button action-button--save" type="submit">Simpan</button>
                    </div>
                </form>
            </section>
        </main>
    </div>
</body>
</html>