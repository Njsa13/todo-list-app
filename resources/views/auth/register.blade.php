<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <style>
        .container {
            padding: 30px;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);
            margin-top: 10%;
            max-width: 700px;
        }

        .register-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .back-to-login {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 0;
        }
    </style>
    <title>Register</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="register-header">Register Todo List App</h1>
                <form id="register-form">
                    <div class="form-group">
                        <label for="name-input">Name</label>
                        <input type="text" class="form-control" id="name-input" autocomplete="off"
                            placeholder="Type your name here">
                    </div>
                    <div class="form-group">
                        <label for="email-input">Email</label>
                        <input type="email" class="form-control" id="email-input" autocomplete="off"
                            placeholder="Type your email here">
                    </div>
                    <div class="form-group">
                        <label for="password-input">Password</label>
                        <input type="password" class="form-control" id="password-input" autocomplete="off"
                            placeholder="Type your password here">
                    </div>
                    <div class="form-group">
                        <label for="password-input">Confirm Password</label>
                        <input type="password" class="form-control" id="password-confirmation" autocomplete="off"
                            placeholder="Confirm your password here">
                    </div>
                    <button id="submit-register" type="submit" class="btn btn-default">Create New Account</button>
                </form>
                <p class="back-to-login">Create new account or <a href="/auth/login">login now</a></p>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#register-form').submit(function(e) {
            $('#submit-register').prop('disabled', true);
            e.preventDefault();
            $.ajax({
                url: '{{ url('auth/register') }}',
                type: 'POST',
                data: {
                    name: $('#name-input').val(),
                    email: $('#email-input').val(),
                    password: $('#password-input').val(),
                    password_confirmation: $('#password-confirmation').val()
                },
                success: function(res) {
                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON;

                        $.each(errors, function(key, messages) {
                            messages.forEach(function(message) {
                                iziToast.error({
                                    title: 'Validation Error',
                                    message: message,
                                    position: 'topCenter'
                                });
                            });
                        });
                    } else {
                        iziToast.error({
                            title: 'Error ' + xhr.status,
                            message: xhr.status == 500 ? 'Failed to register :' : xhr
                                .responseJSON.error,
                            position: 'topCenter'
                        });
                    }
                }
            });
            $('#submit-register').prop('disabled', false);
            $('#name-input').val('');
            $('#email-input').val('');
            $('#password-input').val('');
            $('#password-confirmation').val('');
        });
    </script>
</body>

</html>
