<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body>
        <h1>This is Mongorian</h1>
        <h2>1. Create New Collection by MongoDB When you Upload CSV File</h2>
        @if ($errors->has('csvFile'))
        <p style="color: red">{{$errors->first('csvFile')}}</p>
        @endif
        @if ($errors->has('dataName'))
        <p style="color: red">{{$errors->first('dataName')}}</p>
        @endif
        <form method="post" action="/postCSV" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div>
                CSV File<input type="file" name="csvFile">
            </div>
            <div>
                Data Name<input type="text" name="dataName">
            </div>
            <div>
                <input type="submit" value="登録">
            </div>
        </form>

        <h2>2. View Collection by MongoDB</h2>
        <form method="post" action="/getAll">
            {{ csrf_field() }}
            <div>
            Data Name
                <select name = "dataName">
                    @foreach ($dataNameList as $dataName)
                    <option value="{!!$dataName!!}">{{$dataName}}</option>
                    @endforeach
                </select>
            </div>
            <div>
            <input type="submit" value="表示">
            </div>
        </form>
    </body>
</html>
