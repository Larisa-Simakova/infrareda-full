<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'short_description',
        'order'
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function usages()
    {
        return $this->hasMany(Usage::class);
    }

    public function modifications()
    {
        return $this->hasMany(Modification::class);
    }

    public function modificationCharacteristics()
    {
        return $this->hasManyThrough(
            ModificationCharacteristic::class,
            Modification::class,
            'product_id', // FK в modifications
            'modification_id', // FK в modification_characteristics
            'id', // PK в products
            'id' // PK в modifications
        );
    }

    public function characteristics()
    {
        return $this->hasManyThrough(
            Characteristic::class,
            ModificationCharacteristic::class,
            'modification_id', // Внешний ключ в modification_characteristics
            'id',              // Первичный ключ в characteristics
            'id',              // Первичный ключ в products
            'characteristic_id' // Внешний ключ в modification_characteristics
        );
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function advantages()
    {
        return $this->hasMany(Advantage::class)->orderBy('order');
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }
}
