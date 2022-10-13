<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index(){
        $wish_lists = Wishlist::all()->sortByDesc('id');
        return view('admin.wishlist.index', compact('wish_lists'));
    }
}
