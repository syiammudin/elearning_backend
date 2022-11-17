<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(Request $request)
    {

        $category = Category::when($request->search, function ($q) use ($request) {
            $q->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        });
        if ($request->type == 'list') {
            return $category->get();
        } else {
            return $category->orderBy($request->sort, $request->order == 'descending' ? 'desc' : 'asc')->paginate($request->pageSize);
        }
    }


    public function store(Request $request)
    {
        $data = Category::create($request->all());
        return ['message' => 'Data has been saved', 'data' => $data];
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        return ['message' => 'Data has been updated', 'data' => $category];
    }


    public function destroy(Category $category)
    {
        $category->delete();
        return ['message' => 'Data has been deleted'];
    }
}
