<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reply from {{ config('app.name') }}</title>
</head>

<body>
    <p>Dear {{ $contact->name }},</p>

    <p>{!! nl2br(e($reply)) !!}</p>

    <p>Best regards,<br>{{ config('mail.from.name') }}</p>
</body>

</html>
