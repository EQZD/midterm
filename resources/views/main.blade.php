<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


@if($auth === 'success')
    <script>alert('{{ __('messages.authorization_success') }}');</script>
@endif


<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.fitness_club') }}</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #222;
            color: white;
            padding: 15px 40px;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .hero {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 50vh;
            background: linear-gradient(to right, #ff512f, #dd2476);
            color: white;
        }

        .charts {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 40px;
            padding: 40px;
        }

        canvas {
            width: 350px !important;
            height: 350px !important;
        }

        .ad-box {
            width: 280px;
            padding: 15px;
            background: gold;
            position: fixed;
            bottom: 20px;
            right: 20px;
            border-radius: 10px;
            text-align: center;
        }

        button {
            margin: 2px;
            padding: 5px;
        }

        .language-switcher {
            display: flex;
            gap: 8px;
        }

        .language-switcher a {
            color: white;
            text-decoration: none;
            border: 1px solid rgba(255,255,255,0.4);
            border-radius: 5px;
            padding: 2px 7px;
            font-size: 13px;
        }

        .language-switcher a.active {
            background: white;
            color: #222;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div>{{ __('messages.fitness_club') }}</div>
    <div class="nav-links">
        <div>{{ __('messages.home') }}</div>
        <div>{{ __('messages.services') }}</div>
        <div>{{ __('messages.contact') }}</div>
        <div class="language-switcher" aria-label="{{ __('messages.choose_language') }}">
            <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
            <a href="{{ route('lang.switch', 'ru') }}" class="{{ app()->getLocale() === 'ru' ? 'active' : '' }}">RU</a>
            <a href="{{ route('lang.switch', 'kz') }}" class="{{ app()->getLocale() === 'kz' ? 'active' : '' }}">KZ</a>
        </div>
        @auth
            <div>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: white; font-family: inherit; font-size: inherit; cursor: pointer; padding: 0;">{{ __('messages.logout') }}</button>
                </form>
            </div>
        @endauth
    </div>
</div>

<div class="hero">
    <h1>{{ __('messages.welcome_to_fitness_club') }}</h1>
    <p>{{ __('messages.track_progress') }}</p>
</div>

<div class="charts">
    <canvas id="barChart"></canvas>
    <canvas id="pieChart"></canvas>
    <canvas id="polarChart"></canvas>
    <canvas id="lineChart"></canvas>
</div>

<div class="ad-box">
    <h3>{{ __('messages.discount_50') }}</h3>
    <p>{{ __('messages.join_today') }}</p>

    <button id="hide">{{ __('messages.hide') }}</button>
    <button id="show">{{ __('messages.show') }}</button>
    <button id="fadeIn">{{ __('messages.fade_in') }}</button>
    <button id="fadeOut">{{ __('messages.fade_out') }}</button>
    <button id="fadeTo">{{ __('messages.fade_to') }}</button>
    <button id="slideUp">{{ __('messages.slide_up') }}</button>
    <button id="slideDown">{{ __('messages.slide_down') }}</button>
    <button id="animate">{{ __('messages.animate') }}</button>
    <button id="stop">{{ __('messages.stop') }}</button>
</div>

<script>
$(document).ready(function(){

    $("#hide").click(function(){ $(".ad-box").hide(); });
    $("#show").click(function(){ $(".ad-box").show(); });
    $("#fadeIn").click(function(){ $(".ad-box").fadeIn(); });
    $("#fadeOut").click(function(){ $(".ad-box").fadeOut(); });
    $("#fadeTo").click(function(){ $(".ad-box").fadeTo(1000, 0.4); });
    $("#slideUp").click(function(){ $(".ad-box").slideUp(); });
    $("#slideDown").click(function(){ $(".ad-box").slideDown(); });
    $("#animate").click(function(){
        $(".ad-box").animate({
            width: "320px",
            opacity: 0.8
        }, 1000);
    });
    $("#stop").click(function(){ $(".ad-box").stop(); });

});
</script>

<script>
new Chart(document.getElementById("barChart"), {
    type: "bar",
    data: {
        labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sun", "Wn"],
        datasets: [{
            label: "Visitors",
            data: [80, 65, 74, 67, 70, 58, 54]
        }]
    }
});

new Chart(document.getElementById("pieChart"), {
    type: "pie",
    data: {
        labels: ["Gym", "Yoga", "Volleyball"],
        datasets: [{
            data: [43, 25, 29]
        }]
    }
});

new Chart(document.getElementById("polarChart"), {
    type: "polarArea",
    data: {
        labels: ["Protein", "Creatine", "Energy Drink"],
        datasets: [{
            data: [12, 7, 30]
        }]
    }
});

new Chart(document.getElementById("lineChart"), {
    type: "line",
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May"],
        datasets: [{
            label: "New Members",
            data: [10, 12, 8, 10, 15],
            fill: false
        }]
    }
});
</script>

</body>
</html>
