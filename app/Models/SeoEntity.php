<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SeoEntity extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = [];

    public $translatable = ['title', 'description'];

    protected static function boot()
    {
        parent::boot();

        self::created(function ($seoEntity) {
            $seoEntity->ensureSlugIsUnique();
        });

        self::updated(function ($seoEntity) {
            $seoEntity->ensureSlugIsUnique();
        });
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function seoEntiteable()
    {
        return $this->morphTo();
    }

    public function ensureSlugIsUnique()
    {
        // $slug = $this->slug;
        // if ($slug === null || $slug === '') return;
        // $slugCount = SeoEntity::where('slug', 'like', "{$slug}%")->count();
        // if ($slugCount > 0) {
        //     $this->slug = "{$slug}-{$slugCount}";
        // }

        // $this->save();
    }
}
