<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use App\Http\Requests\UploadRequest;
use App\Models\CsvData;

class UploadController extends Controller
{
    public function postCSV(UploadRequest $request){
        if($request->hasFile('csvFile')){
            print ($request->csvFile->extension());
            if($request->csvFile->getClientOriginalExtension() != 'csv'){
                $err_msg = 'CSVファイルのみ対応しています。';
            }else{
                // ファイルをdataディレクトリに移動
                if($file = $request->csvFile->store('download')){
                    $fp = fopen("../storage/app/" .$file, "r");

                    // 配列に変換する
                    $isLoadFirstRow = false;
                    $firstRowColumnNum = 0;
                    $csvRowNum = 0;
                    $asins = array();
                    $csvDataRow = array();
                    while(($data = fgetcsv($fp, 0, ",")) !== FALSE){
                        // CSVデータの一行目からカラム名を取得しKEyに設定
                        if(!$isLoadFirstRow){
                            $asins[] = $data;
                            $firstRowColumnData = $data;
                            $isLoadFirstRow = true;
                            $firstRowColumnNum = count($asins[$firstRowColumnNum]);

                        // CSVデータの2行目以降からデータを取得しValueに設定後DBにインサート
                        }else{
                            $columnNum = 0;
                            $dataName = $request->dataName;
                            $csvDataRow = array_merge($csvDataRow, ['data_name' => $dataName]);
                            foreach($data as $key => $val){
                                $csvDataRow = array_merge($csvDataRow, [$firstRowColumnData[$columnNum] => $val]);
                                $columnNum++;
                                if($firstRowColumnNum < $columnNum){
                                    break;
                                }
                            }
                            $asins[] = $csvDataRow;
                            CsvData::insert($csvDataRow);
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

        $json = CsvData::where('data_name',$request->dataName)->get();
        $columnList = array();
        $documents = json_decode($json, true);

        foreach ($documents as $key => $document) {
            $rowColumnList = array_keys($document);
            foreach ($rowColumnList as $key => $column) {
                // データのタイトルは表には出さない
                if($column != "data_name" && !in_array($column, $columnList)){
                    $columnList[] = $column;
                }else if($column == "data_name" && !$dataName){
                    $dataName = $document[$column];
                }
            }
        }

        // Select 結果表示
        return view('mongorian.getComplete',['rows'=>$json, 'columnList' => $columnList, 'dataName' => $dataName]);
    }
}
