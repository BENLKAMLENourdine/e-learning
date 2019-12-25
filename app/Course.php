<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = ['category_id','name','description','slug'];

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    /**
     * Get the course's image.
     */
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

        /**
     * delete course's image
     * @return JsonResponse
     */
    public function deleteCourseImage()
    {
        try {
            if ($this->image) {
                Storage::disk('public')->delete('images/' . $this->image->file_name);
                $this->image()->delete();
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }

}
