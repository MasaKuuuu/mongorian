<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;


class GetDataController extends Controller
{
    public function get(Request $request){
        // DB接続
$manager = new MongoDB\Driver\Manager("mongodb://127.0.0.1:27017");

// Insert
$bulk = new MongoDB\Driver\BulkWrite;

if(is_uploaded_file($_FILES["csvFile"]["tmp_name"])){
    $file_tmp_name = $_FILES["csvFile"]["tmp_name"];
    $file_name = $_FILES["csvFile"]["name"];

    if(pathinfo($file_name, PATHINFO_EXTENSION) != 'csv'){
        $err_msg = 'CSVファイルのみ対応しています。';
    }else{
        //ファイルをdataディレクトリに移動
        if(move_uploaded_file($file_tmp_name, "csvFiles/" . $file_name)){
            $file = "csvFiles/" .$file_name;
            $fp = fopen($file, "r");

            //配列に変換する
            $isLoadFirstRow = false;
            $firstRowColumnNum = 0;
            $csvRowNum = 0;
            $asins = array();
            $csvDataRow = array();
            while(($data = fgetcsv($fp, 0, ",")) !== FALSE){
                //一行目を読み込んでいればkeyを設定する
                if($isLoadFirstRow){
                    $columnNum = 0;
                    foreach($data as $key => $val){
                        $csvDataRow = array_merge($csvDataRow, [$firstRowColumnData[$columnNum] => $val]);
                        $columnNum++;
                        if($firstRowColumnNum < $columnNum){
                            break;
                        }
                    }
                    $asins[] = $csvDataRow;
                    $bulk->insert($csvDataRow);
                    $manager->executeBulkWrite('study.test', $bulk);
                }else{
                    $asins[] = $data;
                    $firstRowColumnData = $data;
                    $isLoadFirstRow = true;
                    $firstRowColumnNum = count($asins[$firstRowColumnNum]);
                }
                $csvRowNum++;
            }
            fclose($fp);
        }else{
            $err_msg = "ファイルをアップロードできませんでした";
        }
    }
}else{
    $err_msg = "ファイルが選択されていません";
}
//var_dump($asins);

// Select
//$filter = ['address' => ['$gt' => 'tokyo']]; // where句
$filter = [];
$options = [
  'projection' => ['_id' => 0],
  'sort' => ['_id' => -1],
];
$query = new MongoDB\Driver\Query($filter, $options);
$cursor = $manager->executeQuery('study.test', $query);

// Select 結果表示
//foreach ($cursor as $document) {
//    var_dump($document);
//}
        return view('mongorian.getComplete');
    }
}
