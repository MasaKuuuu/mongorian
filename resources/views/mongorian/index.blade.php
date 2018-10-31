<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
    </head>
    <body>
        <h1>This is Mongorian</h1>
        <p>Create New Collection by MongoDB When you Upload CSV File</p>
        <form method="post" action="/mongorian_laravel/public/getData" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div>
                <input type="file" name="csvFile">
            </div>
            <div>
                <input type="submit" value="登録">
            </div>
        </form>
    </body>
</html>
