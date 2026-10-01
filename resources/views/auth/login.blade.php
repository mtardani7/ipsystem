<!DOCTYPE html>
<html>
<head>

<link rel="icon" href="{{ asset('img/login/favicon.ico') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
<meta charset="UTF-8">

<title>IP System Login</title>
<style>
body {
    background-image: url({{ asset('img/login/climpek.png') }});
    font-family: "Oswald", sans-serif;
}

.logo {
    width: 100px;
    height: 36px;
    margin: 50px auto;
}

.labelbot {
    padding-top: 10px;
    text-align: center;
    color: #000;
    font-size: 12px;
    margin-top: 0;
    margin-bottom: 20px;
}

.labelbotfailed {
    padding-top: 10px;
    text-align: center;
    color: red;
    font-size: 14px;
    margin-top: 0;
    margin-bottom: 20px;
}

.login-block {
    width: 320px;
    padding: 20px;
    background: #f2f2f2;
    border-radius: 5px;
    border-top: 5px solid #ff656c;
    margin: 0 auto;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}

.login-block h1 {
    text-align: center;
    color: #000;
    font-size: 18px;
    font-weight: bold;
    text-transform: uppercase;
    margin-top: 0;
    margin-bottom: 20px;
}

.login-block h2 {
    text-align: center;
    color: #ff3333;
    font-size: 14px;
    margin-top: 0;
    margin-bottom: 5px;
}

.login-block input {
    width: 100%;
    height: 42px;
    box-sizing: border-box;
    border-radius: 5px;
    border: 1px solid #ccc;
    margin-bottom: 20px;
    font-size: 14px;
    font-family: Montserrat, sans-serif;
    padding: 0 20px 0 50px;
    outline: none;
}

.login-block input#username {
    background: #fff url({{ asset('img/login/login-user.png') }}) 20px top no-repeat;
    background-size: 16px 80px;
}

.login-block input#username:focus {
    background: #fff url({{ asset('img/login/login-user.png') }}) 20px bottom no-repeat;
    background-size: 16px 80px;
}

.password-container {
    position: relative;
    width: 100%;
    margin-bottom: 20px;
}

.login-block input#password {
    background: #fff url({{ asset('img/login/login-pass.png') }}) 20px top no-repeat;
    background-size: 16px 80px;
    width: 100%;
    margin-bottom: 0;
    padding-right: 50px;
}

.login-block input#password:focus {
    background: #fff url({{ asset('img/login/login-pass.png') }}) 20px bottom no-repeat;
    background-size: 16px 80px;
}

.login-block input:active,
.login-block input:focus {
    border: 1px solid #ff656c;
}

.toggle-password {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #888;
    transition: color 0.2s;
    outline: none;
}

.toggle-password:hover {
    color: #ff656c;
}

.toggle-password svg {
    width: 20px;
    height: 20px;
    fill: none;
    stroke: currentColor;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.login-block button[type="submit"] {
    width: 100%;
    height: 40px;
    background: #ff656c;
    box-sizing: border-box;
    border-radius: 5px;
    border: 1px solid #e15960;
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 14px;
    font-family: Montserrat, sans-serif;
    outline: none;
    cursor: pointer;
}

.login-block button[type="submit"]:hover {
    background: #ff7b81;
}
</style>
</head>

<body>

<div class="logo"><img src="{{ asset('img/login/logo3.png') }}" width="100px" alt="Logo"></div>
<div class="labelbotfailed">
    @if ($errors->has('email'))
        <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
    @endif

    @if ($errors->has('password'))
        <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
    @endif
</div>
<div class="login-block">
    <h2>ISO Paperless System</h2>
    <h1>Login</h1>
    <form action="{{ route('login') }}" method="POST">
        {{ csrf_field() }}
        <input type="text" value="" placeholder="Username / Email" id="username" name="email" required />
        <div class="password-container">
            <input type="password" value="" placeholder="Password" id="password" name="password" required />
            <button type="button" class="toggle-password" id="togglePassword" aria-label="Show password">
                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </button>
        </div>

        <button type="submit">Login</button>
    </form>
</div>
<div class="labelbot">ISO 9001:2015 Documents</div>


<script>
    (function() {
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eyeIcon');

        if (!passwordInput || !toggleButton || !eyeIcon) return;

        const eyeOpenSvg = `
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
            <circle cx="12" cy="12" r="3"/>
        `;
        const eyeClosedSvg = `
            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
            <line x1="1" y1="1" x2="23" y2="23"/>
        `;

        toggleButton.addEventListener('click', function(e) {
            e.preventDefault();
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = eyeClosedSvg;
                toggleButton.setAttribute('aria-label', 'Hide password');
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = eyeOpenSvg;
                toggleButton.setAttribute('aria-label', 'Show password');
            }
        });

        toggleButton.addEventListener('mousedown', function(e) {
            e.preventDefault();
        });
    })();
</script>

</body>
</html>