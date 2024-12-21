<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $fillable = ['name', 'parent_id'];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function subfolders()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }
}


