<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CsvData;
use App\Http\Requests\GetRequest;
class GetDataController extends Controller
{
    public function get(GetRequest $request){



        $json = CsvData::where('data_name',$request->dataName)->get();
        $columnList = array();
        $documents = json_decode($json, true);

        foreach ($documents as $key => $value) {
            $rowColumnList = array_keys($value);
            foreach ($rowColumnList as $key => $value) {
                // データのタイトルは表には出さない
                if($value != "data_name" && !in_array($value, $columnList)){
                    $columnList[] = $value;
                }
            }
        }

        // Select 結果表示
        return view('mongorian.getComplete',['rows'=>$json, 'columnList' => $columnList]);
    }
}
