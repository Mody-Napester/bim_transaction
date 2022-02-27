<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Resources\SubCategoryResource;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->user()->tokenCan('index.category')){
            return SubCategoryResource::collection(SubCategory::all());
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
    public function store(StoreSubCategoryRequest $request)
    {
        if($request->user()->tokenCan('create.category')){
            if($request->validated()){
                // Check Category Exists
                if(!Category::where('id', $request->category_id)->first()){
                    return response([
                        'status' => false,
                        'message' =>  'Category Not Exists'
                    ]);
                }

                // Create new sub_category
                $sub_category = new SubCategory();
                $sub_category->category_id = $request->category_id;
                $sub_category->name = $request->name;
                $sub_category->save();

                if($sub_category){
                    return response([
                        'status' => true,
                        'message' =>  $request->name . ' Created Successfully',
                        'sub_category' =>  new SubCategoryResource($sub_category)
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
