<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name','slug'];

    public function courses()
    {
        return $this->hasMany('App\Course', 'category_id');
    }

     /**
     * Get the category's image.
     */
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    /**
     * delete category's image
     * @return JsonResponse
     */
    public function deleteCategoryImage()
    {
        try {
            if($this->image){
                Storage::disk('public')->delete('images/'.$this->image->file_name);
                $this->image()->delete();
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }
}
