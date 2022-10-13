<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class MyAccountRequest extends FormRequest
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
            'name' => 'required|',
            'email' => 'required|email',
            'phone'=>'required|digits:10',
            'address' => 'required',
            'avatar' => 'image',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Vui lòng điền Tên!',
            'email.required' => 'Vui lòng điền Email!',
            'email.email' => 'Email không hợp lệ!',
            'phone.required'=>'Vui lòng điền số điện thoại!',
            'phone.digits'=>'Vui lòng nhập số điện thoại có độ dài 10 ký tự !',
            'address.required' => 'Vui lòng điền địa chỉ',
            'avatar.image' => 'Ảnh phải đúng định dạng',
        ];
    }
}
