<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Brand;
use App\Product;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = Brand::where('active', 1)->orderBy('name')->paginate(25);
        $links = $brands->links();     
        return view ("Admin/brands/Index", ["brands" => $brands, 'links'=>$links]);
    }

    public function create()
    {
        return view ("Admin/brands/Form");
    }

    public function store(Request $request)
    {
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug_name = Str::of($brand->name)->slug('-');
        $brand->save();
        return redirect()->route("brands")->with('success','Excelente, registro guardado!');
    }

    public function detail($id)
    {
        $brand = Brand::where('id', $id)->first();
        $products = Product::where('brand_id', $id)->get();
        return view ("Admin/brands/Detail", ["brand" => $brand, "products"=>$products]);
    }

    public function delete($id)
    {
        if ($brand = Brand::where('id', $id)->first()){
            $brand->delete();
            return redirect()->route("brands")->with('success','Excelente, registro guardado!');
        } else {
            return redirect()->route("brands")->with('errors','Oops ocurrió un error!');
        }  
    }

    public function edit($id)
    {
        $brand = Brand::where('id', $id)->first();
        return view ("Admin/brands/Edit", ['brand' => $brand]);        
    }

    public function update (Request $request)
    {
        $brand = Brand::where('id', $request->id)->first();
        $brand->name = $request->nameEdit;
        $brand->update();
        return redirect()->route("brands")->with('success','Excelente, registro guardado!');
    }

}