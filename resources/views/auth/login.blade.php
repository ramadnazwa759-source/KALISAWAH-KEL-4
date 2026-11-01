
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Account - Kalisawah Adventure</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #0878e8;
            --primary-dark: #075fc0;
            --navy: #103b70;
            --yellow: #ffc83d;
            --text: #163d6b;
            --muted: #7790b0;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: #f3f8ff;
            color: var(--text);
        }

        .login-page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            overflow: hidden;
            background:
                radial-gradient(circle at 95% 10%, #e1efff 0, transparent 28%),
                #f6faff;
        }

        /* BAGIAN KIRI */
        .left {
            position: relative;
            min-height: 100vh;
            padding: 35px 45px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            background:
                linear-gradient(
                    180deg,
                    rgba(5, 35, 69, 0.12) 0%,
                    rgba(5, 35, 69, 0.05) 40%,
                    rgba(5, 35, 69, 0.88) 100%
                ),
                url('/uploud/foto.jpeg') center/cover no-repeat;
        }

        .left::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                120deg,
                rgba(5, 42, 82, 0.25),
                transparent 55%,
                rgba(0, 54, 112, 0.18)
            );
            pointer-events: none;
        }

        .brand,
        .hero-content,
        .features {
            position: relative;
            z-index: 1;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            width: fit-content;
            padding: 12px 17px;
            background: rgba(255, 255, 255, 0.94);
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 30, 70, 0.12);
        }

        .brand-icon {
            width: 43px;
            height: 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e8f3ff;
            color: var(--primary);
            border-radius: 13px;
            font-size: 22px;
        }

        .brand-name {
            font-size: 17px;
            font-weight: 800;
            color: var(--navy);
            letter-spacing: -0.5px;
        }

        .brand-name span {
            display: block;
            color: #e7a900;
            font-size: 11px;
            letter-spacing: 2px;
            margin-top: 2px;
        }

        .hero-content {
            max-width: 600px;
            margin: auto 0;
            padding: 65px 0;
            color: white;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 15px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .hero-tag i {
            color: var(--yellow);
        }

        .hero-content h1 {
            font-size: clamp(34px, 4vw, 54px);
            line-height: 1.12;
            letter-spacing: -1.8px;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .hero-content h1 span {
            color: var(--yellow);
        }

        .hero-content p {
            max-width: 470px;
            font-size: 15px;
            line-height: 1.9;
            color: rgba(255, 255, 255, 0.9);
        }

        .hero-note {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 28px;
            padding: 13px 17px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 14px;
            backdrop-filter: blur(8px);
            font-size: 12px;
            font-weight: 600;
        }

        .hero-note i {
            color: var(--yellow);
            font-size: 17px;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 13px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.13);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            backdrop-filter: blur(8px);
            color: white;
            font-size: 12px;
            font-weight: 600;
        }

        .feature i {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 11px;
            color: var(--yellow);
            background: rgba(255, 255, 255, 0.15);
            font-size: 16px;
        }

        /* BAGIAN KANAN */
        .right {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 45px;
            overflow: hidden;
        }

        .right::before,
        .right::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .right::before {
            width: 300px;
            height: 300px;
            background: rgba(20, 126, 239, 0.06);
            top: -160px;
            right: -100px;
        }

        .right::after {
            width: 240px;
            height: 240px;
            background: rgba(255, 200, 61, 0.09);
            bottom: -130px;
            left: -120px;
        }

        .form-box {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            padding: 42px 38px;
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid #e5effb;
            border-radius: 27px;
            box-shadow: 0 22px 70px rgba(24, 76, 135, 0.09);
        }

        .form-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .form-icon {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            background: #e8f3ff;
            color: var(--primary);
            border-radius: 21px;
            font-size: 25px;
        }

        .form-header h2 {
            font-size: 29px;
            line-height: 1.3;
            font-weight: 800;
            color: var(--navy);
            letter-spacing: -0.8px;
            margin-bottom: 10px;
        }

        .form-header p {
            font-size: 13px;
            line-height: 1.8;
            color: var(--muted);
        }

        .input-group {
            margin-bottom: 23px;
        }

        .input-group label {
            display: block;
            margin-bottom: 10px;
            color: var(--navy);
            font-size: 13px;
            font-weight: 700;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap > i {
            position: absolute;
            left: 17px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c94c2;
            font-size: 15px;
        }

        .input-wrap input {
            width: 100%;
            height: 54px;
            padding: 0 45px;
            border: 1px solid #d7e4f3;
            border-radius: 14px;
            background: #f5f9ff;
            outline: none;
            color: var(--navy);
            font-family: inherit;
            font-size: 13px;
            transition: 0.25s ease;
        }

        .input-wrap input::placeholder {
            color: #9aadc4;
        }

        .input-wrap input:focus {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(8, 120, 232, 0.09);
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #7895b5;
            cursor: pointer;
            font-size: 14px;
            padding: 5px;
        }

        .login-button {
            width: 100%;
            min-height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 30px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(110deg, #0878e8, #0863d2);
            color: white;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 10px 24px rgba(8, 120, 232, 0.2);
            transition: 0.25s ease;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(8, 120, 232, 0.28);
        }

        .error {
            margin-top: 20px;
            padding: 12px 14px;
            border: 1px solid #fecaca;
            border-radius: 12px;
            background: #fef2f2;
            color: #dc2626;
            font-size: 12px;
            line-height: 1.6;
        }

        .back-home {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 28px;
            color: var(--primary);
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.2s;
        }

        .back-home:hover {
            color: var(--primary-dark);
            gap: 14px;
        }

        .back-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eaf4ff;
            border-radius: 50%;
        }

        .copyright {
            position: absolute;
            bottom: 18px;
            right: 20px;
            color: #94a9c2;
            font-size: 10px;
        }

        /* RESPONSIVE */
        @media (max-width: 1000px) {
            .login-page {
                grid-template-columns: 1fr 0.9fr;
            }

            .left {
                padding: 28px;
            }

            .right {
                padding: 25px;
            }

            .form-box {
                padding: 35px 25px;
            }

            .hero-content h1 {
                font-size: 38px;
            }

            .features {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 760px) {
            .login-page {
                grid-template-columns: 1fr;
            }

            .left {
                min-height: 330px;
                padding: 22px;
                background-position: center;
            }

            .brand {
                padding: 9px 12px;
            }

            .brand-icon {
                width: 36px;
                height: 36px;
            }

            .hero-content {
                padding: 40px 0 25px;
                margin: 0;
            }

            .hero-content h1 {
                font-size: 34px;
            }

            .hero-content p {
                font-size: 13px;
            }

            .hero-tag {
                margin-bottom: 15px;
            }

            .hero-note,
            .features {
                display: none;
            }

            .right {
                min-height: auto;
                padding: 30px 18px 55px;
            }

            .form-box {
                max-width: 460px;
                padding: 32px 23px;
                border-radius: 23px;
            }

            .form-header {
                margin-bottom: 28px;
            }

            .form-header h2 {
                font-size: 26px;
            }

            .copyright {
                bottom: 12px;
                right: 0;
                left: 0;
                text-align: center;
            }
        }

        @media (max-width: 380px) {
            .hero-content h1 {
                font-size: 29px;
            }

            .form-box {
                padding: 27px 18px;
            }
        }
    </style>
</head>
<body>

<div class="login-page">

    <!-- BAGIAN KIRI: FOTO DAN INFORMASI -->
    <section class="left">

        <div class="hero-content">
            <h1>
                Selamat Datang di
                <span>Admin Kalisawah Adventure</span>
            </h1>

        <div class="features">
            <div class="feature">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Aman & Terpercaya</span>
            </div>

            <div class="feature">
                <i class="fa-solid fa-users"></i>
                <span>Pelayanan Profesional</span>
            </div>

            <div class="feature">
                <i class="fa-solid fa-mountain-sun"></i>
                <span>Paket Wisata Lengkap</span>
            </div>

            <div class="feature">
                <i class="fa-solid fa-leaf"></i>
                <span>Alam yang Memukau</span>
            </div>
        </div>

    </section>

    <!-- BAGIAN KANAN: FORM LOGIN -->
    <section class="right">

        <div class="form-box">

            <div class="form-header">
                <div class="form-icon">
                    <i class="fa-solid fa-mountain-sun"></i>
                </div>

                <h2>Login Account</h2>

                <p>
                    Masuk untuk melanjutkan ke akun
                    Kalisawah Adventure Anda.
                </p>
            </div>

            <form method="POST" action="{{ url('/admin/login') }}">
                @csrf

                <div class="input-group">
                    <label for="email">Email</label>

                    <div class="input-wrap">
                        <i class="fa-solid fa-envelope"></i>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Masukkan email"
                            value="{{ old('email') }}"
                            autocomplete="username"
                            required
                        >
                    </div>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>

                    <div class="input-wrap">
                        <i class="fa-solid fa-lock"></i>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            id="togglePassword"
                            aria-label="Tampilkan password"
                        >
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="login-button">
                    Login
                    <i class="fa-solid fa-arrow-right"></i>
                </button>

                @if(session('error'))
                    <div class="error">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="error">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ $errors->first() }}
                    </div>
                @endif
            </form>
        </div>

        <div class="copyright">
            &copy; {{ date('Y') }} Kalisawah Adventure
        </div>

    </section>

</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const isPassword = passwordInput.type === 'password';

        passwordInput.type = isPassword ? 'text' : 'password';

        this.innerHTML = isPassword
            ? '<i class="fa-solid fa-eye-slash"></i>'
            : '<i class="fa-solid fa-eye"></i>';

        this.setAttribute(
            'aria-label',
            isPassword ? 'Sembunyikan password' : 'Tampilkan password'
        );
    });
</script>

</body>
</html>
