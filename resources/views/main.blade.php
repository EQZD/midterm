<!DOCTYPE html>
<html lang="en">


@if($auth === 'success')
    <script>alert('Authorization passed successfully');</script>
@endif


<head>
    <meta charset="UTF-8">
    <title>Fitness Club</title>

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
    </style>
</head>
<body>

<div class="navbar">
    <div>Fitness Club</div>
    <div class="nav-links">
        <div>Home</div>
        <div>Services</div>
        <div>Contact</div>
        @auth
            <div>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: white; font-family: inherit; font-size: inherit; cursor: pointer; padding: 0;">Logout</button>
                </form>
            </div>
        @endauth
    </div>
</div>

<div class="hero">
    <h1>Welcome to Fitness Club</h1>
    <p>Track Our Progress</p>
</div>

<div class="charts">
    <canvas id="barChart"></canvas>
    <canvas id="pieChart"></canvas>
    <canvas id="polarChart"></canvas>
    <canvas id="lineChart"></canvas>
</div>

<div class="ad-box">
    <h3>50% Discount!</h3>
    <p>Join Today</p>

    <button id="hide">Hide</button>
    <button id="show">Show</button>
    <button id="fadeIn">FadeIn</button>
    <button id="fadeOut">FadeOut</button>
    <button id="fadeTo">FadeTo</button>
    <button id="slideUp">SlideUp</button>
    <button id="slideDown">SlideDown</button>
    <button id="animate">Animate</button>
    <button id="stop">Stop</button>
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
