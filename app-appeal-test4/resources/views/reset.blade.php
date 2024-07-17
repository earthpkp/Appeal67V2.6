<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
</head>

<body style="margin: 100px;">
    <h1>You have requested to reset your password</h1>
    <hr>
    <p>We cannot simply send you your old password. A unique link to reset your
        password has been generated for you. To reset your password, click the
        following link and follow the instructions.</p>
    <h1><a href="http://localhost:8001/user/reset/{{ $token }}">Click Here to Reset Password</a></h1>
</body>

</html>