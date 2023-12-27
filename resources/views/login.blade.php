
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #006a4e;
        }

        .container{
            width: 100%;
            display: flex;
            max-width: 850px;
            background: #f7f7f7;
            border-radius: 15px;
            box-shadow: 0 10px 15px rgb(0, 0, 0, 0.1)
        }

        .login{
            width: 400px;
        }

        form{
            width: 250px;
            margin: 60px auto;

        }

        h1 {
            margin: 20px;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }

        hr {
            border-top: 2px solid #ab863a;    
        }

        p {
            text-align: center;
            margin: 10px;    
        }

        .right img{
            width: 450px;
            height: 100%;
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        form label {
            display: block;
            font-size: 16px;
            font-weight: 600;
            padding: 5px;
        }

        input {
            width: 100%;
            margin: 2px;
            border: none;
            outline: none;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid gray;
        }

        button {
            border: none;
            outline: none;
            padding: 8px;
            width: 252px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            border-radius: 5px;
            background: #ab863a;
        }

        button:hover {
            background: rgb(244, 130, 88);
        }

        @media (max-width: 880px) {
            .container {
                width: 100%;
                max-width: 750px;
                margin-left: 20px;
                margin-right: 20px;
            }

            form {
                width: 300px;
                margin: 20px auto;
            }

            .login {
                width: 400px;
                padding: 20px;
            }

            button {
                width: 100%;
            }

            .right img {
                width: 100%;
                height: 100%;
            }
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: .25rem;
        }

        .alert-primary {
            color: white;
            /* background-color: #cce5ff; */
            border-color: #b8daff;
            background: rgb(244, 130, 88);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login">
            <form class="mt-5 mb-5 login-input" method="post" action="{{ route('login.store') }}">
                <h1>Login</h1>
                <hr>
                <p>Masjid Raya Lubuak Jantan</p>

                <div id="message" style="display: none;">
                    <div class="alert alert-primary" role="alert">
                        {{ session()->get('message') }}
                    </div>
                </div>
                
                @csrf
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <button class="btn login-form__btn submit w-100">Login</button>
            </form>

        </div>
        <div class="right">
            <img src="{{ asset('assets/images/masjid/logo.png') }}" alt="">
        </div>

    </div>

    @if (session()->has('message'))
        <script>
            var message = document.getElementById('message');
            message.style.display = 'block';

            setTimeout(function () {
                message.style.display = 'none';
            }, 5000);
        </script>
    @endif
    
</body>
</html>