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

    public function generateBreadcrumbs()
    {
        $urlParts = explode('/', $this->slug);
        $urlPathesArray = [];
        for ($i = 0; $i < count($urlParts); $i++) {
            $urlPathesArray[] = implode('/', array_slice($urlParts, 0, $i + 1));
        }
        $breadcrumbs = collect($urlPathesArray)->map(function ($item, $key) {
            $seoEntity = SeoEntity::where('slug', 'LIKE', $item)->first();
            if ($seoEntity) {
                return [
                    'title' => $seoEntity->title,
                    'slug' => $seoEntity->slug,
                ];
            }
        })->filter(function ($item) {
            return $item !== null;
        })->toArray();

        return $breadcrumbs;
    }
}
