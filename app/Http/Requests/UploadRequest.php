<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->path() == 'postCSV'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dataName' => 'required',
            'csvFile' => 'required',
        ];
    }

    public function messages(){
        return [
            'dataName.required' => 'データ名を入力してください',
            'csvFile.required' => 'CSVファイルを選択してください'
        ];
    }
}
