<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' =>'required|min:6',
            'image'=>'image'                    ];
    }
    public function messages(){
        return [
                'name.required' =>'Bạn cần nhập Danh mục',
                'name.unique'=>'Danh mục đã tồn tại',
                'name.min'=>'Danh mục chỉ nhập từ 5 ký tự trở lên',
                'image.image'=>'Ảnh phải có đuôi là file(jpeg, png, bmp, gif, or svg)'
        ];
    }
}
