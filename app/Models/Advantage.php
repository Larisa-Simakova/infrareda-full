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
    'traditional_description',
    'infrared_description',
    'img',
    'product_id',
    'order'
];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
