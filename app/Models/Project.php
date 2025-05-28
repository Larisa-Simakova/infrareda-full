<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'date',
    ];

    protected $fillable = [
        'title',
        'description',
        'date',
        'place',
        'square',
        'height',
        'product_id',
    ];

    public function images() {
        return $this->hasMany(ProjectImage::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
