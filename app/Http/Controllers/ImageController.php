<?php

namespace App\Http\Controllers;

use App\Image;
use App\Course;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ImageRequest;

class ImageController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request)
    {
        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $resource = $request->input('resource');
                $resource_id = $request->input('resource_id');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('images', $file, $filename);
                $image = new Image();
                $image->file_name = $filename;
                $image->imageable_type = $resource;
                $image->imageable_id = $resource_id;
                if ($resource == 'courses') {
                    $course = Course::where('id', $resource_id)->first();
                    $course->image()->save($image);
                } else {
                    $category = Category::where('id', $resource_id)->first();
                    $category->image()->save($image);
                }
                return response()->json(['status' => 'success', 'messages.image_uploaded' => 'messages.image_uploaded', 'image' => $image], JsonResponse::HTTP_OK);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }

}
