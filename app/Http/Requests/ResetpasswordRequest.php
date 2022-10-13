<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetpasswordRequest extends FormRequest
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
            'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{6,}$/',
        ];
    }
        public function messages(){
            return [
                
                    'password.required' => 'Bạn cần nhập mật khẩu ',
                    'password.min'=>'Mật khẩu phải có chữ hoa chữ thường và số từ 6 đến 16 kí tự',
                    'password.max'=>'Mật khẩu phải có chữ hoa chữ thường và số từ 6 đến 16 kí tự',
                    'password.regex' => 'Mật khẩu phải có chữ hoa chữ thường và số  từ 6 đến 16 kí tự',
                    
            ];
        }
    
}
