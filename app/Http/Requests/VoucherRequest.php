<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'code' => 'required|min:5|max:11',
            'finish_date' => 'required',
            'amount' => 'required|min:1',
            'value' => 'required',
        ];
    }
    public function messages(){
        return [
            'name.required' => 'name không được để trống',
            'code.required' => 'Mã code không được để trống',
            'code.min'=>'Mã code có ít nhất 5 kí tự và nhiều nhất 11 kí tự',
            'code.max'=>'Mã code có ít nhất 5 kí tự và nhiều nhất 11 kí tự',
            'finish_date.required' => 'Ngày kết thúc trống',
            'value.required' => 'giá trị trống',
            'amount.required' => 'số lượng trống',
            'amount.min'=>'số lượng có ít nhất 1 kí tự',
        ];
    }
}

