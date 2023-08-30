<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = [];

    public $translatable = ['name', 'description'];

    public $with = ['mediaFile.thumbnail', 'seoEntity:slug'];

    // CATEGORIES
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories()
    {
        // return $this->category->get()->ancestorsAndSelf();
        return $this->category()->ancestorsAndSelf();
    }

    public function productsGroups()
    {
        return $this->belongsToMany(ProductsGroup::class);
    }

    public function descedantCategories()
    {
        // return $this->category->get()->descendantsAndSelf();
        return $this->category()->descendantsAndSelf();
    }

    // ATTRIBUTES
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }

    public function attributeGroups()
    {
        // get AttributeGroups with attributes that are attached to this product
        return AttributeGroup::whereHas('attributes.products', function ($query) {
            $query->where('products.id', $this->id);
        })->with(['attributes' => function ($query) {
            $query->whereHas('products', function ($query) {
                $query->where('products.id', $this->id);
            });
        }])->get();
    }


    // PRODUCT PAGE
    public function productPage()
    {
        return $this->hasOne(ProductPage::class);
    }

    // SEO ENTITY
    public function seoEntity()
    {
        return $this->hasOneThrough(SeoEntity::class, ProductPage::class, 'product_id', 'seo_entiteable_id', 'id', 'id')->where('seo_entiteable_type', ProductPage::class);
    }

    // Media FIle
    public function mediaFile()
    {
        return $this->belongsTo(MediaFile::class);
    }

    // Required Products Groups
    public function requiredProductsGroups()
    {
        return $this->belongsToMany(RequiredProductsGroup::class, 'product_required_products_group', 'product_id', 'required_products_group_id');
    }

    public function requiredProducts()
    {
        // merge products relation from each required products group
        return $this->requiredProductsGroups->map(function ($requiredProductsGroup) {
            return $requiredProductsGroup->products;
        })->flatten();
    }

    // OTHER
    public function searchByName($query)
    {
        return $this->where('name', 'like', "%$query%")->orWhere('sku', 'like', "%$query%");
    }

    public function syncProductRelationsData($data)
    {
        $this->attributes()->sync($data['attributes']);

        $this->productsGroups()->sync($data['products_groups']);

        $this->requiredProductsGroups()->sync($data['required_products_groups']);

        $this->mediaFile()->associate($data['media_file'] ? $data['media_file']['id'] : null);

        $this->save();
    }
}
