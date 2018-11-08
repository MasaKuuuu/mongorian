<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <script>
        window.onload = insertData;

        @foreach ($rows as $row)
        console.log('{!!$row!!}');
            var json = JSON.parse('{!!$row!!}');
        @endforeach

        function insertData(){
            // 既存の table 要素から tbody を取得する
          var tbody = document.querySelector('table tbody')

          // tbody に tr を入れていく
          json.forEach(function (row) {
            console.log(row);
            var column1 = document.createElement('td')
            column1.innerText = row.column1

            var column2 = document.createElement('td')
            column2.innerText = row.column2

            var tr = document.createElement('tr')
            tr.appendChild(column1)
            tr.appendChild(column2)

            tbody.appendChild(tr)
          })
        }

        </script>
    </head>
    <body>
        <h1>This is Mongorian</h1>
        <p>Create New Collection by MongoDB When you Upload CSV File</p>
        @foreach ($rows as $row)
            {{$row}},
        @endforeach
        <table>
          <thead>
            <tr><th>column1</th><th>column2</th></tr>
          </thead>
          <tbody>
          </tbody>
        </table>

        <form method="post" action="/getData" enctype="multipart/form-data">
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
