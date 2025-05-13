<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kafe Taru Martani</title>

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="{{ asset('images/overview/logotarumartani.webp') }}" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">

</head>

<body id="top">

  <!-- 
    - #HEADER
  -->

  <header class="header">

    <div class="alert">
      <div class="container">
        <p class="alert-text">Berdiri Sejak 1918</p>
      </div>
    </div>

    <div class="header-top" data-header>
      <div class="container">

        <button class="nav-open-btn" aria-label="open menu" data-nav-toggler>
          <span class="line line-1"></span>
          <span class="line line-2"></span>
          <span class="line line-3"></span>
        </button>

        <a href="#makanan" class="logo">
          <img src="{{ asset('images/overview/logotarumartani.webp') }}" width="50" height="26" alt="Glowing">
        </a>

        <nav class="navbar">
          <ul class="navbar-list">

            <li>
              <a href="#home" class="navbar-link has-after">Tentang Kami</a>
            </li>

            <li>
              <a href="#collection" class="navbar-link has-after">Best Seller</a>
            </li>

            <li>
              <a href="#shop" class="navbar-link has-after">Menu Kami</a>
            </li>

            <li>
              <a href="#galeri" class="navbar-link has-after">Galeri</a>
            </li>

            <li>
              <a href="#keunggulan" class="navbar-link has-after">Keunggulan</a>
            </li>

            <li>
              <a href="#kontak" class="navbar-link has-after">Hubungi Kami</a>
            </li>

          </ul>
        </nav>

      </div>
    </div>

  </header>





  <!-- 
    - #MOBILE NAVBAR
  -->

  <div class="sidebar">
    <div class="mobile-navbar" data-navbar>

      <div class="wrapper">
        <a href="#makanan" class="logo">
          <img src="{{ asset('images/overview/logotarumartani.webp') }}" width="179" height="26" alt="Glowing">
        </a>

        <button class="nav-close-btn" aria-label="close menu" data-nav-toggler>
          <ion-icon name="close-outline" aria-hidden="true"></ion-icon>
        </button>
      </div>

      <ul class="navbar-list">

        <li>
          <a href="#home" class="navbar-link" data-nav-link>Home</a>
        </li>

        <li>
          <a href="#collection" class="navbar-link" data-nav-link>Best Seller</a>
        </li>

        <li>
          <a href="#shop" class="navbar-link" data-nav-link>Menu Kami</a>
        </li>

        <li>
          <a href="#keunggulan" class="navbar-link" data-nav-link>Keunggulan</a>
        </li>

        <li>
          <a href="#kontak" class="navbar-link" data-nav-link>Hubungi Kami</a>
        </li>

      </ul>

    </div>

    <div class="overlay" data-nav-toggler data-overlay></div>
  </div>





  <main>
    <article>

      <!-- 
        - #HERO
      -->

      <section class="section hero" id="home" aria-label="hero" data-section>
        <div class="container">

          <ul class="has-scrollbar">

            <li class="scrollbar-item">
              <div class="hero-card has-bg-image" style="background-image: url('{{ asset('images/overview/gambarutama.webp') }}')">

                <div class="card-content">

                  <h1 class="h1 hero-title">
                    Kafe <br>
                    Taru Martani
                  </h1>

                  <p class="hero-text">
                    
                  </p>

                  <p class="price">Sudah berdiri sejak 1918</p>

                  <button id="reservasiBtn" class="btn btn-primary">Reservasi Sekarang</button>

                </div>

              </div>
            </li>


            <li class="scrollbar-item">
              <div class="hero-card has-bg-image" style="background-image: url('{{ asset('images/overview/gambarkafe5.webp') }}')">

                <div class="card-content">

                  <h1 class="h1 hero-title">
                    Alamat Kami
                  </h1>

                  <p class="hero-text">
                    Jl. Kompol Bambang Suprapto No.2A, Baciro, Kec. Gondokusuman, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55225
                  </p>

                  <p class="price">Dekat dengan stasiun Lempuyangan</p>

                  <a href="https://www.google.com/maps/place/Taru+Martani+Coffee+%26+Resto+1918/data=!4m2!3m1!1s0x0:0x43df4a553ffc51c7?sa=X&ved=1t:2428&ictx=111" class="btn btn-primary" target="_blank">Cek Maps</a>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="hero-card has-bg-image" style="background-image: url('{{ asset('images/overview/gambarkafe3.webp') }}')">

                <div class="card-content">

                  <h1 class="h1 hero-title">
                    Menu Kami
                  </h1>

                  <p class="hero-text">
                    Tersedia berbagai macam makanan dan minuman yang menggugah selera
                  </p>

                  <p class="price">Mulai dari Rp.5.000</p>

                  <a href="{{ route('gallery') }}" class="btn btn-primary">Lihat Menu</a>

                </div>

              </div>
            </li>

            

            

          </ul>

        </div>
      </section>





      <!-- 
        - #COLLECTION
      -->

      <section class="section collection" id="collection" aria-label="collection" data-section>
        <div class="container">

          <ul class="collection-list">

            <li>
              <div class="collection-card has-before hover:shine">

                <h2 class="h2 card-title">Mix Platter</h2>

                <p class="card-text">Hanya Rp.20.000</p>

                <a href="https://www.instagram.com/p/C70k4bYyjCs/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==" class="btn-link" target="_blank">
                  <span class="span">See More</span>

                </a>

                <div class="has-bg-image" style="background-image: url('{{ asset('images/overview/bes seler.webp') }}')"></div>

              </div>
            </li>

            <li>
              <div class="collection-card has-before hover:shine">

                <h2 class="h2 card-title">Nasi Goreng Kemangi</h2>

                <p class="card-text">Hanya Rp.23.000</p>

                <a href="https://www.instagram.com/p/C9uaN-BSJcV/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==" class="btn-link" target="_blank">
                  <span class="span">See More</span>

                </a>

                <div class="has-bg-image" style="background-image: url('{{ asset('images/overview/bes seler2.webp') }}')"></div>

              </div>
            </li>

            <li>
              <div class="collection-card has-before hover:shine">

                <h2 class="h2 card-title">Chicken Burger</h2>

                <p class="card-text">Hanya Rp.25.000</p>

                <a href="https://www.instagram.com/p/C-E97SdSCy3/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==" class="btn-link" target="_blank">
                  <span class="span">See More</span>

                </a>

                <div class="has-bg-image" style="background-image: url('{{ asset('images/overview/bes seler3.webp') }}')"></div>

              </div>
            </li>

          </ul>

        </div>
      </section>





      <!-- 
        - #SHOP
      -->

      <section class="section shop" id="shop" aria-label="shop" data-section>
        <div class="container">

          <div class="title-wrapper">
            <h2 class="h2 section-title" id="#makanan">Menu Makanan Kami</h2>

            <a href="galeri.html" class="btn-link">
              <span class="span">Lihat Menu Kami</span>

              <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
            </a>
          </div>

          <ul class="has-scrollbar">

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="{{ asset('images/overview/makanan1.webp') }}" width="540" height="720" loading="lazy"
                    alt="Facial cleanser" class="img-cover">

                  <span class="badge" aria-label="20% off">Makanan</span>
                </div>

                <div class="card-content">

                  <div class="price">
                    <del class="del">Rp.18.999</del>

                    <span class="span">Rp.18.000</span>
                  </div>

                  <h3>
                    <a href="#makanan" class="card-title">Roti Bakar</a>
                  </h3>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="{{ asset('images/overview/bes seler.webp') }}" width="540" height="720" loading="lazy"
                    alt="Bio-shroom Rejuvenating Serum" class="img-cover">

                  <div class="card-actions">

                 

                  </div>
                </div>

                <div class="card-content">

                  <div class="price">
                    <span class="span">Rp.20.000</span>
                  </div>

                  <h3>
                    <a href="#makanan" class="card-title">Mix Platter</a>
                  </h3>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="{{ asset('images/overview/makanan3.webp') }}" width="540" height="720" loading="lazy"
                    alt="Coffee Bean Caffeine Eye Cream" class="img-cover">

                  <div class="card-actions">

                 

                  </div>
                </div>

                <div class="card-content">

                  <div class="price">
                    <span class="span">Rp.25.000</span>
                  </div>

                  <h3>
                    <a href="#makanan" class="card-title">Ricebowl Chicken Teriyakki</a>
                  </h3>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="{{ asset('images/overview/makanan4.webp') }}" width="540" height="720" loading="lazy"
                    alt="Facial cleanser" class="img-cover">

                  <div class="card-actions">

                 

                  </div>
                </div>

                <div class="card-content">

                  <div class="price">
                    <span class="span">Rp.25.000</span>
                  </div>

                  <h3>
                    <a href="#makanan" class="card-title">Ayam Goreng Taru Martani</a>
                  </h3>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="{{ asset('images/overview/makanan6.webp') }}" width="540" height="720" loading="lazy"
                    alt="Coffee Bean Caffeine Eye Cream" class="img-cover">

                  <span class="badge" aria-label="20% off">Cemilan</span>

                  <div class="card-actions">

                 

                  </div>
                </div>

                <div class="card-content">

                  <div class="price">
                    <del class="del">Rp.20.111</del>

                    <span class="span">Rp.20.000</span>
                  </div>

                  <h3>
                    <a href="#makanan" class="card-title">Banana Split</a>
                  </h3>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="{{ asset('images/overview/makanan5.webp') }}" width="540" height="720" loading="lazy"
                    alt="Facial cleanser" class="img-cover">

                  <div class="card-actions">

                 

                  </div>
                </div>

                <div class="card-content">

                  <div class="price">
                    <span class="span">Rp.23.000</span>
                  </div>

                  <h3>
                    <a href="#makanan" class="card-title">Spagetti Bolognise</a>
                  </h3>

                </div>

              </div>
            </li>

          </ul>

        </div>
      </section>

      <section class="section shop" id="shop" aria-label="shop" data-section>
        <div class="container">

          <div class="title-wrapper">
            <h2 class="h2 section-title" id="#minuman">Menu Minuman Kami</h2>

            <a href="galeri.html" class="btn-link">
              <span class="span">Lihat menu kami</span>

              <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
            </a>
          </div>

          <ul class="has-scrollbar">

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="{{ asset('images/overview/minuman1.webp') }}" width="540" height="720" loading="lazy"
                    alt="Facial cleanser" class="img-cover">

                  <span class="badge" aria-label="minuman">Minuman</span>

                  <div class="card-actions">

                 

                  </div>
                </div>

                <div class="card-content">

                  <div class="price">
                    <del class="del">Rp.13.313</del>

                    <span class="span">Rp.13.000</span>
                  </div>

                  <h3>
                    <a href="#minuman" class="card-title">Gula Asem</a>
                  </h3>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="{{ asset('images/overview/minuman2.webp') }}" width="540" height="720" loading="lazy"
                    alt="Bio-shroom Rejuvenating Serum" class="img-cover">

                  <div class="card-actions">

                 

                  </div>
                </div>

                <div class="card-content">

                  <div class="price">
                    <span class="span">Rp.13.000</span>
                  </div>

                  <h3>
                    <a href="#minuman" class="card-title">Kunir Asem</a>
                  </h3>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="{{ asset('images/overview/minuman3.webp') }}" width="540" height="720" loading="lazy"
                    alt="Coffee Bean Caffeine Eye Cream" class="img-cover">

                  <div class="card-actions">

                 

                  </div>
                </div>

                <div class="card-content">

                  <div class="price">
                    <span class="span">Rp.18.000</span>
                  </div>

                  <h3>
                    <a href="#minuman" class="card-title">Teh Tarik</a>
                  </h3>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="{{ asset('images/overviewGallery/wedangjahe.webp') }}" width="540" height="720" loading="lazy"
                    alt="Facial cleanser" class="img-cover">

                  <div class="card-actions">

                 

                  </div>
                </div>

                <div class="card-content">

                  <div class="price">
                    <span class="span">Rp.13.000</span>
                  </div>

                  <h3>
                    <a href="#minuman" class="card-title">Teh Jahe</a>
                  </h3>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="{{ asset('images/overview/minuman5.webp') }}" width="540" height="720" loading="lazy"
                    alt="Coffee Bean Caffeine Eye Cream" class="img-cover">

                  <span class="badge" aria-label="minuman">Nyoklat</span>

                  <div class="card-actions">

                 

                  </div>
                </div>

                <div class="card-content">

                  <div class="price">
                    <del class="del">Rp.18.001</del>

                    <span class="span">Rp.18.000</span>
                  </div>

                  <h3>
                    <a href="#minuman" class="card-title">Chocolate</a>
                  </h3>

                </div>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="shop-card">

                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                  <img src="{{ asset('images/overviewGallery/espresso.webp') }}" width="540" height="720" loading="lazy"
                    alt="Facial cleanser" class="img-cover">

                  <div class="card-actions">

                 

                  </div>
                </div>

                <div class="card-content">

                  <div class="price">
                    <span class="span">Rp.8.000</span>
                  </div>

                  <h3>
                    <a href="#minuman" class="card-title">Espresso</a>
                  </h3>

                </div>

              </div>
            </li>

          </ul>

        </div>
      </section>





      <!-- 
        - #BANNER
      -->

      <section class="section banner" aria-label="banner" data-section id="galeri">
        <div class="container">

          <ul class="banner-list">

            <li>
              <div class="banner-card banner-card-1 has-before hover:shine">

                <p class="card-subtitle">Menu</p>

                <h2 class="h2 card-title">Lihat menu lengkap kami</h2>

                <a href="{{ route('gallery') }}" class="btn btn-secondary">Lihat !</a>

                <div class="has-bg-image" style="background-image: url('{{ asset('images/overview/makanan1.webp') }}')"></div>

              </div>
            </li>

            <li>
              <div class="banner-card banner-card-2 has-before hover:shine">

                <h2 class="h2 card-title">Berbagai menu yang ada</h2>

                <p class="card-text">
                  Lihat Menu Lainnya
                </p>

                <a href="{{ route('gallery') }}" class="btn btn-secondary">Lihat !</a>

                <div class="has-bg-image" style="background-image: url('{{ asset('images/overview/minuman3.webp') }}')"></div>

              </div>
            </li>

          </ul>

        </div>
      </section>





      <!-- 
        - #FEATURE
      -->

      <section class="section feature" aria-label="feature" data-section  id="keunggulan">
        <div class="container">

          <h2 class="h2-large section-title">Keunggulan Kafe Kami</h2>

          <ul class="flex-list">

            <li class="flex-item">
              <div class="feature-card">

                <img src="{{ asset('images/overview/feature-1.webp') }}" width="204" height="236" loading="lazy" alt="Guaranteed PURE"
                  class="card-icon">

                <h3 class="h3 card-title">Bahannya Berkualitas</h3>

                <p class="card-text">
                  Tidak menggunakan bahan yang biasa saja dan sudah melewati banyak pemeriksaan sebelum diolah
                </p>

              </div>
            </li>

            <li class="flex-item">
              <div class="feature-card">

                <img src="{{ asset('images/overview/feature-2.webp') }}" width="204" height="236" loading="lazy"
                  alt="Baik Untuk Dikonsumsi" class="card-icon">

                <h3 class="h3 card-title">Baik Untuk Dikonsumsi</h3>

                <p class="card-text">
                  Menggunakan bahan yang berkualitas tentu membuat makanan menjadi lebih sehat dan lebih baik untuk dikonsumsi setiap hari
                </p>

              </div>
            </li>

            <li class="flex-item">
              <div class="feature-card">

                <img src="{{ asset('images/overview/feature-3.webp') }}" width="204" height="236" loading="lazy"
                  alt="Bahan Terjamin" class="card-icon">

                <h3 class="h3 card-title">Bahan Terjamin</h3>

                <p class="card-text">
                  Selain berkualitas tentu bahan yang kami gunakan juga diperiksa untuk keterjaminannya dari bahan yang berbahaya
                </p>

              </div>
            </li>

          </ul>

        </div>
      </section>

    
    </article>
  </main>





  <!-- 
    - #FOOTER
  -->

  <footer class="footer" id="kontak">
    <div class="container">
  
      <div class="footer-top">
        <div class="footer-info">
          <h3 class="footer-title">Kafe Taru Martani</h3>
          <p>Temukan kami di <a href="https://www.google.com/maps/place/Taru+Martani+Coffee+%26+Resto+1918" target="_blank" class="footer-link">Google Maps</a></p>
          <p class="footer-phone">+62 813-3648-3124</p>
        </div>
  
        <div class="footer-map">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.717693464546!2d110.3801580741756!3d-7.820462277411401!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x43df4a553ffc51c7!2sTaru%20Martani%20Coffee%20%26%20Resto%201918!5e0!3m2!1sen!2sid!4v1681998135266!5m2!1sen!2sid"
            width="100%" height="200" style="border:0; border-radius: 10px;" allowfullscreen="" loading="lazy">
          </iframe>
        </div>
      </div>
  
      <div class="footer-middle">
        <ul class="footer-links">
          <li><strong>Useful Links</strong></li>
          <li><a href="https://www.instagram.com/tarumartani1918coffee/" target="_blank">@tarumartani1918coffee</a></li>
          <li><a href="https://www.instagram.com/tarumartani1918coffee/" target="_blank">Instagram Kami</a></li>
          <li><a href="https://www.youtube.com/results?search_query=kafe+taru+martani+yogyakarta" target="_blank">Video Kami</a></li>
        </ul>
  
        <div class="footer-form">
          <h4>Hubungi Kami</h4>
          <p>Tulis nama dan saran/kritik kalian. Kami akan terhubung via WhatsApp. Terima Kasih!</p>
          <form id="whatsappForm">
            <input type="text" name="name" placeholder="Masukkan Nama" required>
            <input type="text" name="contact" placeholder="Nomor WhatsApp / Email" required>
            <textarea name="comment" placeholder="Komentar" required></textarea>
            <button type="submit" class="btn">Kirim ke WhatsApp</button>
          </form>
        </div>
      </div>
  
      <div class="footer-bottom">
        <p class="copyright">
          Thanks to <a href="https://www.youtube.com/@codewithsadee">@codewithsadee</a> |
          <a href="https://linktr.ee/Masbrodev">Made With Love ❤ by MasbroDev</a>
        </p>
      
      </div>
  
    </div>
  </footer>
  




  <!-- 
    - #BACK TO TOP
  -->

  <a href="#top" class="back-top-btn" aria-label="back to top" data-back-top-btn>
    <ion-icon name="arrow-up" aria-hidden="true"></ion-icon>
  </a>





  <!-- 
    - custom js link
  -->
  <script src="{{ asset('js/overview.js') }}" defer></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

  <script>
  document.getElementById('reservasiBtn').addEventListener('click', function() {
      fetch("{{ route('userReservation') }}", {
          method: "GET",
          headers: {
              'X-Requested-With': 'XMLHttpRequest'
          }
      })
      .then(response => {
          // Jika diarahkan ke login, response.redirected akan true
          if (response.redirected) {
              window.location.href = response.url;
          } else {
              window.location.href = "{{ route('userReservation') }}";
          }
      });
  });
  </script>

</body>

</html>