<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->user()->tokenCan('index.category')){
            return CategoryResource::collection(Category::all());
        }else{
            return response([
                'status' => false,
                'message' =>  'Not Allowed'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        if($request->user()->tokenCan('create.category')){
            if($request->validated()){
                // Create new category
                $category = new Category();
                $category->name = $request->name;
                $category->save();

                if($category){
                    return response([
                        'status' => true,
                        'message' =>  $request->name . ' Created Successfully',
                        'category' =>  new CategoryResource($category)
                    ], 200);
                }else{
                    return response([
                        'status' => false,
                        'message' =>  'Not Created'
                    ]);
                }
            }
        }else{
            return response([
                'status' => false,
                'message' =>  'Not Allowed'
            ]);
        }
    }
}
