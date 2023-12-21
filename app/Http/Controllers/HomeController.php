<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['categories']        = Category::where('is_show_home', 'Yes')->where('status', 1)->get();
        $data['products_featured'] = Product::where('is_featured', 1)->orderBy('id', 'desc')->limit(4)->get();
        return view('home', $data);
    }

    public function shop($categorySlug=null, $subcategorySlug=null)
    {
        $products = Product::latest()->where('status', 1);
        if($categorySlug){
            $category    = Category::where('slug', $categorySlug)->first();
            $category_id = empty($category) ? 0 : $category->id;
            $products    = $products->where('category_id', $category_id);
            $data['categoryName'] = $category->name;

            if($subcategorySlug) {
                $subcategory     = SubCategory::where('slug', $subcategorySlug)->first();
                $sub_category_id = empty($subcategory) ? 0 : $subcategory->id;
                $products        = $products->where('sub_category_id', $sub_category_id);
            }
        }
        $data['products'] = $products->paginate(12);
        return view('shop', $data);
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->with('product_images')->first();
        $relatedProducts = [];
        if ($product->related_products) {
            $productArr = explode(',', $product->related_products);
            $relatedProducts = Product::whereIn('id', $productArr)->get();
        }
        $data['product']         = $product;
        $data['relatedProducts'] = $relatedProducts;
        return view('product', $data);
    }

    public function category($slug)
    {
        $subcategory = SubCategory::where('slug', $slug)->with('category')->first();
        $products    = Product::where('sub_category_id', $subcategory->id)->paginate(12);
        $data['subcategory'] = $subcategory;
        $data['products']    = $products;
        return view('category', $data);
    }
}
