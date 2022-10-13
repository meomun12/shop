<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
class CategoryController extends Controller
{
    //
    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(){
        $this->authorize('admin');
        $cates = Category::all();
        $cates->load([
            'products'
        ]);

        return view('admin.category.index', [
            'category' => $cates
        ]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function addCategory(Request $request){
        $this->authorize('admin');
        if($request->isMethod('POST')){
            $rule = [
                'name' =>'required|unique:categories|min:6',
                'image'=>'required|image'            ];
            $msgE = [
                'name.required' =>'Bạn cần nhập Danh mục',
                'name.unique'=>'Danh mục đã tồn tại',
                'name.min'=>'Danh mục chỉ nhập từ 5 ký tự trở lên',
                'image.required'=>'Không để trống ảnh của Danh mục',
                'image.image'=>'Ảnh phải có đuôi là file(jpeg, png, bmp, gif, or svg)'
            ];
            $validator = Validator::make($request->all(), $rule, $msgE);

            if ($validator->fails()) {
                $request->flash();
                return redirect()->route('admin.addCate')->withErrors($validator);
            }
            else{
            $category = new Category();
            $category->fill($request->all());
            if($request->hasFile('image')){
                $path = $request->file('image')->move('frontend/image_cate', $request->file('image')->getClientOriginalName());
                $category->image =str_replace("public/", "public/", $path);
            }
            $category->save();
            Session::put('message','Thêm danh mục thành công');
            return redirect()->route('admin.listCate');
            }
        }
        return view('admin.category.addCate');
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit_category($id, Request $request){
        $this->authorize('admin');
        $dataView = ['errs'=>[] ];
        $objU = Category::where('id',$id)->first();
        return view('admin.category.editCate',compact('objU','dataView'));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update_category(CategoryRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('admin');
        $Category = Category::find($id);
        $Category->fill($request->all());
        if($request->hasFile('image')){
            $path = $request->file('image')->move('frontend/image_cate', $request->file('image')->getClientOriginalName());
            $Category->image =str_replace("public/", "public/", $path);
        }
        $Category->save();
        Session::put('message','Cập nhật danh mục thành công');
        return redirect()->route('admin.listCate');
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id, Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('admin');
        $dataView = [ 'errs'=>[]];
        // lấy thông tin cate để hiển thị ra form
        $objU = category::where('id',$id)->first();
        $dataView['objU'] = $objU;
        if($request){
                $objU->delete();
                Session::put('message','Xóa danh mục thành công');
                return redirect()->route('admin.listCate');
            }
    }


}
