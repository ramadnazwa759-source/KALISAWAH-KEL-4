<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Account - Kali Sawah</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            height: 100vh;
            background-color: #ffffff;
        }

        .left {
            width: 50%;
            background: url('/uploud/foto.jpeg') center/cover no-repeat; /* BALIKIN BIAR MUNCUL */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .overlay-card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
            width: 100%;
            height: 100%;
            border-radius: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .right {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-box {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .form-box h2 {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 40px;
            text-align: center;
            color: #000;
        }

        .input-group {
            margin-bottom: 24px;
        }

        .input-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
            font-size: 16px;
            color: #000;
        }

        input {
            width: 100%;
            padding: 14px 18px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 15px;
            color: #333;
            outline: none;
        }

        input::placeholder {
            color: #d1d1d1;
        }

        button {
            width: 100%;
            padding: 16px;
            background: #0047ff;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }

        button:hover {
            background: #0036c7;
        }
    </style>
</head>
<body>

<div class="left">
    <div class="overlay-card"></div>
</div>

<div class="right">
    <div class="form-box">
        <h2>Login Account</h2>

        <form id="loginForm_pembuat">
            <div class="input-group">
                <label>Username</label>
                <!-- tetap username, tapi isi email -->
                <input type="text" name="username_pembuat" placeholder="Masukkan email" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password_pembuat" placeholder="6+ characters" required>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</div>

<script>
document.getElementById('loginForm_pembuat').addEventListener('submit', async function(e) {
    e.preventDefault();

    const email = document.querySelector('[name="username_pembuat"]').value.trim();
    const password = document.querySelector('[name="password_pembuat"]').value.trim();

    if (!email || !password) {
        alert("Email dan password wajib diisi");
        return;
    }

    try {
        const res = await fetch("http://127.0.0.1:8000/api/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({ email, password })
        });

        const data = await res.json();
        console.log("LOGIN RESPONSE:", data);

        if (res.ok) {
            localStorage.setItem("token", data.token);
            window.location.href = "/admin/dashboard";
        } else {
            alert(data.message || "Login gagal");
        }

    } catch (error) {
        console.error(error);
        alert("Server tidak bisa diakses");
    }
});
</script>

</body>
</html>
