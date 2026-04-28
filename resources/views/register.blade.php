<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ __('messages.register') }}</title>

    <style>

        *{
            box-sizing:border-box;
            font-family:Arial;
        }

        body{
            margin:0;
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:linear-gradient(135deg,#ff512f,#dd2476);
        }

        .container{
            background:white;
            padding:40px;
            width:360px;
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
            font-size:14px;
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

    </style>
</head>

<body>

<div class="container">

    <div class="language-switcher" aria-label="{{ __('messages.choose_language') }}">
        <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
        <a href="{{ route('lang.switch', 'ru') }}" class="{{ app()->getLocale() === 'ru' ? 'active' : '' }}">RU</a>
        <a href="{{ route('lang.switch', 'kz') }}" class="{{ app()->getLocale() === 'kz' ? 'active' : '' }}">KZ</a>
    </div>

    <h2>{{ __('messages.create_account') }}</h2>

    <form>

        <div class="form-group">
            <label>{{ __('messages.login') }}</label>
            <input type="text" required>
        </div>

        <div class="form-group">
            <label>{{ __('messages.email') }}</label>
            <input type="email" required>
        </div>

        <div class="form-group">
            <label>{{ __('messages.password') }}</label>
            <input type="password" required>
        </div>

        <div class="form-group">
            <label>{{ __('messages.confirm_password') }}</label>
            <input type="password" required>
        </div>

        <button type="submit">{{ __('messages.register') }}</button>

    </form>

    <div class="switch">
        {{ __('messages.already_have_account') }} <a href="{{ route('login') }}">{{ __('messages.login') }}</a>
    </div>

</div>

</body>
</html>
