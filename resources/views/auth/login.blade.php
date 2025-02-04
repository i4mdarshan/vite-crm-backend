<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        Login - Anjali Chemicals System
    </title>
    <!-- Favicon -->
    <link href={{ asset('assets/img/brand/1x/favicon.png') }} rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href={{ asset('assets/js/plugins/nucleo/css/nucleo.css') }} rel="stylesheet" />
    <link href={{ asset('assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') }} rel="stylesheet" />
    <!-- CSS Files -->
    <link href={{ asset('assets/css/argon-dashboard.css?v=1.1.2') }} rel="stylesheet" />
</head>

<body class="bg-default">
    <div class="main-content">
        <!-- Header -->
        <div class="header bg-gradient-primary py-5 py-lg-5">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            {{-- <h1 class="text-white">Welcome To Anjali Chemicals!</h1> --}}
                            {{-- <p class="text-lead text-light">Use these awesome forms to login or create new account in
                                your project for free.</p> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                    xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <!-- Page content -->
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card shadow border-0" style="background-color: #f5fbff">
                        <div class="card-header bg-transparent pb-2 text-center">
                            <img src="{{ asset('assets/img/brand/blue.png') }}" class="img-fluid" width="30%"
                                alt="Anjali Chemicals">
                                <h3 class="text-lead text-dark pt-3" style="font-weight: 400 !important;">Sign in with your Credentials</h3>
                        </div>
                        <div class="card-body px-lg-5 py-lg-5 px-3">
                            <form role="form" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control @error('email') is-invalid @enderror" id="email"
                                            name="email" type="email" value="{{ old('email') }}"
                                            placeholder="Enter Email" autocomplete="email" required autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Enter Password" type="password" name="password"
                                            autocomplete="current-password" required>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" id="remember" type="checkbox" name="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="remember">
                                        <span class="text-muted">{{ __('Remember Me') }}</span>
                                    </label>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary my-4">Sign in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <a href="#" class="text-light"><small>Forgot password?</small></a>
                        </div>
                        {{-- <div class="col-6 text-right">
                            <a href="#" class="text-light"><small>Create new account</small></a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <footer class="py-2">
            <div class="container">
                <div class="row align-items-center justify-content-xl-between">
                    <div class="col-xl-6">
                        <div class="copyright text-center text-xl-left text-muted">
                            &copy; {{ date('Y') }} <a href="https://anjalichemicals.com"
                                class="font-weight-bold ml-1" target="_blank">Anjali Chemicals</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!--   Core   -->
    <script src={{ asset('assets/js/plugins/jquery/dist/jquery.min.js') }}></script>
    <script src={{ asset('assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') }}></script>
    <!--   Optional JS   -->
    <!-- JS   -->
    <script src={{ asset('assets/js/argon-dashboard.min.js?v=1.1.2') }}></script>
</body>

</html>
