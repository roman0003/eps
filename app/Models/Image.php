<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Folder;

class Image extends Model
{
    protected $fillable = ['path', 'folder_id'];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
}
