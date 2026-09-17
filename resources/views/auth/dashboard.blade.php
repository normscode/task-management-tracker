@vite(['resources/css/app.css', 'resources/js/app.js'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Welcome to the Dashboard</h1>
    <p>You are logged in!</p>

    <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-primary">
        Logout
    </button>
</form>
</body>
</html>