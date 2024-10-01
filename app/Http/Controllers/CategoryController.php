<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use LogicException;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->paginate(20);
        return response()->json(CategoryResource::collection($categories));
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return response(new CategoryResource($category), 201);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return response(null, 204);
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
        } catch (LogicException $exception){
            return response($exception->getMessage(), 500);
        }
        return response(null, 204);
    }
}
