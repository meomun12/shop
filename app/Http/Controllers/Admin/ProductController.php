<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Rating;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

session_start();

class ProductController extends Controller
{

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request){
        $this->authorize('admin');
        $category = Category::all();
        $pro = Product::all()->sortByDesc('id');
        $gallery = Gallery::all();
        return view('admin.product.index',compact('gallery','pro','category'));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create_product(){
        $this->authorize('admin');
        $cates = Category::all();
        return view('admin.product.add-product', compact('cates'));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit_product($id){
        $this->authorize('admin');
        $cate_product = Category::all();
        $edit_product = DB::table('products')->where('id', $id)->get();
        $product_img = Gallery::all()->where('product_id',$id);
        return view('admin.product.edit-product', compact('cate_product','product_img','edit_product'));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deleteProduct($id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('admin');
        Product::destroy($id);
        Rating::where('ra_product_id', $id)->delete();
        DB::table('galleries')->where('product_id',$id)->delete();
        Session::put('message','Xoá sản phẩm thành công');
        return  redirect()->back();;
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function addProduct(ProductRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('admin');
        $dt_create = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
        $data = $_POST;
        $product = new Product();
        $product->fill($data);
        $product->create_at= $dt_create;
        $product->allow_market=isset($_POST['allow_market']) ? $_POST['allow_market'] : 1;
            $rule = ['image_gallery'=>'required|image'];
            $msgE = ['image_gallery.required'=>'Không để trống ảnh của sản phẩm',];
            $validator = Validator::make($request->all(), $rule, $msgE);
            if ($validator->fails()) {
                $request->flash();
                return redirect()->route('admin.addProduct')->withErrors($validator);
            }
        if($request->hasFile('image_gallery')){
            $path = $request->file('image_gallery')->move('frontend/images', $request->file('image_gallery')->getClientOriginalName());
            $product->image_gallery =str_replace("public/", "public/", $path);
        }
        $product->views = 1;
        $product->save();
        Session::put('message','Thêm sản phẩm thành công');
        return Redirect::to('/admin/products');
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateProduct(ProductRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('admin');
        $dt_update = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
        $product = Product::find($id);
        $data= $_POST;
        $product->fill($data);
        if($request->hasFile('image_gallery')){
            $path = $request->file('image_gallery')->move('frontend/images', $request->file('image_gallery')->getClientOriginalName());
            $product->image_gallery =str_replace("public/", "public/", $path);
        }
        $product->update_at= $dt_update;
        $product->allow_market=isset($_POST['allow_market']) ? $_POST['allow_market'] : 1;
        $product->views  +=1;
        $product->save();
        $product_id = $product->id;
        if($request->hasFile('gallery_img')){
            foreach($request->File('gallery_img') as $file){
            $product_img = new Gallery();
            if(isset($file)){
                $path = $file->move('frontend/images_gallery', $file->getClientOriginalName());
                $product_img->gallery_img =str_replace("public/", "public/", $path);
                $product_img->product_id = $product_id;
                $product_img->save();
            }
        }
        }
        Session::put('message','Cập nhật sản phẩm thành công');
        return Redirect::to('/admin/products');
    }
    public function show($id)
    {
        $Product = Product::find($id);
        return response()->json(['data'=>$Product],200); // 200 là mã lỗi
    }
    public function destroy($id)
    {
        Gallery::destroy($id);
        return response()->json(['data'=>'removed'],200);
    }
}


// Rating::where('ra_product_id', $id)->delete();