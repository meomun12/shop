<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Http\Requests\ResetpasswordRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Illuminate\Contracts\Auth\Authenticatable;

class AuthController extends Controller
{
    //
    public function postLogin(LoginRequest $request)
    { 
        $remember = $request->has('remember_me');
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials,$remember)) {
            if(Auth::user()->status == 0){
                if(Auth::user()->role_id == 1){
                    return redirect()->route('client-admin'); 
                }else{
                    return redirect()->intended('');
                };
            }else{
                Auth::logout();  // xử lý logout
                Session::flush(); // xóa hết các session khác
                Session::put('message','Tài khoản của bạn đã bị khóa vui lòng đăng nhập bằng tài khoản khác');
                return redirect()->route('client.login.err');
            }  
        }
        return back()->withErrors([
            'msg' => 'Tài khoản/mật khẩu không đúng',
        ]);
    }
    public function login_form_err(request $request)
    { 
        return view('errors.403');
    }
    
    public function login_form(Request $request){
        return view('client.login-res.index');
    }
    public function Logout()
    {
        Auth::logout();  // xử lý logout
        Session::flush(); // xóa hết các session khác
        return redirect()->route('client.login'); // chuyển về trang đăng nhập
    }
    public function registration(RegistrationRequest $request){
        $data = $_POST;

        $user = new User();
        $user->fill($data);
        if($request->hasFile('avatar')){
            $path = $request->file('avatar')->store('public/avatars');
            $user->avatar = str_replace("public/", "storage/", $path);
        }
        $user->password= Hash::make($request->get('password'));
        $user->role_id = 0;
        $user->status = 0;
        
        $user->save();
        Session::put('message','Đăng kí thành công');
        return redirect()->route('client.login'); 
    }

    public function forgotpassword(Request $request){
                             
        return view('client.login-res.forgotpassword');
    }

    public function sendSmsToken(Request $request){
    $data = $request->all();
       $user = User::where('phone','=',$data['phone'])->get();
       foreach($user as $value){
           $id = $value->id;
       }
       if($user){
           $count_user = $user->count();
           if($count_user==0){
            return redirect()->back()->with('error','Số điện thoại chưa được đăng ký'); 
           }else{
            $token_random = Str::random(8);
            $user = User::find($id);
            $user->remember_token = $token_random;
            $user->save();
            $HostDomain = config('common.HostDomain_servesms');
            $key        = config('common.key_servesms');       
            $devices    = config('common.devices_servesms');
            $number     = $request->phone;
            $message    = "Mã OTP là : $token_random";
            $Api_SMS    = $HostDomain .'key=' . $key .'&number=' . $number .'&message='.$message.'&token_random='.$token_random. '&devices=' . $devices;
            $response   = Http::get($Api_SMS);
           }
       }
            return redirect()->route('client.resetpassword',['id' => $user->id]);   
    }

    public function resetpassword($id){
        $user = User::find($id);
        return view('client.login-res.resetpassword',compact('user')); 
    }
    public function resetpasswords($id, ResetpasswordRequest $request){
        $user = User::find($id);
        $data = $_POST;
        if($data['token'] == $user->remember_token){ 
            $user->password =Hash::make( $data['password']);
            $user->save();
        }else{
            Session::put('message','Sai mã OTP');
            return redirect()->back(); 
        }
        Session::put('message','Đổi mật khẩu thành công');
        return redirect()->route('client.login'); 
    }
}
