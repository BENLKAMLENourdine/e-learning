<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = Category::with(['image' => function ($query) {
                $query->select('*', DB::raw("CONCAT('" . Storage::disk('local')->url('images/') . "', file_name) AS url"));
            }])->paginate(10);
            return response()->json(['status' => 'success', 'message' => 'Categories indexed successfully!', 'categories' => $categories], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try {
            $data = $request->all();
            $category = new Category();
            $category->fill($data);
            $category->save();
            return response()->json(['status' => 'success', 'message' => 'Category created successfully!', 'category' => $category], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        try {
            $category = Category::with(['image'])->where('slug', $slug)->first();
            if ($category) {
                return response()->json(['status' => 'success', 'message' => 'Category retrieved successfully!', 'category' => $category], JsonResponse::HTTP_OK);
            } else {
                return response()->json(['message' => 'No category was found'], JsonResponse::HTTP_CONFLICT);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $slug)
    {
        try {
            $data = $request->all();
            $category = Category::with(['image'])->where('slug', $slug)->first();
            if ($category) {
                $category->update($data);
                return response()->json(['status' => 'success', 'message' => 'Category updated successfully!', 'category' => $category], JsonResponse::HTTP_OK);
            } else {
                return response()->json(['message' => 'No category was found'], JsonResponse::HTTP_CONFLICT);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        try {
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                $category->delete();
                return response()->json(['status' => 'success', 'message' => 'Category deleted successfully!'], JsonResponse::HTTP_OK);
            } else {
                return response()->json(['message' => 'No category was found'], JsonResponse::HTTP_CONFLICT);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }
}
