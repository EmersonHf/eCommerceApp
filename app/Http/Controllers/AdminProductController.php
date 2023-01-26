<?php
namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;


class AdminProductController extends Controller
{

    //lista os produtos
  public function index()
  {
    $products = Product::all();

    return view('admin.products',compact('products'));
  }


    //mostar pagina de criar produto
    public function create()
    {
    return view('admin.product_create');
    }

//cria o produto
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

        $path = $file->store('public');

         $input['cover'] = $path;

      }
      Product::create($input);

      return Redirect::route('admin.products');
    }




  //Mostrar a página de editar
  public function edit(Product $product)
  {
    return view('admin.product_edit',[
        'product' => $product
    ]);
  }

  // Recebe requisição para dar update
  public function update(Product $product, Request $request)
  {
    $input = $request->validate([
        'name'=>'string|required',
        'price'=>'string|required',
        'stock'=>'integer|nullable',
        'cover'=>'file|nullable',
        'description'=> 'string|nullable'
    ]);
    if(!empty($input['cover']) && $input['cover']->isValid()){
        Storage::delete($product->cover ?? '');
        $file = $input['cover'];
        $path = $file->store('public');
        $input['cover'] = $path;

      }
    $product->fill($input);
    $product->save();
    return Redirect::route('admin.products');
  }


    public function destroy(Product $product){
    $product ->delete();

    return Redirect::route('admin.products');
    }

public function destroyImage(Product $product){


    Storage::delete($product->cover);
    $product->cover = null;

    $product->save();

    return Redirect::back();

}

}
