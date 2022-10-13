<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\MyAccountRequest;
use Illuminate\Support\Facades\Session;
class MyAccountController extends Controller
{
    //
    public function my_Account(){
        $this->authorize('member');
        $user = Auth::user()->id;

        return view('client.myAccount.my-account',compact('user'));
    }

    public function update_Account($id, MyAccountRequest $request){
        $this->authorize('member');
        $this->authorize('admin');
        try{
            $user = User::find($id);
            $user->fill($request->all());

            if($request->hasFile('avatar')){
                $path = $request->file('avatar')->move('storage/avatars', $request->file('avatar')->getClientOriginalName());
                $user->avatar =str_replace("public/", "public/", $path);
            }
            $user->save();
            Session::put('message','Cập nhật tài khoản thành công');
        }catch(\Exception $ex){
            Session::put('message','Cập nhật thất bại');
        }
        return redirect()->route('client.my-account');
    }
    
}
