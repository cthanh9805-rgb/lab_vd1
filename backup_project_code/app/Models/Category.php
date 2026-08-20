<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Quan hệ 1 - N: Một Danh mục có nhiều Sản phẩm
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
