<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Website</title>
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
            max-width: 720px;
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

        .field-control option {
            color: #000;
        }

        textarea.field-control {
            min-height: 90px;
            resize: vertical;
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
                        <label class="field-label" for="whatsapp">WhatsApp</label>
                        <input class="field-control" id="whatsapp" name="whatsapp" type="text"
                               value="{{ old('whatsapp') }}" placeholder="https://wa.me/6281234567890">
                    </div>

                    <div class="field">
                        <label class="field-label" for="instagram">Instagram</label>
                        <input class="field-control" id="instagram" name="instagram" type="text"
                               value="{{ old('instagram') }}" placeholder="https://instagram.com/akun_anda">
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