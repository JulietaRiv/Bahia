<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::where('active', 1)->orderBy('name')->paginate(25);
        $links = $categories->links();
        return view ("Admin/categories/Index", ["categories" => $categories, 'links'=>$links]);
    }

    public function create()
    {
        return view ("Admin/categories/Form");
    }

    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->slug_name = Str::of($category->name)->slug('-');
        $category->save();
        return redirect()->route("categories")->with('Excelente, registro guardado!');
    }

    public function detail($id)
    {
        $category = Category::where('id', $id)->first();
        $products = Product::where('category_id', $id)->get();
        return view ("Admin/categories/Detail", ["category" => $category, 'products'=>$products]);
    }

    public function delete($id)
    {
        if ($category = Category::where('id', $id)->first()){       
            $category->delete();
            return redirect()->route("categories")->with('success','Excelente, registro guardado!');
        } else {
            return redirect()->route("categories")->with('errors','Oops ocurrió un error!');
        }  
    }

    public function edit($id)
    {
        $category = Category::where('id', $id)->first();
        return view ("Admin/categories/Edit", ['category' => $category]);        
    }

    public function update(Request $request)
    {
        $category = Category::where('id', $request->id)->first();
        $category->name = $request->nameEdit;
        $category->slug_name = Str::of($category->name)->slug('-');
        $category->update();
        return redirect()->route("categories")->with('success','Excelente, registro guardado!');
    }

}