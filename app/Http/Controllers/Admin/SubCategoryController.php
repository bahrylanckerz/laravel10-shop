<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $subcategories = SubCategory::orderBy('name', 'asc');
        if (!empty($request->get('keyword'))) {
            $subcategories = $subcategories->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $subcategories = $subcategories->paginate(10);
        $data['subcategories'] = $subcategories;
        return view('admin.subcategory.index', $data);
    }

    public function create()
    {
        $data['categories'] = Category::where('status', 1)->orderBy('name', 'asc')->get();
        return view('admin.subcategory.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'name'        => 'required',
            'slug'        => 'required|unique:sub_categories',
        ]);

        if ($validator->passes()) {
            $subcategory = new SubCategory();
            $subcategory->category_id = $request->category_id;
            $subcategory->name        = $request->name;
            $subcategory->slug        = $request->slug;
            $subcategory->save();

            Session::flash('success', 'Sub Category created successfully');

            return response()->json([
                'status'  => true,
                'message' => 'Sub Category created successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function edit($id)
    {
        $subcategory = SubCategory::find($id);
        if (empty($subcategory)) {
            return redirect()->route('admin.subcategory');
        }
        $data['subcategory'] = $subcategory;
        $data['categories']  = Category::orderBy('name', 'asc')->get();
        return view('admin.subcategory.edit', $data);
    }

    public function update($id, Request $request)
    {
        $subcategory = SubCategory::find($id);
        if (empty($subcategory)) {
            return response()->json([
                'status'  => false,
                'message' => 'Category not found',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'name'        => 'required',
            'slug'        => 'required|unique:sub_categories,slug,' . $subcategory->id . ',id',
        ]);

        if ($validator->passes()) {
            $subcategory->category_id = $request->category_id;
            $subcategory->name        = $request->name;
            $subcategory->slug        = $request->slug;
            $subcategory->status      = $request->status;
            $subcategory->update();

            Session::flash('success', 'Sub Category updated successfully');

            return response()->json([
                'status'  => true,
                'message' => 'Sub Category updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function destroy($id)
    {
        $subcategory = SubCategory::find($id);
        if (empty($subcategory)) {
            return redirect()->route('admin.subcategory');
        }
        $subcategory->delete();
        Session::flash('success', 'Sub Category deleted successfully');
        return redirect()->route('admin.subcategory');
    }
}
