<!DOCTYPE html>
<html>
<head>
    <title>URL Kısaltıcı</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        input[type="text"] {
            padding: 10px;
            width: 300px;
            margin-bottom: 10px;
        }
        button {
            padding: 10px 20px;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
        .short-url {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🔗 URL Kısaltma Aracı</h2>
        <form method="POST" action="{{ route('shorten') }}">
            @csrf
            <input type="text" name="original_url" placeholder="Uzun URL’yi buraya yapıştırın" required>
            <br>
            <button type="submit">Kısalt</button>

            @error('original_url')
                <div class="error">{{ $message }}</div>
            @enderror

            @if(isset($short))
                <div class="short-url">
                    <strong>Kısa URL:</strong><br>
                    <a href="{{ $short }}" target="_blank">{{ $short }}</a>
                </div>
            @endif
        </form>
    </div>
</body>
</html>
