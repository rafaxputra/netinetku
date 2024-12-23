<!DOCTYPE html>
<html lang="jv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NetInetKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&family=Roboto:wght@100;300;500&family=Quicksand:wght@300;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">NetInetKu</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home"><i class="bi bi-house-door-fill"></i> Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://wa.me/6285175175105"><i class="bi bi-whatsapp"></i> WhatsApp</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-section" id="home">
        <div class="container">
            <div id="night-sky" style="--number-of-stars: 30"></div>
            <h1 id="hero-text"><i class="bi bi-wifi"></i> Selamat Datang di NetInetKu 🌐</h1><br>
            <p>Luv. 🌐💻✨</p>
            <a href="{{ route('login') }}" class="btn btn-light btn-lg">Login <i class="bi bi-box-arrow-in-right"></i></a>
        </div>
    </div>

    <div class="feature-section" id="features" data-aos="fade-up">
        <h2 class="section-heading"><i class="bi bi-shield-lock-fill"></i> Fitur Keamanan 🔐</h2>
        <div class="container">
            <div class="row">
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card glass-effect">
                        <i class="bi bi-shield-lock-fill"></i>
                        <h5>Keamanan Terjamin</h5>
                        <p>Proteksi lengkap supaya pengalaman internet Anda aman. 🔒</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="card glass-effect">
                        <i class="bi bi-person-check-fill"></i>
                        <h5>Dukungan Pelanggan 24/7</h5>
                        <p>Tim dukungan siap membantu kapan saja jika ada masalah! 💬</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="card glass-effect">
                        <i class="bi bi-arrow-repeat"></i>
                        <h5>Uptime Terbaik</h5>
                        <p>Menjamin koneksi terus berjalan tanpa gangguan! ⚡</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="card glass-effect">
                        <i class="bi bi-gear-fill"></i>
                        <h5>Pengaturan Mudah</h5>
                        <p>Instalasi mudah, koneksi seketika! 🔧</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pricing-section" id="pricing" data-aos="fade-up">
        <h2 class="section-heading"><i class="bi bi-wallet2"></i> Paket Layanan WiFi 💸</h2>
        <div class="container">
            <div class="row">
                @php
                    $pakets = \App\Models\Paket::all();
                @endphp
                @foreach($pakets as $paket)
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="pricing-card glass-effect">
                            <div class="card-body">
                                <h5 class="card-title">{{ strtoupper($paket->nama_paket) }}</h5>
                                <p class="card-text">Kecepatan: {{ $paket->kecepatan }} Mbps</p>
                                <p class="card-text">Harga: Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="map-section" id="map" data-aos="fade-up">
        <h2 class="section-heading"><i class="bi bi-geo-alt-fill"></i> Temukan Kami 📍</h2>
        <div class="container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.509073827203!2d112.224757!3d-7.898289!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78f52673c10149%3A0x52c455bb9bcc521b!2sToko%20Rizky%20Abadi!5e0!3m2!1sen!2sid!4v1678901234567!5m2!1sen!2sid"
            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 NetInetKu. All rights reserved. 📅</p>
        <p>Follow us on <a href="#"><i class="bi bi-facebook"></i> Facebook</a>, and <a href="#"><i class="bi bi-instagram"></i> Instagram</a>.</p>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
        const heroText = document.getElementById("hero-text");
        const messages = [
            "Selamat Datang di NetInetKu 🌐",
            "Nikmati Koneksi Internet Cepat 💻",
            "Harga Terjangkau untuk Semua 💸",
            "Pelayanan Terbaik Setiap Hari 💬"
        ];
        let messageIndex = 0;

        function changeText() {
            heroText.style.transition = 'opacity 0.5s ease-in-out'; // Ensure the transition is set
            heroText.style.opacity = 0; // Start by fading out the text
            setTimeout(() => {
                heroText.innerHTML = `<i class="bi bi-wifi"></i> ${messages[messageIndex]}`;
                heroText.style.opacity = 1; // Fade the text back in
                messageIndex = (messageIndex + 1) % messages.length;
            }, 500); // Duration of the fade out
        }

        setInterval(changeText, 3000); // Change text every 3 seconds
    });
    </script>

    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
