<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon',
        'sort_order',
        'status',
        'created_by',
        'updated_by'
    ];

    public function items()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->where('parent_type', 'menu')
            ->where('status', 'active')
            ->orderBy('sort_order');
    }

}
