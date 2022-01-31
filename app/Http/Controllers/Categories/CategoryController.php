<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function tableCategories(Request $request)
    {
        if ($request->perPage > 0)
        {
            $data = Category::orderBy('created_at', 'desc')->paginate($request->perPage);
        }
        else
        {
            $data = Category::orderBy('created_at', 'desc')->get();
        }
        return response()->json($data);
    }
    public function saveCategories(Request $request)
    {
        $category = Category::firstOrNew([
            'id' => $request->id
        ]);
        
        $category->fill($request->all());
        $category->save();

        return response()->json($category);
    }
    public function deleteCategories($id)
    {
        $category = Category::find($id);
        $category->delete();

        return response()->json($category);
    }
}
