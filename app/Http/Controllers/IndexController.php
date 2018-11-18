<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CsvData;

class IndexController extends Controller
{
    public function index(){
        // ドキュメントのdata_nameだけを抽出
        $documentDataNameListJson = CsvData::distinct()->get(['data_name']);
        $documentDataNameList = json_decode($documentDataNameListJson, true);
        $dataNameList = array();

        // ドキュメントのdata_nameだけのListを作成
        foreach($documentDataNameList as $key => $document){
            foreach($document as $key => $dataName){
                $dataNameList[] = $dataName;
            }
        }
        
        return view('mongorian.index',['dataNameList' => $dataNameList]);
    }
}
