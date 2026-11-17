@php
    $whatsappUrl = $website->whatsapp
        ? 'https://wa.me/'.preg_replace('/\D+/', '', $website->whatsapp)
        : null;

    $instagram = $website->instagram;
    $instagramUrl = $instagram
        ? (str_starts_with($instagram, 'http') ? $instagram : 'https://instagram.com/'.ltrim($instagram, '@'))
        : null;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $website->name_website }}</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #fffaf5;
            color: #3b2f2f;
            font-family: Georgia, serif;
        }

        section {
            padding: 64px 24px;
            text-align: center;
        }

        .hero {
            min-height: 70vh;
            display: grid;
            place-content: center;
            gap: 16px;
            background: #f6e9df;
        }

        .logo {
            width: 140px;
            height: 140px;
            margin: 0 auto;
            border-radius: 50%;
            object-fit: cover;
        }

        .hero h1 {
            margin: 0;
            font-size: clamp(32px, 6vw, 56px);
        }

        .hero p {
            max-width: 560px;
            margin: 0 auto;
            font-size: 18px;
            line-height: 1.6;
        }

        h2 {
            margin: 0 0 32px;
            font-size: 28px;
        }

        .gallery-grid {
            display: flex;
            flex-direction: column;
            gap: 24px;
            max-width: 640px;
            margin: 0 auto;
        }

        .gallery-grid img,
        .gallery-grid video {
            width: 100%;
            height: auto;
            border-radius: 12px;
        }
        .gallery-item {
            position: relative;
            margin: 0;
        }

        .gallery-item img,
        .gallery-item video {
            display: block;
        }

        .gallery-price {
            position: absolute;
            left: 50%;
            bottom: 16px;
            transform: translateX(-50%);
            max-width: 90%;
            padding: 8px 20px;
            border-radius: 999px;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            font-size: 18px;
            text-align: center;
        }

        .contact {
            background: #f6e9df;
        }

        .contact-links {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
        }

        .btn {
            padding: 12px 28px;
            border-radius: 999px;
            color: #fff;
            text-decoration: none;
        }

        .btn-whatsapp {
            background: #25a244;
        }

        .btn-instagram {
            background: #c13584;
        }
    </style>
</head>
<body>
    <section class="hero">
        @if ($website->logo_path)
            <img class="logo" src="{{ asset('storage/'.$website->logo_path) }}" alt="Logo {{ $website->name_website }}">
        @endif

        <h1>{{ $website->name_website }}</h1>

        @if ($website->bio)
            <p>{{ $website->bio }}</p>
        @endif
    </section>

    <section id="gallery">
        <h2>Gallery</h2>

        <div class="gallery-grid">
            @foreach ($website->gallery_photos ?? [] as $index => $path)
                @php
                    $price = $website->gallery_prices[$index] ?? null;
                @endphp

                <figure class="gallery-item">
                    @if (in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), ['mp4', 'webm'], true))
                        <video src="{{ asset('storage/'.$path) }}" autoplay muted loop playsinline></video>
                    @else
                        <img src="{{ asset('storage/'.$path) }}" alt="Galeri {{ $website->name_website }}">
                    @endif

                    @if ($price)
                        <figcaption class="gallery-price">{{ $price }}</figcaption>
                    @endif
                </figure>
            @endforeach
        </div>
    </section>

    <section class="contact" id="contact">
        <h2>Contact</h2>

        <div class="contact-links">
            @if ($whatsappUrl)
                <a class="btn btn-whatsapp" href="{{ $whatsappUrl }}" target="_blank" rel="noopener">WhatsApp</a>
            @endif

            @if ($instagramUrl)
                <a class="btn btn-instagram" href="{{ $instagramUrl }}" target="_blank" rel="noopener">Instagram</a>
            @endif
        </div>
    </section>
</body>
</html>