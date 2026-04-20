<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

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
            <p>Selamat datang kembali!</p>
        </div>
    </div>

    <!-- KANAN -->
    <div class="right">
        <div class="form-box">
            <h2>Login Account</h2>

            <!-- SUCCESS -->
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ERROR -->
            @if($errors->any())
                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <!-- EMAIL -->
                <label style="display:block; margin-bottom:5px; font-size:16px;">Email</label>
                <input
                    type="email"
                    name="email"
                    placeholder="Masukkan email"
                    style="width:100%; padding:12px; border-radius:4px; border:1px solid #ccc; margin-bottom:15px;"
                    required
                >

                <!-- PASSWORD -->
                <label style="display:block; margin-bottom:5px; font-size:16px;">Password</label>
                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    style="width:100%; padding:12px; border-radius:4px; border:1px solid #ccc; margin-bottom:0px;"
                    required
                >

                <button type="submit">Login</button>
            </form>

            <div class="link">
                <a href="{{ route('register') }}">Belum punya akun? Register</a>
            </div>
        </div>
    </div>

</body>
</html>
