<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tiggie Kids</title>
</head>
<body>
    <p>Dear {{ $teacher->user->full_name }}</p>

    <p>{{ $description }}</p>

    <p>Thank you for using our services.</p>

    <hr>
    <p>If you have any questions, please contact our support team at support@example.com.</p>
</body>
</html>
