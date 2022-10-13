<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(){
        $this->authorize('admin');
        $slider = Slider::paginate(5);
        return view('admin.slider.index', [
            'slider' => $slider
        ]);
    }
    public function addSlider(Request $request){
        $this->authorize('admin');
        $dataView = ['errs'=>[] ]; // mảng để truyền dữ liệu ra view
        if($request->isMethod('POST')){
            $rule = [
                'title' =>'required|min:6',
                'description' =>'required|min:1',
                'image'=>'required|image'            ];
            $msgE = [
                'title.required' =>'Bạn cần nhập Title',
                'title.min'=>'Title chỉ nhập từ 5 ký tự trở lên',
                'description.required' =>'Bạn cần nhập description',
                'image.required'=>'Không để trống ảnh của sản phẩm',
                'image.image'=>'Ảnh phải có đuôi là file(jpeg, png, bmp, gif, or svg)'            ];
            $validator = Validator::make($request->all(), $rule, $msgE);
            // check có lỗi hay không

            if ($validator->fails()) {

                $request->flash();
                return redirect()->route('admin.addSlider')->withErrors($validator);
            }
            else{
                // không có lỗi, ghi CSDL
                $slider = new Slider();
                $slider['title']= $request->get('title');
                $slider['description']= $request->get('description');
                if($request->hasFile('image')){
                    $path = $request->file('image')->move('frontend/slider', $request->file('image')->getClientOriginalName());
                    $slider['image'] =str_replace("public/", "public/", $path);
                }
            $slider->save();
            return redirect()->route('admin.listSlider');
            }
        }
        return view('admin.slider.addSlider');
    }
    public function destroy($id, Request $request){
        $this->authorize('admin');
        $dataView = [ 'errs'=>[]];
        $objU = Slider::where('id',$id)->first();
        $dataView['objU'] = $objU;
        if($request){
                $objU->delete();
                return redirect()->route('admin.listSlider');
            }
    }
    public function editSlider($id, Request $request){
        $this->authorize('admin');
        $dataView = ['errs'=>[] ];
        // lấy thông tin User để hiển thị ra form
        $objU = Slider::where('id',$id)->first();
        $dataView = $objU;
        $data = $_POST;
        if($request->isMethod('POST')){
            $rule = [
                'title' =>'required|min:6',
                'description' =>'required|min:1',
                'image'=>'image'            ];
            $msgE = [
                'title.required' =>'Bạn cần nhập Title',
                'title.min'=>'Title chỉ nhập từ 5 ký tự trở lên',
                'description.required' =>'Bạn cần nhập description',
                'image.image'=>'Ảnh phải có đuôi là file(jpeg, png, bmp, gif, or svg)'            ];
            // bắt đầu kiểm tra
            $validator = Validator::make($request->all(), $rule, $msgE);
            // check có lỗi hay không
            if($validator->fails()){
                  $request->flash();
                return redirect()->back()->withErrors($validator);
            }
            else{                   
                if($request->hasFile('image')){
                    $path = $request->file('image')->move('frontend/slider', $request->file('image')->getClientOriginalName());
                    $objU =str_replace("public/", "public/", $path);
                }
                $objU->fill($data);
                $objU->save();
                Session::put('message','Cập nhật thành công');
                return redirect()->route('admin.listSlider');
            }
        }
        return view('admin.slider.editSlider',compact('objU','dataView'));

    }
}
