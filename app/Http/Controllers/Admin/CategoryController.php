<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name', 'asc');
        if (!empty($request->get('keyword'))) {
            $categories = $categories->where('name', 'like', '%'. $request->get('keyword').'%');
        }
        $categories = $categories->paginate(10);
        $data['categories'] = $categories;
        return view('admin.category.index', $data);
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories',
        ]);

        if ($validator->passes()) {
            $category = new Category();
            $category->name         = $request->name;
            $category->slug         = $request->slug;
            $category->is_show_home = $request->is_show_home;
            $category->save();

            Session::flash('success', 'Category created successfully');

            return response()->json([
                'status'  => true,
                'message' => 'Category created successfully',
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
        $category = Category::find($id);
        if (empty($category)) {
            return redirect()->route('admin.category');
        }
        $data['category'] = $category;
        return view('admin.category.edit', $data);
    }

    public function update($id, Request $request)
    {
        $category = Category::find($id);
        if (empty($category)) {
            return response()->json([
                'status'  => false,
                'message' => 'Category not found',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$category->id.',id',
        ]);

        if ($validator->passes()) {
            $category->name         = $request->name;
            $category->slug         = $request->slug;
            $category->is_show_home = $request->is_show_home;
            $category->status       = $request->status;
            $category->update();

            Session::flash('success', 'Category updated successfully');

            return response()->json([
                'status'  => true,
                'message' => 'Category updated successfully',
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
        $category = Category::find($id);
        if (empty($category)) {
            return redirect()->route('admin.category');
        }
        $category->delete();
        Session::flash('success', 'Category deleted successfully');
        return redirect()->route('admin.category');
    }
}
