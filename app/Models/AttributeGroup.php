<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AttributeGroup extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = [];

    public $translatable = ['name'];

    public function attributes()
    {
        return $this->hasMany(Attribute::class)->orderByRaw('CAST(REPLACE(name, ",", ".") AS DECIMAL(10,2))');
    }

    public function orderedAttributes()
    {
        $attributes = $this->hasMany(Attribute::class)->get();

        $sortedAttributes = $attributes->sort(function ($a, $b) {
            $nameFromA = str_replace(',', '.', $a->name);
            $nameFromB = str_replace(',', '.', $b->name);

            $numberFromA = floatval(preg_replace('/[^0-9\.]/', '', $nameFromA));
            $numberFromB = floatval(preg_replace('/[^0-9\.]/', '', $nameFromB));

            return $numberFromA <=> $numberFromB;
        });

        return $sortedAttributes->values();
    }
}
