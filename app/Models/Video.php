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

    public function videosByCategory(int $id)
    {
        return $this->where('category_id', $id)->orderBy('category_id', "ASC")->get()->toArray();
    }

    public function freeVideos()
    {
        return $this->where('category_id', 1)->get()->toArray();
    }
}
