<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductImageController extends Controller
{
    public function index($slug)
    {
        $product = Product::where('slug', $slug)->with('product_images')->first();
        if (empty($product)) {
            return redirect()->route('admin.product');
        }
        $data['product']       = $product;
        $data['productImages'] = $product->product_images;
        return view('admin.product.image', $data);
    }

    public function store($slug, Request $request)
    {
        $product = Product::where('slug', $slug)->first();
        if (empty($product)) {
            return redirect()->route('admin.product.image');
        }

        $request->validate(['image' => 'required|image|mimes:png,jpg,jpeg|max:1024']);

        $image    = $request->file('image');
        $path     = public_path('uploads/products');
        $filename = $product->sku  . '-' . date('YmdHis') . '.' . $image->getClientOriginalExtension();

        $request->image->move($path, $filename);

        // Create image thumbnail
        $pathFile      = $path.'/'.$filename;
        $pathFileThumb = $path.'/thumb/'.$filename;

        $img = Image::make($pathFile);
        $img->resize(300, 300);
        $img->save($pathFileThumb);

        ProductImage::create([
            'product_id' => $product->id,
            'image' => $filename,
        ]);

        return redirect()->route('admin.product.image', $product->slug)->with('success', 'Image uploaded successfully');
    }

    public function destroy($id)
    {
        $productImage = ProductImage::find($id);

        $product = Product::where('id', $productImage->product_id)->first();

        if (empty($productImage)) {
            return redirect()->route('admin.product.image', $product->slug);
        }

        $path = public_path('uploads/products');
        @unlink($path . '/' . $productImage->image);
        @unlink($path . '/thumb/' . $productImage->image);

        ProductImage::find($id)->delete();

        return redirect()->route('admin.product.image', $product->slug)->with('success', 'Image deleted successfully');
    }
}
