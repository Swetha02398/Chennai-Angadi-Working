 @extends('layouts.auth')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap');

    :root {
        --primary-glow: #3BB77E;
        --secondary-glow: #29A56C;
        --glass-bg: #ffffff;
        --glass-border: rgba(0, 0, 0, 0.08);
        --text-bright: #2b3445;
        --text-dim: #7d879c;
    }

    main {
        background-color: transparent !important;
    }

    body {
        background: #f3f4f6;
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Outfit', sans-serif;
        overflow: hidden;
    }

    /* Animated Liquid Mesh Background */
    .mesh-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        background-color: #f3f4f6;
        overflow: hidden;
    }

    .mesh-bg .orb {
        position: absolute;
        width: 600px;
        height: 600px;
        border-radius: 50%;
        filter: blur(120px);
        opacity: 0.4;
        animation: drift linear infinite;
    }

    .orb-1 {
        background: radial-gradient(circle, var(--primary-glow) 0%, transparent 70%);
        top: -10%;
        left: -10%;
        animation-duration: 20s;
    }

    .orb-2 {
        background: radial-gradient(circle, #1d4ed8 0%, transparent 70%);
        bottom: -10%;
        right: -10%;
        animation-duration: 25s;
        animation-direction: reverse;
    }

    .orb-3 {
        background: radial-gradient(circle, var(--secondary-glow) 0%, transparent 70%);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        animation-duration: 30s;
        opacity: 0.2;
    }

    @keyframes drift {
        0% { transform: translate(0, 0) rotate(0deg) scale(1); }
        33% { transform: translate(5vw, 10vh) rotate(120deg) scale(1.1); }
        66% { transform: translate(-5vw, 15vh) rotate(240deg) scale(0.9); }
        100% { transform: translate(0, 0) rotate(360deg) scale(1); }
    }

    .mesh-bg::after {
        content: "";
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        opacity: 0.08;
        pointer-events: none;
        z-index: 1;
    }

    /* Floating Particles */
    .particles {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        z-index: 0;
    }

    .particle {
        position: absolute;
        background: var(--primary-glow);
        border-radius: 50%;
        opacity: 0.15;
        animation: float linear infinite;
    }

    @keyframes float {
        0% { transform: translateY(100vh) scale(0); opacity: 0; }
        50% { opacity: 0.2; }
        100% { transform: translateY(-10vh) scale(1); opacity: 0; }
    }

    .auth-container {
        width: 100%;
        max-width: 440px;
        padding: 20px;
        animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        padding: 48px 40px;
        box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .glass-card::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(from 0deg at 50% 50%, transparent 0%, var(--primary-glow) 25%, transparent 50%);
        animation: rotate 10s linear infinite;
        opacity: 0.1;
        z-index: -1;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .brand-logo {
        display: block;
        width: 140px;
        margin: 0 auto 32px;
        filter: drop-shadow(0 0 10px rgba(59, 183, 126, 0.3));
        transition: transform 0.3s ease;
    }

    .brand-logo:hover {
        transform: scale(1.05);
    }

    html body .login-title, html.dark body .login-title {
        font-size: 32px;
        font-weight: 600;
        color: #000000 !important;
        text-align: center;
        margin-bottom: 8px;
    }

    html body .login-subtitle, html.dark body .login-subtitle {
        color: #444444 !important;
        text-align: center;
        font-size: 14px;
        margin-bottom: 40px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    /* Elegant Input Fields */
    .input-group-custom {
        position: relative;
        margin-bottom: 24px;
    }

    html body .input-group-custom input, html.dark body .input-group-custom input {
        width: 100%;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 16px 20px;
        color: #000000 !important;
        font-size: 15px;
        transition: all 0.3s ease;
        outline: none;
    }

    .input-group-custom input:focus {
        background: #ffffff;
        border-color: var(--primary-glow);
        box-shadow: 0 0 0 4px rgba(59, 183, 126, 0.15);
    }

    .input-group-custom input::placeholder {
        color: #9ca3af;
    }

    .error-text {
        color: #dc3545;
        font-size: 13px;
        margin-top: 6px;
        margin-left: 4px;
        display: block;
    }

    .was-validated input:invalid {
        border-color: #dc3545 !important;
        padding-right: 45px;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 20px 20px;
    }

    .invalid-feedback {
        display: none;
        color: #dc3545;
        font-size: 13px;
        margin-top: 6px;
        margin-left: 4px;
        text-align: left;
    }

    .was-validated input:invalid ~ .invalid-feedback {
        display: block;
    }

    .form-utils {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 32px;
    }

    html body .forgot-link, html.dark body .forgot-link {
        color: var(--primary-glow) !important;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .forgot-link:hover {
        color: var(--secondary-glow) !important;
        text-decoration: underline;
    }

    /* Premium Button */
    .btn-login {
        width: 100%;
        background: linear-gradient(135deg, var(--primary-glow) 0%, var(--secondary-glow) 100%);
        border: none;
        border-radius: 12px;
        padding: 16px;
        color: white;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 20px -5px rgba(59, 183, 126, 0.4);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 25px -5px rgba(59, 183, 126, 0.5);
    }

    .btn-login:active {
        transform: translateY(0);
    }
</style>

<div class="mesh-bg">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="particles" id="particles"></div>
</div>

<script>
    // Generate random particles
    const container = document.getElementById('particles');
    for (let i = 0; i < 20; i++) {
        const p = document.createElement('div');
        p.className = 'particle';
        const size = Math.random() * 3 + 2;
        p.style.width = `${size}px`;
        p.style.height = `${size}px`;
        p.style.left = `${Math.random() * 100}vw`;
        p.style.animationDuration = `${Math.random() * 10 + 10}s`;
        p.style.animationDelay = `${Math.random() * 10}s`;
        container.appendChild(p);
    }
</script>

<div class="auth-container">
    <div class="glass-card">
        <a href="{{ route('index') }}">
            <img src="{{ asset('assets/imgs/theme/ChennaiAngadiLogo.png') }}" class="brand-logo" alt="Chennai Angadi" />
        </a>
        
        <h1 class="login-title">Forgot Password</h1>
        <p class="login-subtitle">Enter your email address to receive an OTP</p>

        @include('includes.alert')

        <form method="POST" action="{{ route('password.email') }}" class="needs-validation" novalidate>
            @csrf
            
            <div class="input-group-custom">
                <input name="email" type="email" placeholder="Email" required value="{{ old('email') }}" autocomplete="email">
                <div class="invalid-feedback">Please enter your email address.</div>
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-login mb-4">
                Send OTP
            </button>
            
            <div class="form-utils">
                <a href="{{ route('login') }}" class="forgot-link">Remember your password? Sign in</a>
            </div>
        </form>
    </div>
</div>
@endsection