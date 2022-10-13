<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Rating;
use DB;
use Illuminate\Support\Facades\Session;
session_start();

class CommentController extends Controller
{
    //
    // public function index(Request $request){
    // /**
    //  * @throws \Illuminate\Auth\Access\AuthorizationException
    //  */
    public function index(){
        $this->authorize('admin');
        $user_comment = User::all();
        $product_comment = Product::all();
        $comment = Rating::all()->sortByDesc('id');
        return view('admin.comment.index', compact('user_comment','product_comment','comment'));
    }

    public function deleteComment($id){
        Rating::destroy($id);
        Session::put('message','Xoá bình luận thành công');
        return  redirect()->back();; 
    }
}
