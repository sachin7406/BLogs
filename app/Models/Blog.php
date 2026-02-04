<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'description',
        'reference_link',
        'reference_image',
        'status',
        'created_by',
        'category_id',
        'tags',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
