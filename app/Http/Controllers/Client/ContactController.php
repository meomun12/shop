<?php

namespace App\Http\Controllers\Client;
use App\Mail\ContactMail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    //
    public function index(){
        return view('client.contact.index');
    }

    public function postcontact(Request $request){
        $this->authorize('member');
        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'title' => $request->title,
            'content' => $request->content,
        ];
        Mail::to('cuahangtaphoachucan@gmail.com')->send(new ContactMail($details));  
        return redirect()->back()->with('message','Gửi liên hệ thành công');
    }
    

}