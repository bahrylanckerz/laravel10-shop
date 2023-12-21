<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brand = Brand::latest('id');
        if (!empty($request->get('keyword'))) {
            $brand = $brand->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $brand = $brand->paginate(10);
        $data['brand'] = $brand;
        return view('admin.brand.index', $data);
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands',
        ]);

        Brand::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return redirect()->route('admin.brand')->with('success', 'Brand created successfully');
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        if (empty($brand)) {
            return redirect()->route('admin.brand');
        }
        $data['brand'] = $brand;
        return view('admin.brand.edit', $data);
    }

    public function update($id, Request $request)
    {
        $brand = Brand::find($id);
        if (empty($brand)) {
            return redirect()->route('admin.brand');
        }

        $request->validate([
            'name'   => 'required',
            'slug'   => 'required|unique:brands,slug,' . $brand->id . ',id',
            'status' => 'required',
        ]);

        Brand::find($id)->update([
            'name'   => $request->name,
            'slug'   => $request->slug,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.brand')->with('success', 'Brand updated successfully');
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);
        if (empty($brand)) {
            return redirect()->route('admin.brand');
        }

        Brand::find($id)->delete();

        return redirect()->route('admin.brand')->with('success', 'Brand deleted successfully');
    }
}
