<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'description',
        'price',
        'stock',
        'image',
        'sizes',
        'colors',
        'status',
    ];

    // Quan hệ: Sản phẩm thuộc về 1 Danh mục
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Chuyển sizes string "35,36,37" → array ['35','36','37']
    public function getSizesArrayAttribute(): array
    {
        if (empty($this->sizes)) return [];
        return array_map('trim', explode(',', $this->sizes));
    }

    // Chuyển colors string "Đen,Nude,Đỏ" → array ['Đen','Nude','Đỏ']
    public function getColorsArrayAttribute(): array
    {
        if (empty($this->colors)) return [];
        return array_map('trim', explode(',', $this->colors));
    }

    // Format giá tiền: 850000 → "850.000"
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', '.');
    }
}
