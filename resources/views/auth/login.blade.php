@extends('layouts.app')

@section('content')
<div class="auth-wrapper">
    <div class="auth-logo">
        <h1>NPONTU</h1>
    </div>
    
    <div class="auth-form">
        <h2>Log in to your account</h2>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group remember-me">
                <label class="checkbox-container">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span class="checkmark"></span>
                    Remember me
                </label>
            </div>

            <button type="submit" class="btn-login">
                Log In
            </button>

            @if (Route::has('password.request'))
                <a class="forgot-password" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif
        </form>

        <div class="auth-divider">
            <span>or</span>
        </div>

        <div class="auth-signup">
            <p>Don't have an account?</p>
            <a href="{{ route('register') }}" class="btn-signup">
                Sign up for NPONTU
            </a>
        </div>
    </div>
</div>

<style>
    .auth-wrapper {
        max-width: 450px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .auth-logo {
        text-align: center;
        margin-bottom: 40px;
    }

    .auth-logo h1 {
        color: #1db954;
        font-size: 32px;
        font-weight: bold;
    }

    .auth-form {
        background: #181818;
        padding: 32px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .auth-form h2 {
        color: #ffffff;
        font-size: 24px;
        margin-bottom: 32px;
        text-align: center;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        color: #b3b3b3;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 14px;
        background: #121212;
        border: 1px solid #282828;
        border-radius: 4px;
        color: #ffffff;
        font-size: 16px;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: #1db954;
        outline: none;
        background: #1a1a1a;
    }

    .is-invalid {
        border-color: #e74c3c;
    }

    .error-message {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }

    .remember-me {
        display: flex;
        align-items: center;
    }

    .checkbox-container {
        display: flex;
        align-items: center;
        color: #b3b3b3;
        cursor: pointer;
        font-size: 14px;
    }

    .checkbox-container input {
        margin-right: 8px;
    }

    .btn-login {
        width: 100%;
        padding: 14px;
        background: #1db954;
        color: #000000;
        border: none;
        border-radius: 20px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 16px;
    }

    .btn-login:hover {
        background: #1ed760;
        transform: scale(1.02);
    }

    .forgot-password {
        display: block;
        text-align: center;
        color: #b3b3b3;
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 24px;
    }

    .forgot-password:hover {
        color: #ffffff;
    }

    .auth-divider {
        position: relative;
        text-align: center;
        margin: 24px 0;
    }

    .auth-divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #282828;
    }

    .auth-divider span {
        position: relative;
        background: #181818;
        padding: 0 16px;
        color: #b3b3b3;
        font-size: 14px;
    }

    .auth-signup {
        text-align: center;
    }

    .auth-signup p {
        color: #b3b3b3;
        margin-bottom: 16px;
    }

    .btn-signup {
        display: inline-block;
        padding: 14px 32px;
        background: transparent;
        color: #ffffff;
        border: 1px solid #b3b3b3;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-signup:hover {
        border-color: #ffffff;
        transform: scale(1.02);
    }
</style>
@endsection
