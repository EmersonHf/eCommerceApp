<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminProductController extends Controller
{
  public function index()
  {
    $products = Product::all();

    return view('admin.products',compact('products'));
  }


  //Mostrar a página de editar
  public function edit()
  {
    return view('admin.product_edit');
  }

  // Recebe requisição para dar update
  public function update()
  {

  }

  //mostar pagina de criar produto
  public function create()
  {
    return view('admin.product_create');
  }

  public function store(Request $request)
  {
    $input = $request->validate([
        'name'=>'string|required',
        'price'=>'string|required',
        'stock'=>'integer|nullable',
        'cover'=>'file|nullable',
        'description'=> 'string|nullable'
    ]);

    $input['slug'] = Str::slug($input['name']);
    if(!empty($input['cover']) && $input['cover']->isValid()){
      $file = $input['cover'];
      $path = $file->store('products');
      $input['cover'] = $path;

    }
    Product::create($input);

    return Redirect::route('admin.products');
  }



}
