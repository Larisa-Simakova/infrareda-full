<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'product_id',
    ];

    public function characteristics()
    {
        return $this->belongsToMany(Characteristic::class, 'modification_characteristics')
            ->using(ModificationCharacteristic::class)
            ->withPivot('value');
    }

    public function modificationCharacteristics()
    {
        return $this->hasMany(ModificationCharacteristic::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
