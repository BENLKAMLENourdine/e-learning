<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = ['file_name','imageable_type','imageable_id'];

    public function imageable()
    {
        return $this->morphTo();
    }
}
