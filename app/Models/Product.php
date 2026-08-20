<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'category_id',
        'description',
        'price',
        'original_price',
        'stock',
        'image',
        'sizes',
        'size_stocks',
        'colors',
        'color_stocks',
        'variants',
        'heel_height',
        'material',
        'weight',
        'origin',
        'discount_code',
        'classification',
        'status',
    ];

    // Quan hệ: Sản phẩm thuộc về 1 Danh mục
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Quan hệ: Sản phẩm có nhiều ảnh
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
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

    // Tồn kho chi tiết từng size (dạng Mảng [ '35' => 5, '36' => 10 ])
    public function getSizeStocksArrayAttribute(): array
    {
        if (empty($this->size_stocks)) return [];
        $decoded = json_decode($this->size_stocks, true);
        return is_array($decoded) ? $decoded : [];
    }

    // Tồn kho chi tiết từng màu (dạng Mảng [ 'Đen' => 12, 'Nude' => 8 ])
    public function getColorStocksArrayAttribute(): array
    {
        if (empty($this->color_stocks)) return [];
        $decoded = json_decode($this->color_stocks, true);
        return is_array($decoded) ? $decoded : [];
    }

    // Ma trận biến thể Ma trận [ 'Màu' => [ 'Size' => Số lượng ] ]
    public function getVariantsMatrixAttribute(): array
    {
        if (empty($this->variants)) return [];
        $decoded = json_decode($this->variants, true);
        return is_array($decoded) ? $decoded : [];
    }

    // Số lượng size có sẵn
    public function getSizesCountAttribute(): int
    {
        return count($this->sizes_array);
    }

    // Số lượng màu sắc có sẵn
    public function getColorsCountAttribute(): int
    {
        return count($this->colors_array);
    }

    // Format giá tiền: 850000 → "850.000"
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', '.');
    }

    // Tính % giảm giá so với giá gốc
    public function getDiscountPercentAttribute(): ?int
    {
        if (!$this->original_price || $this->original_price <= 0 || $this->original_price <= $this->price) {
            return null;
        }
        return (int) round((1 - $this->price / $this->original_price) * 100);
    }
}
