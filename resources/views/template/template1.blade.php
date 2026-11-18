@php
    $whatsappDigits = preg_replace('/\D+/', '', (string) $website->whatsapp);

    if (str_starts_with($whatsappDigits, '0')) {
        $whatsappDigits = '62'.substr($whatsappDigits, 1);
    }

    $whatsappUrl = $whatsappDigits !== '' ? 'https://wa.me/'.$whatsappDigits : null;

    $instagram = trim((string) $website->instagram);
    $instagramUrl = $instagram !== ''
        ? (str_starts_with($instagram, 'http') ? $instagram : 'https://instagram.com/'.ltrim($instagram, '@'))
        : null;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $website->name_website }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--warna-utama:{{ $website->color_primary }};--warna-teks:{{ $website->color_text }}}
        *{box-sizing:border-box}
        html{scroll-behavior:smooth}
        body{margin:0;background:var(--warna-utama);color:var(--warna-teks);font:16px/1.6 "Montserrat",Arial,sans-serif}
        a{color:inherit;text-decoration:none}

        .nav{position:sticky;top:0;z-index:10;display:flex;align-items:center;justify-content:space-between;gap:24px;padding:20px 48px;background:var(--warna-utama);box-shadow:0 2px 12px rgba(0,0,0,.15)}        .nav-links{display:flex;gap:32px}
        .nav-links a{font-size:13px;font-weight:700;letter-spacing:.04em;text-transform:uppercase}
        .logo{display:block;height:96px;max-width:200px;object-fit:contain}

        .hero{padding:96px 24px 64px;text-align:center}
        .hero-title{display:flex;align-items:center;justify-content:center;gap:24px;margin-bottom:16px}
        .hero h1{margin:0;font-size:clamp(32px,6vw,56px);font-weight:800;line-height:1.1;text-transform:uppercase}
        .hero p{max-width:640px;margin:0 auto;font-size:18px}

        .wrap{max-width:1250px;margin:0 auto;padding:0 24px}
        .cards{display:flex;flex-direction:column;gap:24px;max-width:720px;margin:0 auto}
        .card{position:relative;margin:0;overflow:hidden;border-radius:6px;background:rgba(0,0,0,.1)}
        .card img,.card video{display:block;width:100%;height:auto}
        .card figcaption{position:absolute;inset:auto 0 0;padding:56px 16px 20px;background:linear-gradient(transparent,rgba(0,0,0,.75));color:#fff;font-size:18px;font-weight:700;text-align:center;text-transform:uppercase}

        .strip{margin-top:80px;padding:32px 0;background:rgba(0,0,0,.07)}
        .strip .wrap{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:16px}
        .strip h2{margin:0;font-size:22px;font-weight:800;text-transform:uppercase}
        .strip nav{display:flex;gap:28px}
        .strip a{font-size:14px;font-weight:700;text-transform:uppercase}

        .contact{padding:56px 24px 24px;text-align:center}
        .socials{display:flex;justify-content:center;gap:32px}
        .socials a{display:grid;place-items:center;width:56px;height:56px;border-radius:8px;background:var(--warna-teks)}
        .socials svg,.wa svg{width:30px;height:30px;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
        .socials svg{stroke:var(--warna-utama)}
        .wa svg{stroke:#fff}
        .links{display:flex;flex-wrap:wrap;justify-content:center;margin-top:40px}
        .links a{padding:0 20px;border-left:1px solid var(--warna-teks);font-size:14px;font-weight:700;text-transform:uppercase}
        .links a:first-child{border-left:0}

        .bottom{margin-top:40px;padding:24px;background:var(--warna-teks);color:var(--warna-utama);font-size:13px;text-align:center}
        .wa{position:fixed;right:24px;bottom:24px;display:grid;place-items:center;width:56px;height:56px;border-radius:4px;background:#7ac143;box-shadow:0 4px 12px rgba(0,0,0,.25)}

    @media(max-width:800px){
        .nav{flex-direction:column;padding:12px 16px}
        .nav-links{justify-content:center;gap:20px}
        .hero{padding:56px 16px 40px}
        .hero-title{flex-direction:column}
        .logo{height:72px}
    }
    </style>
</head>
<body>
    <header class="nav">
        <nav class="nav-links">
            <a href="#top">Beranda</a>
            <a href="#gallery">Gallery</a>
        </nav>

        <nav class="nav-links">
            <a href="#contact">Kontak</a>
            @if ($whatsappUrl)
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener">WhatsApp</a>
            @endif
        </nav>
    </header>

    <section class="hero" id="top">
        <div class="hero-title">
            @if ($website->logo_path)
                <img class="logo" src="{{ asset('storage/'.$website->logo_path) }}" alt="Logo {{ $website->name_website }}">
            @endif
            <h1>{{ $website->name_website }}</h1>
        </div>

        @if ($website->bio)
            <p>{{ $website->bio }}</p>
        @endif
    </section>

    <section class="wrap" id="gallery">
        <div class="cards">
            @foreach ($website->gallery_photos ?? [] as $index => $path)
                @php
                    $price = $website->gallery_prices[$index] ?? null;
                @endphp

                <figure class="card">
                    @if (in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), ['mp4', 'webm'], true))
                        <video src="{{ asset('storage/'.$path) }}" autoplay muted loop playsinline></video>
                    @else
                        <img src="{{ asset('storage/'.$path) }}" alt="Galeri {{ $website->name_website }}">
                    @endif

                    @if ($price)
                        <figcaption>{{ $price }}</figcaption>
                    @endif
                </figure>
            @endforeach
        </div>
    </section>

    <section class="strip">
        <div class="wrap">
            <h2>{{ $website->name_website }}</h2>
            <nav>
                <a href="#gallery">Gallery</a>
                <a href="#contact">Kontak</a>
            </nav>
        </div>
    </section>

    <section class="contact" id="contact">
        <div class="socials">
            @if ($instagramUrl)
                <a href="{{ $instagramUrl }}" target="_blank" rel="noopener" aria-label="Instagram">
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".6"/></svg>
                </a>
            @endif

            @if ($whatsappUrl)
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" aria-label="WhatsApp">
                    <svg viewBox="0 0 24 24"><path d="M3 21l1.6-4.6A8.5 8.5 0 1 1 8 19.4L3 21z"/><path d="M9 8.5c0 3 2.5 5.5 5.5 5.5l1-1.5-2-1-.8.8c-.8-.4-1.6-1.2-2-2l.8-.8-1-2L9 8.5z"/></svg>
                </a>
            @endif
        </div>

        <div class="links">
            <a href="#top">Beranda</a>
            <a href="#gallery">Gallery</a>
            <a href="#contact">Kontak</a>
        </div>
    </section>

    <div class="bottom">&copy; {{ date('Y') }} {{ $website->name_website }}</div>

    @if ($whatsappUrl)
        <a class="wa" href="{{ $whatsappUrl }}" target="_blank" rel="noopener" aria-label="Chat WhatsApp">
            <svg viewBox="0 0 24 24"><path d="M3 21l1.6-4.6A8.5 8.5 0 1 1 8 19.4L3 21z"/><path d="M9 8.5c0 3 2.5 5.5 5.5 5.5l1-1.5-2-1-.8.8c-.8-.4-1.6-1.2-2-2l.8-.8-1-2L9 8.5z"/></svg>
        </a>
    @endif
</body>
</html>