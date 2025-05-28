<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usage extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'product_id',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
