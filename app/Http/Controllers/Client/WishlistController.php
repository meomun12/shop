<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    //
    public function add_wishlist($id){
        $this->authorize('member');
        $new_wishlist = new Wishlist();
        $new_wishlist->product_id = $id;
        $new_wishlist->user_id = Auth::user()->id;
        $new_wishlist->save();
        return back();
    }

    public function index(){
        $this->authorize('member');
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('H:i:s');
        $id_user = Auth::user()->id;
        $wish_lists = Wishlist::all()->where('user_id',$id_user);
        return view('client.wishlist.index', compact('wish_lists','today'));
    }

    public function remove_wishlist($id){
        $this->authorize('member');
        $id_destroy = Wishlist::find($id);
        $id_destroy->delete();

        return redirect()->back()->with('alert', 'Xóa thành công!');
    }
}
