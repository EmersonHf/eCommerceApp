<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index(Request $request)
  {

    $products = Product::query();

    $products->when($request->search,function($query,$lv){
        $query->where('name','like','%'. $lv.'%');
    });
$products = $products->get();

    return view('home',[
        'products' => $products
    ]);
  }
}
