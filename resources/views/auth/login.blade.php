@extends('layouts.app')

@section('content')
<div class="fullscreen-container d-flex justify-content-center align-items-center">
    <div class="card">
        <div class="card-header text-center">
            <i class="fas fa-user"></i>
            <br>
            {{ __('Login') }}
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="username">{{ __('Username') }}</label>
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autocomplete="username" autofocus placeholder="Masukkan Username Anda">
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password" placeholder="Masukkan Password Anda">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                {{ __('Login') }}
            </button>
        </form>
        {{-- <div class="signup-link">
            {{ __("Bukan Atmin?") }} 
            <a href="{{ route('register') }}">{{ __('Register!') }}</a>
        </div> --}}
    </div>
</div>

<style>
    html, body {
        height: 100%;
        margin: 0;
        overflow: hidden;
    }

    .fullscreen-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .card {
        width: 380px;
        background-color: #fff;
        border-radius: 12px;
        padding: 40px 30px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
        box-sizing: border-box;
    }

    .card-header {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 30px;
        color: #343a40;
        background-color: #fff;
    }

    .card-header i {
        font-size: 40px;
        margin-bottom: 10px;
        color: #007bff;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 7px;
        font-weight: bold;
        color: #495057;
    }

    input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        box-sizing: border-box;
        font-size: 16px;
        color: #495057;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #0056b3;
    }

    .signup-link {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
        color: #6c757d;
    }

    .signup-link a {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }

    .signup-link a:hover {
        text-decoration: underline;
    }
</style>
@endsection
