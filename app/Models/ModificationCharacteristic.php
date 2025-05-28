<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ModificationCharacteristic extends Pivot
{
    protected $table = 'modification_characteristics';

    protected $fillable = [
        'value',
        'modification_id',
        'characteristic_id'
    ];

    public function modification()
    {
        return $this->belongsTo(Modification::class);
    }

    public function characteristic()
    {
        return $this->belongsTo(Characteristic::class);
    }
}
