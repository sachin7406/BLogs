<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'parent_type',
        'parent_id',
        'title',
        'description',
        'icon',
        'route_name',
        'url',
        'sort_order',
        'status'
    ];

    public function menuParent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function itemParent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }


    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->where('parent_type', 'menu_item')
            ->where('status', 'active')
            ->orderBy('sort_order');
    }   

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }
}
