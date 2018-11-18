<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <script>
        window.onload = insertData;
        var jsonArray = new Array();
        var json = {};
        @foreach ($rows as $row)
            json = JSON.parse('{!!$row!!}');
            jsonArray.push(json);
        @endforeach

        function insertData(){
          // 既存の table 要素から tbody を取得する
          var thead = document.querySelector('table thead');
          var tbody = document.querySelector('table tbody');
          var tableColumnFlg = true;
          var columnRecode = document.createElement('tr');
          var columnId = new Array();
          var jsonKeyArray = new Array();
          var columnList = new Array();
          @foreach ($columnList as $column)
              columnList.push('{{$column}}');
          @endforeach

          // カラム追加
          thead.appendChild(columnRecode);
            columnList.forEach(function(column){
              if(column != "_id"){
                var th = document.createElement('th');
                th.innerText = column;
                th.id = column;
                columnRecode.appendChild(th);
              }
            })

          // tbody に tr を入れていく
          jsonArray.forEach(function (json) {
            // データ追加
            var record = document.createElement('tr');
            record.id = json['_id'];
            tbody.appendChild(record);
            var columnData = document.querySelectorAll('table thead tr th');
            columnData.forEach(function(columnId){
              var id = columnId.id;
              // データ追加
              if(id != "_id"){
                if(id in json){
                  var data = document.createElement('td');
                  data.innerHTML = "<a href='/getSelect?selectKeyword=" +json[id]+ "'>" +json[id]+ "</a>";
                  record.appendChild(data);
                }else{
                  var data = document.createElement('td');
                  data.innerHTML  = "<input type='text' name=" +id+ ">";
                  record.appendChild(data);
                }
              }
            })
          })
        }

        </script>
    </head>
    <body>
        <h1>This is Mongorian</h1>
        <p>UPDATE collection of fixed data</p>
        <form method="post" action="update">
          {{ csrf_field() }}
          <h2>{{$dataName}}</h2>
          <table class="table table-striped">
            <thead>
            </thead>
            <tbody>
            </tbody>
          </table>
          <div>
              <input type="submit" value="更新">
          </div>
        </form>
    </body>
</html>
