<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            display: grid;
            min-height: 100vh;
            margin: 0;
            place-items: center;
            background-color: #1c0f30;
            font-family: sans-serif;
        }

        .form {
            box-sizing: border-box;
            width: min(100% - 32px, 400px);
            padding: 32px;
            background-color: white;
        }

        h1 {
            text-align: center;
        }

        form {
            display: grid;
            gap: 16px;
        }

        .field {
            display: grid;
            gap: 6px;
        }

        input,
        button {
            box-sizing: border-box;
            width: 100%;
            padding: 10px;
        }

        .error {
            color: #b00020;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="form">
        <h1>LOGIN</h1>

        @error('name')
            <p class="error" role="alert">{{ $message }}</p>
        @enderror

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <div class="field">
                <label for="name">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
            </div>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>