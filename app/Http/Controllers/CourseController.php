<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CourseRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $courses = Course::with(['category', 'image' => function ($query) {
                $query->select('*', DB::raw("CONCAT('" . Storage::disk('local')->url('images/') . "', file_name) AS url"));
            }])->paginate(10);
            return response()->json(['status' => 'success', 'message' => 'Courses indexed successfully!', 'courses' => $courses], JsonResponse::HTTP_OK);
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
    public function store(CourseRequest $request)
    {
        try {
            $data = $request->all();
            $course = new \App\Course();
            $course->fill($data);
            $course->save();
            return response()->json(['status' => 'success', 'message' => 'Course created successfully!', 'course' => $course], JsonResponse::HTTP_OK);
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
            $course = Course::with(['category', 'image'])->where('slug', $slug)->first();
            if ($course) {
                return response()->json(['status' => 'success', 'message' => 'Course retrieved successfully!', 'course' => $course], JsonResponse::HTTP_OK);
            } else {
                return response()->json(['message' => 'No course was found'], JsonResponse::HTTP_CONFLICT);
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
    public function update(CourseRequest $request, $slug)
    {
        try {
            $data = $request->all();
            $course = Course::with(['category', 'image'])->where('slug', $slug)->first();
            if ($course) {
                $course->update($data);
                return response()->json(['status' => 'success', 'message' => 'Course updated successfully!', 'course' => $course], JsonResponse::HTTP_OK);
            } else {
                return response()->json(['message' => 'No course was found'], JsonResponse::HTTP_CONFLICT);
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
            $course = Course::where('slug', $slug)->first();
            if ($course) {
                $course->delete();
                return response()->json(['status' => 'success', 'message' => 'Course deleted successfully!'], JsonResponse::HTTP_OK);
            } else {
                return response()->json(['message' => 'No course was found'], JsonResponse::HTTP_CONFLICT);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }
}
