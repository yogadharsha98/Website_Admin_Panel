@extends('layouts.app')

@section('content')
    <div class="container-scroller">
        <div class="content-wrapper d-flex align-items-center auth px-0"
            style="background-image: url('{{ asset('assets/images/goatbg.jpg') }}'); background-size: cover; background-position: center; height: 100vh;">

            <div class="row w-100 mx-0 justify-content-center">
                <div class="col-lg-3">
                    <div class="card"> <!-- Bootstrap card -->
                        <div class="card-body"> <!-- Card body for padding -->
                            <div class="brand-logo">
                                {{-- <img src="{{ asset('assets/images/logo_main.jpg') }}" alt="logo"> --}}
                            </div>
                            <h3 class="font-weight-light text-center">Admin Login</h3>

                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <form class="pt-3" method="POST" action="{{ route('login') }}">
                                @csrf

                                <!-- Email Address -->
                                <div class="form-group">
                                    <input type="email"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email"
                                        id="email" placeholder="Email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <input type="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        name="password" id="password" placeholder="Password" required
                                        autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="mt-3 d-flex justify-content-center"> <!-- Added flex utility classes -->
                                    <button type="submit" class="btn btn-primary btn-sm font-weight-medium auth-form-btn">
                                        {{ __('Login') }}
                                    </button>
                                </div>

                            </form>
                        </div> <!-- End of card body -->
                    </div> <!-- End of card -->
                </div>
            </div>
        </div>
    </div>
@endsection
