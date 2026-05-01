<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.login') }}</title>

    <style>
        *{
            box-sizing:border-box;
            font-family:Arial;
        }

        body{
            margin:0;
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:linear-gradient(135deg,#ff512f,#dd2476);
            padding:24px 16px;
        }

        .container{
            background:white;
            padding:clamp(24px, 6vw, 40px);
            width:90%;
            max-width:360px;
            border-radius:12px;
            box-shadow:0 10px 25px rgba(0,0,0,0.2);
        }

        h2{
            text-align:center;
            margin-bottom:25px;
        }

        .form-group{
            margin-bottom:15px;
        }

        label{
            display:block;
            font-size:14px;
            margin-bottom:5px;
            color:#555;
        }

        input{
            width:100%;
            padding:12px;
            border:1px solid #ccc;
            border-radius:6px;
        }

        input:focus{
            outline:none;
            border-color:#ff512f;
        }

        button{
            width:100%;
            padding:12px;
            background:#ff512f;
            border:none;
            border-radius:6px;
            color:white;
            font-size:15px;
            cursor:pointer;
            margin-top:10px;
        }

        button:hover{
            background:#e64a2f;
        }

        .switch{
            text-align:center;
            margin-top:15px;
            font-size:14px;
        }

        .switch a{
            color:#ff512f;
            text-decoration:none;
        }

        .language-switcher{
            display:flex;
            justify-content:center;
            gap:8px;
            margin-bottom:18px;
            font-size:13px;
        }

        .language-switcher a{
            color:#ff512f;
            text-decoration:none;
            border:1px solid #ffd2c8;
            border-radius:5px;
            padding:4px 8px;
        }

        .language-switcher a.active{
            background:#ff512f;
            color:white;
            border-color:#ff512f;
        }

        @media (min-width: 1400px) {
            .container { max-width: 420px; }
        }

        @media (max-width: 480px) {
            h2 { font-size: 24px; }
            button, input { min-height: 44px; }
        }
    </style>

</head>

<body>

<div class="container">

    <div class="language-switcher" aria-label="{{ __('messages.choose_language') }}">
        <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
        <a href="{{ route('lang.switch', 'ru') }}" class="{{ app()->getLocale() === 'ru' ? 'active' : '' }}">RU</a>
        <a href="{{ route('lang.switch', 'kz') }}" class="{{ app()->getLocale() === 'kz' ? 'active' : '' }}">KZ</a>
    </div>

    <h2>{{ __('messages.login') }}</h2>

    <form action="/login" method="post">
        @csrf

        @if(session('error'))
            <p style="color:red; text-align:center;">{{ session('error') }}</p>
        @endif

        <div class="form-group">
            <label>{{ __('messages.login') }}</label>
            <input type="text" name="email" required>
        </div>

        <div class="form-group">
            <label>{{ __('messages.password') }}</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit">{{ __('messages.login') }}</button>

    </form>

    <div class="switch">
        {{ __('messages.no_account') }} <a href="{{ route('register') }}">{{ __('messages.register') }}</a>
    </div>

</div>

</body>
</html>
