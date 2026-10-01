@extends('layouts.app')

@section('content')

<style>
body {
    background-image: url({{ asset('img/login/climpek.png') }});
    font-family: Comic Sans MS;
}



.logo {
    width: 100px;
    height: 36px;
    margin: 50px auto;
}

.labelbot {
	padding-top:10px;
    text-align: center;
    color: #000;
    font-size: 12px;
    margin-top: 0;
    margin-bottom: 20px;
}

.labelbotfailed {
	padding-top:10px;
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
	font-weight:bold;
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
    font-family: Montserrat;
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

.login-block input#password {
    background: #fff url({{ asset('img/login/login-pass.png') }}) 20px top no-repeat;
    background-size: 16px 80px;
}

.login-block input#password:focus {
    background: #fff url({{ asset('img/login/login-pass.png') }}) 20px bottom no-repeat;
    background-size: 16px 80px;
}

.login-block input:active, .login-block input:focus {
    border: 1px solid #ff656c;
}

.login-block button {
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
    font-family: Montserrat;
    outline: none;
    cursor: pointer;
}

.login-block button:hover {
    background: #ff7b81;
}

</style>


<body style="background-image: url({{ asset('img/login/climpek.png') }}); font-family: Comic Sans MS;">
<div class="logo" style="width: 100px;height: 36px;margin: 50px auto;"><img src="{{ asset('img/login/logo3.png') }}" width="100px" ></div>
<div class="login-block" style="width: 320px;padding: 20px;background: #f2f2f2;border-radius: 5px;border-top: 5px solid #ff656c;margin: 0 auto;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
	<h2 style="text-align: center;color: #ff3333;font-size: 14px;margin-top: 0;margin-bottom: 5px;">ISO Paperless System</h2>
    <h1 style="text-align: center;color: #000;font-size: 18px;font-weight:bold;text-transform: uppercase;margin-top: 0;margin-bottom: 20px;">Login</h1>
	<form action="#" method="POST">
    <input style="width: 100%;height: 42px;box-sizing: border-box;border-radius: 5px;border: 1px solid #ccc;margin-bottom: 20px;font-size: 14px;font-family: Montserrat;padding: 0 20px 0 50px;outline: none; background: #fff url({{ asset('img/login/login-user.png') }}) 20px top no-repeat;
    background-size: 16px 80px;" type="text" value="" placeholder="Username" id="username" name="username"/>
    <input style="width: 100%;height: 42px;box-sizing: border-box;border-radius: 5px;border: 1px solid #ccc;margin-bottom: 20px;font-size: 14px;font-family: Montserrat;padding: 0 20px 0 50px;outline: none;
    background: #fff url({{ asset('img/login/login-pass.png') }}) 20px top no-repeat;
    background-size: 16px 80px;
    " type="password" value="" placeholder="Password" id="password" name="password" />
    <button type="submit"
    style="
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
    font-family: Montserrat;
    outline: none;
    cursor: pointer;
    ">Submit</button>
	</form>
</div>
<div class="labelbot" style="padding-top:10px;text-align: center;color: #000;font-size: 12px;margin-top: 0;margin-bottom: 20px;">ISO 9001:2015 Documents</div><br><br>
</body>

@endsection
