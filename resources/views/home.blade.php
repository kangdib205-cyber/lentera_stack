<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Halaman Home</h1>

    <p>Ini contoh tampilan MVC sederhana di Laravel.</p>

    @if ($posts->isEmpty())
        <p>Tidak ada post tersedia.</p>
    @else
        <ul>
            @foreach ($posts as $post)
                <li><strong>{{ $post->title }}</strong>: {{ $post->body }}</li>
            @endforeach
        </ul>
    @endif
</body>
</html>
