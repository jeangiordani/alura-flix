<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'videos';

    protected $fillable = ['title', 'description', 'url', 'category_id'];

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
}
