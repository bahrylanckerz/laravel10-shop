<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $product = Product::orderBy('name', 'asc');
        if (!empty($request->get('keyword'))) {
            $product = $product->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $product = $product->paginate(10);
        $data['product'] = $product;
        return view('admin.product.index', $data);
    }

    public function create()
    {
        $data['brand']           = Brand::orderBy('name', 'asc')->get();
        $data['categories']      = Category::orderBy('name', 'asc')->get();
        $data['subcategories']   = SubCategory::orderBy('name', 'asc')->get();
        $data['relatedProducts'] = Product::orderBy('name', 'asc')->get();
        return view('admin.product.create', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'name'            => 'required',
            'slug'            => 'required|unique:products',
            'description'     => 'required',
            'details'         => 'required',
            'price'           => 'required',
            'sku'             => 'required',
            'status'          => 'required',
            'category_id'     => 'required',
            'sub_category_id' => 'required',
            'brand_id'        => 'required',
            'image'           => 'required|image|mimes:png,jpg,jpeg|max:1024',
        ];

        $request->validate($rules);

        $image    = $request->file('image');
        $path     = public_path('uploads/products');
        $filename = $request->sku  . '-' . date('YmdHis') . '.' . $image->getClientOriginalExtension();

        $request->image->move($path, $filename);

        // Create image thumbnail
        $pathFile      = $path . '/' . $filename;
        $pathFileThumb = $path . '/thumb/' . $filename;

        $img = Image::make($pathFile);
        $img->resize(300, 300);
        $img->save($pathFileThumb);

        $data = [
            'brand_id'         => $request->brand_id,
            'category_id'      => $request->category_id,
            'sub_category_id'  => $request->sub_category_id,
            'name'             => $request->name,
            'slug'             => $request->slug,
            'description'      => $request->description,
            'details'          => $request->details,
            'price'            => $request->price,
            'compare_price'    => $request->compare_price,
            'sku'              => $request->sku,
            'barcode'          => $request->barcode,
            'qty'              => $request->qty,
            'track_qty'        => $request->track_qty,
            'related_products' => (!empty($request->related_products)) ? implode(',', $request->related_products) : null,
            'is_featured'      => $request->is_featured,
            'image'            => $filename,
            'status'           => $request->status,
        ];

        Product::create($data);

        return redirect()->route('admin.product')->with('success', 'Product created successfully');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        if (empty($product)) {
            return redirect()->route('admin.product');
        }
        if ($product->related_products) {
            $productArr = explode(',', $product->related_products);
            $data['relatedProducts'] = Product::whereIn('id', $productArr)->get();
        }
        $data['product']         = $product;
        $data['brand']           = Brand::orderBy('name', 'asc')->get();
        $data['categories']      = Category::orderBy('name', 'asc')->get();
        $data['subcategories']   = SubCategory::orderBy('name', 'asc')->get();
        return view('admin.product.edit', $data);
    }

    public function update($id, Request $request)
    {
        $product = Product::find($id);
        if (empty($product)) {
            return redirect()->route('admin.product');
        }

        $rules = [
            'name'            => 'required',
            'slug'            => 'required|unique:products,slug,'.$product->id.',id',
            'description'     => 'required',
            'details'         => 'required',
            'price'           => 'required',
            'sku'             => 'required',
            'status'          => 'required',
            'category_id'     => 'required',
            'sub_category_id' => 'required',
            'brand_id'        => 'required',
        ];

        $request->validate($rules);

        $image = $request->file('image');
        if ($image) {
            $path     = public_path('uploads/products');
            $filename = $request->sku  . '-' . date('YmdHis') . '.' . $image->getClientOriginalExtension();

            $request->image->move($path, $filename);

            // Create image thumbnail
            $pathFile      = $path . '/' . $filename;
            $pathFileThumb = $path . '/thumb/' . $filename;

            $img = Image::make($pathFile);
            $img->resize(300, 300);
            $img->save($pathFileThumb);

            @unlink($path . '/' . $product->image);
            @unlink($path . '/thumb/' . $product->image);
        }

        $data = [
            'brand_id'         => $request->brand_id,
            'category_id'      => $request->category_id,
            'sub_category_id'  => $request->sub_category_id,
            'name'             => $request->name,
            'slug'             => $request->slug,
            'description'      => $request->description,
            'details'          => $request->details,
            'price'            => $request->price,
            'compare_price'    => $request->compare_price,
            'sku'              => $request->sku,
            'barcode'          => $request->barcode,
            'qty'              => $request->qty,
            'track_qty'        => $request->track_qty,
            'related_products' => (!empty($request->related_products)) ? implode(',', $request->related_products) : null,
            'is_featured'      => $request->is_featured,
            'status'           => $request->status,
        ];

        if ($image) {
            $data['image'] = $filename;
        }

        Product::find($id)->update($data);

        return redirect()->route('admin.product')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (empty($product)) {
            return redirect()->route('admin.product');
        }

        $path = public_path('uploads/products');
        @unlink($path . '/' . $product->image);
        @unlink($path . '/thumb/' . $product->image);

        $productImage = ProductImage::where('product_id', $id)->get();
        foreach ($productImage as $item) {
            @unlink($path . '/' . $item->image);
            @unlink($path . '/thumb/' . $item->image);
        }

        Product::find($id)->delete();

        return redirect()->route('admin.product')->with('success', 'Product deleted successfully');
    }

    public function related(Request $request)
    {
        $tempProducts = [];
        if ($request->term != '') {
            $products = Product::where('name', 'like', '%'.$request->term.'%')->get();
            if ($products) {
                foreach ($products as $product) {
                    $tempProducts[] = array(
                        'id'   => $product->id,
                        'text' => $product->name,
                    );
                }
            }
        }
        return response()->json([
            'status' => true,
            'tags'   => $tempProducts,
        ]);
    }
}
