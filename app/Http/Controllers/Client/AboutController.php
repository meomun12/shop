<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    //trang giới thiệu (about)

    public function index(){
        $cates = Category::all();
        $about = About::all();
        $rating_pro = Product::all();
        $product = DB::table('products')->orderBy('views' , 'Desc' )->take(4)->get();
        return view('client.about.index', compact('about','product','rating_pro','cates'));
    }
}
