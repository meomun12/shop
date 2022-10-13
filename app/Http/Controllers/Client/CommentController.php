<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
session_start();

class CommentController extends Controller
{
    //

    public function postComment(Request $request, $id){
        // $dt_create = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $dt_create = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
        $product = Product::find($id);
        $idProduct = $id;

        if($request -> ajax())
        {
            Rating::insert([
                'ra_product_id'  => $idProduct,
                'ra_content'     => $request->r_content,
                'ra_user_id'     => Auth::User()->id,
                'ra_number'      => $request->number,
                'created_at'     => $dt_create,
            ]);
        }
        
        $product->pro_total_number += $request->number;
        $product->pro_total_rating += 1;
        $product->save();

        return response()->json(['code' => '1']);
    }
    
}