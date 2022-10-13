<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //
    public function index(){
        $this->authorize('admin');
        return view('admin.transaction.index');
    }
}
