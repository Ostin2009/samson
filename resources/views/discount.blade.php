
<html>
    <body>
        <h1>Привет</h1>

        <a href="{{ url('/discount/create') }}" class="btn btn-xs btn-info pull-right">Получить ссылку</a>

        @if($message)
            <h1>{{ $message }}</h1>
        @endif

        <form method="get" action="/discount/check" }}>
            @csrf
            <input type="text" id="code" name="code" class="form-control">

            <button type="submit">Проверить скидку</button>
        </form>

        // alternative: https://stackoverflow.com/questions/27298426/how-to-pass-get-parameters-to-laravel-from-with-get-method

        @if($answer)
            <h1>{{ $answer }}</h1>
        @endif
    </body>
</html>
