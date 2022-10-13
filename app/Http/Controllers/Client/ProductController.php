<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(){
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('H:i:s');
        $list_product = Product::paginate(12);
        $pro = Product::all();
        $cates  = Category::all();
        return view('client.product.index', compact('list_product','pro','cates','today'));
    }

    public function shops(){
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('H:i:s');
        $list_product = Product::where('allow_market','1')->paginate(12);
        $cates  = Category::all();        
        $pro = Product::all()->where('allow_market','1');
        return view('client.product.index', compact('list_product','pro','cates','today'));
    }

    public function allow_market(){
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('H:i:s');
        $list_product = Product::where('allow_market','2')->paginate(12);
        $cates  = Category::all();
        $pro = Product::all()->where('allow_market','2');
        return view('client.product.index', compact('list_product','cates','today','pro'));
    }

    public function cate_product($id){
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('H:i:s');
        $list_product= Product::where('category_id',$id)->paginate(12);
        $cates  = Category::all();
        $pro = Product::all()->where('allow_market','1');
        return view('client.product.index', compact('list_product','pro','cates','today'));
    }

    
    public function single_Product($id){
        $product= Product::find($id);
        // comment
        
        $comments = Rating::where('ra_product_id', $id)->get();
        $product->views += 1;
        $product->save();
        // thống kê số lượt đánh giá
        $ratingsDashboard = Rating::groupBy('ra_number')
        ->where('ra_product_id',$id)
        ->select(DB::raw('count(ra_number) as total'),DB::raw('sum(ra_number) as sum'))
        ->addSelect('ra_number')
        ->get()->toArray();

        
        $arrayRatings = [];
        if(!empty($ratingsDashboard)){
            for($i = 1; $i <= 5; $i++){
                $arrayRatings[$i] = [
                    "total" => 0,
                    "sum"   => 0,
                    "ra_number" => 0
                ];
                foreach($ratingsDashboard as $item){
                    if($item['ra_number'] == $i){
                        $arrayRatings[$i] = $item;
                        continue;
                    }
                }
            }
        }
        $id_cate = $product->category_id;
        $related_pro = Product::all()->where('category_id', $id_cate)->except($id);
        $img_url = Gallery::all()->where('product_id', $id);
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('H:i:s');
        return view('client.product.single-product',compact('product','img_url','related_pro','comments','arrayRatings','today'));
    }
}
