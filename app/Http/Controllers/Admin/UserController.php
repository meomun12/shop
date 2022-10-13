<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
class UserController extends Controller
{
    //
    public function index(){    
        $this->authorize('admin');
        $user = User::all();
        return view('admin.user.index',compact('user'));
    }

    public function create_user(Request $request){
        $this->authorize('admin');
        $dataView = ['errs'=>[] ]; // mảng để truyền dữ liệu ra view

        if($request->isMethod('POST')){
            $rule = [
                'name'=>'required',
                'avatar'=>'required|image',
                'role_id'=>'required',
                'email'=>'required|email|max:255|unique:users',
                'phone'=>'required|digits:10|numeric',
                'status'=>'required|min:1',
                'address'=>'required',
                'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{6,}$/',
                'password-confirm'=>'requied|min4',
                ];
            $msgE = [
                'name.required' =>'Bạn cần nhập Tên tài khoản',
                'avatar.required'=>'Không để trống ảnh của user',
                'avatar.image'=>'Ảnh phải có đuôi là file(jpeg, png, bmp, gif, or svg)',
                'role_id.required'=>'Chọn trạng thái hoạt động',
                'email.required'=>'Vui lòng nhập Email',
                'email.unique'=>'Email đã tồn tại',
                'phone.required'=> 'Nhập số điện thoại',
                'phone.digits'=> 'Nhập số điện thoại có 10 chữ số',
                'status.required'=>'Chọn trạng thái',
                'password.required' => 'Bạn cần nhập mật khẩu ',
                'password.min'=>'Mật khẩu phải có chữ hoa chữ thường và số từ 6 đến 16 kí tự',
                'password.max'=>'Mật khẩu phải có chữ hoa chữ thường và số từ 6 đến 16 kí tự',
                'password.regex' => 'Mật khẩu phải có chữ hoa chữ thường và số  từ 6 đến 16 kí tự',
                'password.confirmed'=>'mật khẩu không trùng khớp',
                'status.min'=>'Chọn trạng thái',
                'address.required'=>'Bạn cần nhập địa chỉ',
                
                ];
            $validator = Validator::make($request->all(), $rule, $msgE);
            // check có lỗi hay không

            if ($validator->fails()) {
                $request->flash();
                return redirect()->route('admin.addUser')->withErrors($validator);
            }
            else{
                // không có lỗi, ghi CSDL
                $user = new user();
                $user->fill($request->all());
                $user->password= Hash::make($request->get('password'));
                if($request->hasFile('avatar')){
                    $path = $request->file('avatar')->move('storage/avatars', $request->file('avatar')->getClientOriginalName());
                    $user->avatar =str_replace("public/", "public/", $path);
                }
            $user->Save();
            Session::put('message','Thêm tài khoản thành công');
            return redirect()->route('admin.listUser');
            }
        }

        return view('admin.user.add-user');
    }

    public function edit_user($id, Request $request){
        $this->authorize('admin');
        $objU = User::find($id);
        $this->authorize('admin');
        return view('admin.user.edit-user',compact('objU'));
    }
    public function updateUser($id,UserRequest $request){
        $this->authorize('admin');
        try{
            $user = User::find($id);

                $user->fill($request->all());
                $user->password= Hash::make($request->get('password'));

            if($request->hasFile('avatar')){
                $path = $request->file('avatar')->move('storage/avatars', $request->file('avatar')->getClientOriginalName());
                $user->avatar =str_replace("public/", "public/", $path);
            }
            $user->save();
            Session::put('message','Cập nhật tài khoản thành công');
        }catch(\Exception $ex){
            Session::put('message','Cập nhật thất bại');
        }

        return redirect()->route('admin.listUser');
    }   
    public function destroy($id)
    {        $this->authorize('admin');

        $User = User::find($id);
        $User->delete();
        return back();
    }
}