<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
        }

        /* KIRI (GAMBAR) */
        .left {
            width: 50%;
            background: url('/images/arung-jeram.jpg') center/cover no-repeat;
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.6);
            padding: 40px;
            border-radius: 20px;
            text-align: center;
        }

        .overlay h1 {
            color: #1e40af;
        }

        /* KANAN (FORM) */
        .right {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f4f4f4;
        }

        .form-box {
            width: 350px;
        }

        h2 {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: #1d4ed8;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: #1e3a8a;
        }

        .link {
            margin-top: 10px;
            text-align: center;
        }

        .error {
            color: red;
            font-size: 12px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
        }

    </style>
</head>
<body>

    <!-- KIRI -->
    <div class="left">
        <div class="overlay">
            <h1>Kali Sawah Adventure</h1>
            <p>Daftar sekarang dan nikmati wisata terbaik!</p>
        </div>
    </div>

    <!-- KANAN -->
    <div class="right">
        <div class="form-box">
            <h2>Register Account</h2>

            <!-- TAMPILKAN SESSION SUCCESS -->
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('register.submit') }}" method="POST">
                @csrf

                <input type="text" name="name" placeholder="Nama" value="{{ old('name') }}">
                @error('name') <div class="error">{{ $message }}</div> @enderror

                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                @error('email') <div class="error">{{ $message }}</div> @enderror

                <input type="password" name="password" placeholder="Password">
                @error('password') <div class="error">{{ $message }}</div> @enderror

                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password">

                <input type="hidden" name="role" value="user">

                <button type="submit">Register</button>
            </form>

            <div class="link">
                <a href="{{ route('login') }}">Sudah punya akun? Login</a>
            </div>
        </div>
    </div>

</body>
</html>
