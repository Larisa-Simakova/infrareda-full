<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advantage extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'img',
        'product_id',
        'infrared_description',
        'traditional_description',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
