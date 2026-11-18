<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Website</title>
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
            <h1>Tambah Website</h1>

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

                <form action="{{ url('/add') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="field">
                        <label class="field-label" for="name_website">Nama website</label>
                        <input class="field-control" id="name_website" name="name_website" type="text"
                               value="{{ old('name_website') }}" placeholder="Contoh: Website Pernikahan Ana & Budi">
                    </div>

                    <div class="field">
                        <label class="field-label" for="bio">Bio</label>
                        <textarea class="field-control" id="bio" name="bio"
                                  placeholder="Tuliskan deskripsi singkat website">{{ old('bio') }}</textarea>
                    </div>

                    <div class="field">
                        <label class="field-label" for="slug">Slug</label>
                        <input class="field-control" id="slug" name="slug" type="text"
                               value="{{ old('slug') }}" placeholder="contoh: ana-dan-budi">
                    </div>

                    <div class="field">
                        <label class="field-label" for="template">Pilih template</label>
                        <select class="field-control" id="template" name="id_template">
                            <option value="" disabled @selected(! old('id_template'))>Pilih template website</option>
                            @foreach ($templates as $template)
                                <option value="{{ $template->id_template }}"
                                    @selected(old('id_template') == $template->id_template)>
                                    {{ $template->name_template }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <label class="field-label" for="logo">Logo</label>
                        <input class="field-control" id="logo" name="logo" type="file" accept="image/*">
                    </div>

                                        @for ($i = 0; $i < 5; $i++)
                        <div class="field">
                            <label class="field-label" for="gallery_photo_{{ $i + 1 }}">
                                {{ $i === 4 ? 'Galeri 5 (foto atau video)' : 'Galeri ' . ($i + 1) . ' (foto)' }}
                            </label>
                            <input class="field-control" id="gallery_photo_{{ $i + 1 }}"
                                   name="gallery_photos[{{ $i }}]" type="file"
                                   accept="{{ $i === 4 ? 'image/*,video/mp4,video/webm' : 'image/*' }}">

                            <input class="field-control" name="gallery_prices[{{ $i }}]" type="text"
                                   value="{{ old('gallery_prices.'.$i) }}"
                                   placeholder="Teks harga, contoh: Rp 500.000">
                        </div>
                    @endfor

                    <div class="field">
                        <label for="whatsapp">WhatsApp</label>
                        <input type="text" id="whatsapp" name="whatsapp" placeholder="08123456789" value="{{ old('whatsapp') }}">
                    </div>

                    <div class="field">
                        <label for="instagram">Instagram</label>
                        <input type="text" id="instagram" name="instagram" placeholder="@namaakun" value="{{ old('instagram') }}">
                    </div>
                    
                    <div class="field">
                        <label class="field-label" for="color_primary">Warna background</label>
                        <input id="color_primary" name="color_primary" type="color"
                            value="{{ old('color_primary', '#f6e9df') }}">
                    </div>

                    <div class="field">
                        <label class="field-label" for="color_text">Warna teks</label>
                        <input id="color_text" name="color_text" type="color"
                            value="{{ old('color_text', '#3b2f2f') }}">
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