<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CsvData;
use App\Http\Requests\GetAllRequest;
use App\Http\Requests\GetSelectRequest;
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

    public function getSelect(GetSelectRequest $request){

        $json = CsvData::all();
        $columnList = array();
        $viewColumnList = array();
        $selectDocuments = array();
        $documents = json_decode($json, true);

        foreach ($documents as $key => $document) {
            $rowColumnList = array_keys($document);
            foreach ($rowColumnList as $key => $column) {
                if(!in_array($column, $columnList)){
                    $columnList[] = $column;
                }
            }
        }

        foreach($columnList as $key => $calumn){
            $json = CsvData::where($calumn, $request->selectKeyword)->get();
            // 画面にSELECT したデータを返す
            // if(json_decode($json, true)){
            //     $jsonList += $json;
            //     $selectDocuments = array_merge(json_decode($json, true));
            // }
        }

        foreach($selectDocuments as $key => $document){
            $selectColumnList = array_keys($document);
            foreach ($selectColumnList as $key => $column) {
                if(!in_array($column, $viewColumnList)){
                    $viewColumnList[] = $column;
                }
            }
        }

        // Select 結果表示
        return view('mongorian.getComplete',['rows'=>$jsonList, 'columnList' => $viewColumnList]);
    }
}
