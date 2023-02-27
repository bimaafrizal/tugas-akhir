<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Notification</title>
</head>
<body>
    <h1>Password Reset Notification</h1>
    <p>Hi {{ $user->name }},</p>
    <p>You recently requested to reset your password for your account on our website. To complete the process, please click the button below:</p>
    <p><a href="{{ $actionUrl }}" target="_blank">Reset Password</a></p>
    <p>If you did not request a password reset, no further action is required.</p>
    <p>Thank you for using our website!</p>
</body>
</html>