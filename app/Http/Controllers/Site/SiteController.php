<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use App\Offer;
use App\Highlighted;
use \Illuminate\Http\Request;
use \Illuminate\Pagination\LengthAwarePaginator;


class SiteController extends Controller
{
    public function index()
    {
        $categories = Category::where('active', 1)->get();
        $offer = Offer::all()->pluck('product_id');
        $offer_products = Product::whereIn('id', $offer)->paginate(4);
        $highlighted = Highlighted::all()->pluck('product_id');
        $highlighted_products = Product::whereIn('id', $highlighted)->paginate(3);
        return view('Site/index', [
            'highlighted_products'=>$highlighted_products, 
            'offer_products'=>$offer_products, 
            'categories'=>$categories]);
    }

    public function detailProduct($slug_name)
    {
        $product = Product::where('slug_name', $slug_name)->first();
        $presentations = $product->presentations;
        return view('Site/detailProduct', ['product'=>$product, 'presentations'=>$presentations]);
    }
    
   public function products($criteria, $slug_name, Request $request)
    {
        $categories = Category::where('active', 1)->get();
        if ($request->items){
            $request->session()->put('items', $request->items);
        } else {
            if (!$request->session()->has('items')){
                if ($criteria == 'category'){
                    $request->session()->put('items', 9);
                } else {
                    $request->session()->put('items', 12);
                } 
            }
        }
        if ($request->order){
            $order = explode(',', $request->order);
            $request->session()->put('orderField', $order[0]);
            $request->session()->put('orderDirection', $order[1]);
        } else {
            if (!$request->session()->has('orderField')) {
                $request->session()->put('orderField', 'price');
                $request->session()->put('orderDirection', 'asc');
            }
        }
        $products = Product::where('active', 1);
        if ($criteria == 'type'){
            $types['organic'] = ['title'=>'orgánicos', 'type_icon'=>'organicos.png'];     
            $types['celiacs'] = ['title'=>'sin tacc', 'type_icon'=>'celiacs.png'];
            $types['agroecological'] = ['title'=>'agroecológicos', 'type_icon'=>'agroecologicos.png'];
            $types['vegan'] = ['title'=>'veganos', 'type_icon'=>'veganos.png'];   
            $title = $types[$slug_name];
            $products = $products->where($slug_name, 1);
            $colmd = 3;
            $cols = 4;
        } 
        if ($criteria == 'search'){
            $title = [];
            $title = ['title'=>'buscador: '.$request->search, 'type_icon'=>0];
            $products = $products->search($request->search);
            $colmd = 3;
            $cols = 4;
        } 
        if ($criteria == 'category'){
            $category = Category::where('slug_name', $slug_name)->first();
            $title = ['title'=>$category->name, 'type_icon'=>0];
            $products = $products->where('category_id', $category->id);
            $colmd = 4;
            $cols = 3;
            $categories = Category::where('active', 1)->orderBy('name')->get();
        }
        $products = $products->orderBy(session('orderField'), session('orderDirection'));
        $products = $products->paginate(session('items') * $cols);
        
        return view('Site/productsList', [
            'products'=>$products, 
            'items'=>session('items'), 
            'order'=>session('orderField').','.session('orderDirection'), 
            'title'=>$title, 
            'categories'=>$categories,
            'colmd'=>$colmd,
            'search'=>$request->search,
        ]); 
    }
   
}