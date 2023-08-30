<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model
{
    use HasFactory, HasRecursiveRelationships;

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function descedantProducts()
    {
        $categories = $this->descendantsAndSelf();
        return $this->hasManyThrough(Product::class, Category::class, 'parent_id', 'category_id', 'id', 'id')
            ->whereIn('category_id', $categories->pluck('id'));
    }
}
