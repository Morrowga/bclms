<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
</head>
<body>
    <h1>New Contact Form Submission</h1>
    <p>A new message has been submitted via the contact form:</p>

    <h2>Contact Details:</h2>
    <ul>
        <li><strong>Name:</strong> {{ $name }}</li>
        <li><strong>Email:</strong> {{ $email }}</li>
    </ul>

    <h2>Message:</h2>
    <p>{{ $contact_message }}</p>

    <p>Regards,<br>Tiggie Kids</p>
</body>
</html>
