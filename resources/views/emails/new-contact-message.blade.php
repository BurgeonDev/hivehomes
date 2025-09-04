<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>New Contact Message</title>
</head>

<body>
    <p><strong>Name:</strong> {{ $contact->name }}</p>
    <p><strong>Email:</strong> {{ $contact->email }}</p>
    <p><strong>Phone:</strong> {{ $contact->phone }}</p>
    <p><strong>Message:</strong></p>
    <p>{!! nl2br(e($contact->message)) !!}</p>
</body>

</html>
