<!DOCTYPE html>
<html>
<head>
    <title>Ihr Passwort</title>
</head>

<body>
<h2>Willkommen {{ $user['first_name'] }} {{ $user['surname'] }},</h2>
<br/>
dein Passwort lautet: {{ $password }}.
</body>

</html>