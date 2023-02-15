<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <h2>Email Verification Required</h2>

    <p>Please verify your email address by clicking on the link that we've sent to your email. If you didn't receive the email, please check your spam folder or request another verification email.</p>

    <form action="{{ route('verification.send') }}" method="POST">
        @csrf

        <button type="submit">Resend Verification Email</button>
    </form>
</body>
</html>