<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CsvData;
use App\Http\Requests\GetAllRequest;
class GetDataController extends Controller
{
    public function getAll(GetAllRequest $request){

        $json = CsvData::where('data_name',$request->dataName)->get();
        $columnList = array();
        $documents = json_decode($json, true);

        foreach ($documents as $key => $document) {
            $rowColumnList = array_keys($document);
            foreach ($rowColumnList as $key => $column) {
                // データのタイトルは表には出さない
                if($column != "data_name" && !in_array($column, $columnList)){
                    $columnList[] = $column;
                }else if($column == "data_name" && !in_array($column, $columnList)){
                    $dataName = $document[$column];
                }
            }
        }

        // Select 結果表示
        return view('mongorian.getComplete',['rows'=>$json, 'columnList' => $columnList, 'dataName' => $dataName]);
    }

    public function getSelect(GetRequest $request){

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
