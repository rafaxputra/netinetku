<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">NetInetKu</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}"><i class="bi bi-house-door-fill"></i> Beranda</a>
                </li>
                @auth
                    @if(auth()->user()->role == 'owner')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pengguna.index') }}"><i class="bi bi-people-fill"></i> Pengguna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pelanggan.index') }}"><i class="bi bi-people-fill"></i> Pelanggan</a>
                        </li>
                    @endif
                    @if(auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tagihan.index') }}"><i class="bi bi-clipboard-fill"></i> Tagihan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pelanggan.index') }}"><i class="bi bi-people-fill"></i> Pelanggan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('paket.index') }}"><i class="bi bi-box-seam"></i> Paket</a>
                        </li>
                    @endif

                    @if(auth()->user()->role == 'pelanggan')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tagihan2.index') }}"><i class="bi bi-clipboard-fill"></i> Tagihan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profil.index',Auth::user()->id) }}"><i class="bi bi-people-fill"></i> Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('paket2.index') }}"><i class="bi bi-box-seam"></i> Ganti Paket</a>
                    </li>
                    @endif
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Mlebu</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}"><i class="bi bi-person-plus-fill"></i> Registrasi</a>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>
</nav>
