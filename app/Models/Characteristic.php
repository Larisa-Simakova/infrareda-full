<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function modifications()
    {
        return $this->belongsToMany(Modification::class, 'modification_characteristics')
            ->using(ModificationCharacteristic::class)
            ->withPivot('value');
    }

    public function modificationCharacteristics()
    {
        return $this->hasMany(ModificationCharacteristic::class);
    }
}
