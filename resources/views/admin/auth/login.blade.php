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

        .success {
            color: green;
            font-size: 12px;
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

            <!-- ERROR / SUCCESS -->
            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="error">{{ $errors->first() }}</div>
            @endif

            <!-- FORM LOGIN SESSION-BASED -->
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>

            <div class="link">
                <a href="{{ route('register') }}">Belum punya akun? Register</a>
            </div>
        </div>
    </div>

</body>
</html>
