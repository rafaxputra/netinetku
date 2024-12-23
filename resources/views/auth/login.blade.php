<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&family=Roboto:wght@100;300;500&family=Quicksand:wght@300;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card glass-effect col-md-6 col-lg-4">
            <div class="card-header text-center">
                <i class="bi bi-box-arrow-in-right"></i> {{ __('Masuk') }}
            </div>
            <div class="card-body">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success mb-4" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email"><i class="bi bi-envelope-fill"></i> {{ __('Alamat Email') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" maxlength="255" required autofocus autocomplete="username">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group mt-4">
                        <label for="password"><i class="bi bi-lock-fill"></i> {{ __('Kata Sandi') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" maxlength="255" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember_me" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember_me">
                            {{ __('Ingat Saya') }}
                        </label>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a class="btn btn-back" href="/">
                            <i class="bi bi-arrow-left"></i> {{ __('Kembali') }}
                        </a>

                        <div>
<a class="btn btn-link" href="{{ route('password.request') }}">
    {{ __('Lupa Kata Sandi Anda?') }}
</a>

                            <button type="submit" class="btn btn-primary ms-3">
                                {{ __('Masuk') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
