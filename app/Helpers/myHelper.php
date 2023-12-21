<?php

use App\Models\Category;
use App\Models\SubCategory;

function getCategories()
{
    return Category::where('status', 1)->orderBy('name', 'asc')->get();
}

function getSubCategories($category_id)
{
    return SubCategory::where('category_id', $category_id)->where('status', 1)->orderBy('name', 'asc')->get();
}

function cartCount()
{
    return 0;
}