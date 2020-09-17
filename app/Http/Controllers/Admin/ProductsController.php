<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Brand;
use App\Offer;
use App\Highlighted;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $paginate = ($request->fromOrder != null) ? 10 : 25 ;
        $search = $request->search;
        $products = Product::where('id', '>', 0);
        if ($search != ''){
            $products = $products->search($search)->orderBy('name')->paginate($paginate);
            $links = $products->appends(['search' => $search])->links();
        } else {
            $products = $products->orderBy('name')->paginate($paginate); 
            $links = $products->links();     
        }
        if ($request->fromOrder != null){
            return view('Admin/orders/ProductOrderSearch', ['products' => $products, 'search' => $search, 'links'=>$links]);
        } else {
            return view('Admin/products/Index', ['products' => $products, 'search' => $search, 'links'=>$links]);
        }
    }

    public function create()
    {
        $categories = Category::where('active', 1)->orderBy('name')->get();
        $brands = Brand::where('active', 1)->orderBy('name')->get();
        return view("Admin/products/Form", ['brands' => $brands, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'presentations' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'presentations' => 'required',
            'image' => 'mimes:jpeg,png|max:1024',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $product = new Product();
            $product->name = $request->name;
            $product->slug_name = '-';
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->description = $request->description;
            $product->presentations = json_decode($request->presentations, true);
            $product->celiacs = data_get($request, 'celiacs', 0);
            $product->organic = data_get($request, 'organic', 0);
            $product->agroecological = data_get($request, 'agroecological', 0);
            $product->vegan = data_get($request, 'vegan', 0);  
            if($request->hasFile('image')) {
                $extension = $request->image->extension();
                $product->photo = Str::of($product->name)->slug('-').".".$extension;
                $request->image->storeAs('/images/products', $product->photo, 'public');
            }
            $stock = 0;
            $product->offer = 0;
            $product->highlighted = 0;
            foreach ($product->presentations as $presentation) {
                $stock += $presentation['stock'];
                if ($presentation['offer'] == true) {
                    $product->offer = 1;
                }
                if ($presentation['highlighted'] == true) {
                    $product->highlighted = 1;
                }
                if ($presentation['main'] == true) {
                    $product->price = $presentation['price'];
                    $product->promo_price = ($presentation['promo_price'] > 0) ? $presentation['promo_price'] : null;
                }
            }
            $product->stock = $stock != 0 ? 1 : 0;
            $product->save();
            $product->slug_name = Str::of($product->name)->slug('-') . '-' . $product->id;
            $product->save();
            return redirect()->route("products")->with('success', 'Excelente, registro guardado!');
        }
    }

    public function detail($id)
    {
        $product = Product::where('id', $id)->first();
        return view("Admin/products/Detail", ["product" => $product]);
    }

    public function delete($id)
    {
        if ($product = Product::where('id', $id)->first()) {
            $product->delete();
            return redirect()->route("products")->with('success', 'Excelente, registro guardado!');
        } else {
            return redirect()->route("products")->with('errors', 'Oops ocurrió un error!');
        }
    }

    public function edit($id)
    {
        $categories = Category::where('active', 1)->orderBy('name')->get();
        $brands = Brand::where('active', 1)->orderBy('name')->get();
        if (\Illuminate\Support\Facades\Request::old('name') == '') {
            $product = Product::where('id', $id)->first();
        } else {
            $product = new Product();
            $product->id = $id;
            $product->name = \Illuminate\Support\Facades\Request::old('name');
            $product->slug_name = \Illuminate\Support\Facades\Request::old('slug_name');
            $product->category_id = \Illuminate\Support\Facades\Request::old('category_id');
            $product->brand_id = \Illuminate\Support\Facades\Request::old('brand_id');
            $product->description = \Illuminate\Support\Facades\Request::old('description');
            $product->presentations = json_decode(\Illuminate\Support\Facades\Request::old('presentations'));
            $product->celiacs = \Illuminate\Support\Facades\Request::old('celiacs') != null ? '1' : '0';
            $product->organic = \Illuminate\Support\Facades\Request::old('organic') != null ? '1' : '0';
            $product->agroecological = \Illuminate\Support\Facades\Request::old('agroecological') != null ? '1' : '0';
            $product->vegan = \Illuminate\Support\Facades\Request::old('vegan') != null ? '1' : '0';
        }
        return view("Admin/products/Edit", ['product' => $product, 'brands' => $brands, 'categories' => $categories]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'presentations' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'presentations' => 'required',
            'image' => 'mimes:jpeg,jpg,png|max:1024',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $product = Product::where('id', $request->input('productId'))->first();
            $product->name = $request->input('name');
            $product->slug_name = '-';
            $product->category_id = $request->input('category_id');
            $product->brand_id = $request->input('brand_id');
            $product->description = $request->input('description');
            $product->presentations = json_decode($request->presentations, true);
            $product->celiacs = data_get($request, 'celiacs', 0);
            $product->organic = data_get($request, 'organic', 0);
            $product->agroecological = data_get($request, 'agroecological', 0);
            $product->vegan = data_get($request, 'vegan', 0);
            if($request->hasFile('image')) {
                $extension = $request->image->extension();
                $product->photo = Str::of($product->name)->slug('-').".".$extension;
                $request->image->storeAs('/images/products', $product->photo, 'public');
            }
            $stock = 0;
            $product->offer = 0;
            $product->highlighted = 0;
            foreach ($product->presentations as $presentation) {
                $stock += $presentation['stock'];
                if ($presentation['offer'] == true) {
                    $product->offer = 1;
                }
                if ($presentation['highlighted'] == true) {
                    $product->highlighted = 1;
                }
                if ($presentation['main'] == true) {
                    $product->price = $presentation['price'];
                    $product->promo_price = ($presentation['promo_price'] > 0) ? $presentation['promo_price'] : null;
                }
            }
            $product->stock = $stock != 0 ? 1 : 0;
            $product->slug_name = Str::of($product->name)->slug('-') . '-' . $product->id;
            $product->save();
            return redirect()->route("products")->with('success', 'Excelente, registro guardado!');
        }
    }

    public function highlightedProducts()
    {
        $highlightedProducts = Product::where('highlighted', 1)->get();
        $highlightedSelected = Highlighted::where('id', '!=', '')->get();
        return view('Admin/products/Highlighted', ['highlightedProducts' => $highlightedProducts, 'highlightedSelected' => $highlightedSelected]);
    }

    public function offerProducts()
    {
        $offerProducts = Product::where('offer', 1)->get();
        $offerSelected = Offer::where('id', '!=', '')->get();
        return view('Admin/products/Offer', ['offerProducts' => $offerProducts, 'offerSelected'=>$offerSelected]);
    }

    public function offerSelected($ids)
    {
        Offer::all();
        Offer::query()->truncate();
        $arrids = explode(",", $ids);
        foreach ($arrids as $i => $id) {
            $eachOffer = new Offer();
            $eachOffer->product_id = $id;
            $eachOffer->presentation_name = '';
            $product = Product::where('id', $id)->first();
            $presentations = $product->presentations;
            foreach ($presentations as $pres) {
                if ($pres['offer'] == 1) {
                    $eachOffer->presentation_name = $pres['presentation'];
                }
            }
            $eachOffer->order_num = $i;
            $eachOffer->save();
        }
        return redirect()->back();
    }

    public function highlightedSelected($ids)
    {
        Highlighted::all();
        Highlighted::query()->truncate();
        $arrids = explode(",", $ids);
        foreach ($arrids as $i => $id) {
            $eachHighlighted = new Highlighted();
            $eachHighlighted->product_id = $id;
            $eachHighlighted->order_num = $i;
            $eachHighlighted->presentation_name = '';
            $product = Product::where('id', $id)->first();
            $presentations = $product->presentations;
            foreach ($presentations as $pres) {
                if ($pres['highlighted'] == 1) {
                    $eachHighlighted->presentation_name = $pres['presentation'];
                }
            }
            $eachHighlighted->save();
        }
        return redirect()->back();
    }

    public function stock()
    {
        $brands = Brand::where('active', 1)->orderBy('name')->get();
        return view('Admin/products/Stock', ['brands' => $brands]);
    }

    public function stockPerBrand(Request $request)
    {
        $products = Product::where('brand_id', $request->brand_id)->get();
        $nuevoProducts = [];
        foreach ($products as $product){
            foreach ($product->presentations as $presentation){
                $nuevoProducts[] = [
                    'id'=> $product->id,
                    'name'=> $product->name,
                    'presentation'=> $presentation['presentation'],
                    'stock'=> $presentation['stock'],
                ];
            }
        }
        $nuevoProducts = collect($nuevoProducts)->sortBy('stock');
        return view('Admin/products/ProductStock', ['nuevoProducts'=>$nuevoProducts]);
    }

    public function deleteImage($product_id)
    {
        $product = Product::where('id', $product_id)->first();
        $product->photo = null;
        $product->update();
        return back()->withInput();
    }
   
}
