<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>

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

    </style>
</head>

<body>

<div class="container">

    <h2>Create Account</h2>

    <form>

        <div class="form-group">
            <label>Login</label>
            <input type="text" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" required>
        </div>

        <div class="form-group">
            <label>Confirm password</label>
            <input type="password" required>
        </div>

        <button type="submit">Register</button>

    </form>

    <div class="switch">
        Already have an account? <a href="login.html">Login</a>
    </div>

</div>

</body>
</html>
