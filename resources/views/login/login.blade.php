<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body class="center">
    <div class="login-box">
        <h1>Login</h1>

        @error('name')
            <div class="errors" role="alert">{{ $message }}</div>
        @enderror

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <div class="field">
                <label class="field-label" for="name">Username</label>
                <input class="field-control" id="name" name="name" type="text"
                       value="{{ old('name') }}" required autofocus>
            </div>

            <div class="field">
                <label class="field-label" for="password">Password</label>
                <input class="field-control" id="password" name="password" type="password" required>
            </div>

            <button class="action-button action-button--save" type="submit">Masuk</button>
        </form>
    </div>
</body>
</html>