<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('product_images')->truncate();
        DB::table('products')->truncate();
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 5 danh mục
        $catIds = [];
        $categories = ['Cao Gót Mũi Nhọn', 'Sandal Cao Gót', 'Boot Cao Gót', 'Wedge (Đế Xuồng)', 'Kitten Heel'];
        foreach ($categories as $cat) {
            $catIds[$cat] = DB::table('categories')->insertGetId([
                'name' => $cat, 'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        $products = [
            [
                'name' => 'Giày Cao Gót Mũi Nhọn Da Thật',
                'category_id' => $catIds['Cao Gót Mũi Nhọn'],
                'description' => 'Giày cao gót mũi nhọn làm từ da thật cao cấp, gót nhọn 9cm, lót êm ái, phù hợp đi làm và dự tiệc.',
                'price' => 850000, 'original_price' => 1200000, 'stock' => 25,
                'heel_height' => 9, 'material' => 'Da thật', 'weight' => 380,
                'sizes' => '35,36,37,38,39',
                'size_stocks' => json_encode(['35'=>4,'36'=>6,'37'=>8,'38'=>5,'39'=>2]),
                'colors' => 'Đen,Nude,Đỏ',
                'color_stocks' => json_encode(['Đen'=>10,'Nude'=>10,'Đỏ'=>5]),
                'variants' => json_encode(['Đen'=>['35'=>2,'36'=>3,'37'=>3,'38'=>1,'39'=>1],'Nude'=>['35'=>2,'36'=>2,'37'=>4,'38'=>2,'39'=>0],'Đỏ'=>['35'=>0,'36'=>1,'37'=>1,'38'=>2,'39'=>1]], JSON_UNESCAPED_UNICODE),
                'origin' => 'Ý (Italy)', 'discount_code' => 'HEEL10', 'classification' => 'Bán chạy',
                'image' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'name' => 'Sandal Cao Gót Quai Mảnh',
                'category_id' => $catIds['Sandal Cao Gót'],
                'description' => 'Sandal cao gót với quai mảnh thanh lịch, gót nhọn 8cm, phù hợp dự tiệc hoặc đi chơi buổi tối.',
                'price' => 650000, 'original_price' => 850000, 'stock' => 30,
                'heel_height' => 8, 'material' => 'Da PU', 'weight' => 320,
                'sizes' => '35,36,37,38,39,40',
                'size_stocks' => json_encode(['35'=>5,'36'=>5,'37'=>8,'38'=>6,'39'=>4,'40'=>2]),
                'colors' => 'Nude,Vàng,Bạc',
                'color_stocks' => json_encode(['Nude'=>12,'Vàng'=>10,'Bạc'=>8]),
                'variants' => json_encode(['Nude'=>['35'=>2,'36'=>2,'37'=>4,'38'=>2,'39'=>1,'40'=>1],'Vàng'=>['35'=>2,'36'=>2,'37'=>2,'38'=>2,'39'=>2,'40'=>0],'Bạc'=>['35'=>1,'36'=>1,'37'=>2,'38'=>2,'39'=>1,'40'=>1]], JSON_UNESCAPED_UNICODE),
                'origin' => 'Hàn Quốc', 'discount_code' => 'SUMMER15', 'classification' => 'Hàng mới',
                'image' => 'https://images.unsplash.com/photo-1562273138-f46be4ebdf33?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'name' => 'Boot Cổ Cao Gót Vuông',
                'category_id' => $catIds['Boot Cao Gót'],
                'description' => 'Boot cổ cao phong cách hiện đại, gót vuông 7cm vững chắc, chất liệu da PU cao cấp.',
                'price' => 1200000, 'original_price' => 1500000, 'stock' => 15,
                'heel_height' => 7, 'material' => 'Da PU cao cấp', 'weight' => 580,
                'sizes' => '36,37,38,39,40',
                'size_stocks' => json_encode(['36'=>3,'37'=>4,'38'=>5,'39'=>2,'40'=>1]),
                'colors' => 'Đen,Nâu',
                'color_stocks' => json_encode(['Đen'=>9,'Nâu'=>6]),
                'variants' => json_encode(['Đen'=>['36'=>2,'37'=>2,'38'=>3,'39'=>1,'40'=>1],'Nâu'=>['36'=>1,'37'=>2,'38'=>2,'39'=>1,'40'=>0]], JSON_UNESCAPED_UNICODE),
                'origin' => 'Quảng Châu (Trung Quốc)', 'discount_code' => 'WINTER20', 'classification' => 'Cao cấp',
                'image' => 'https://images.unsplash.com/photo-1608256246200-53e635b5b65f?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'name' => 'Giày Đế Xuồng Cao 10cm',
                'category_id' => $catIds['Wedge (Đế Xuồng)'],
                'description' => 'Giày đế xuồng cói tự nhiên, cao 10cm, đế cao su chống trượt, thoải mái khi mang cả ngày.',
                'price' => 480000, 'original_price' => 680000, 'stock' => 40,
                'heel_height' => 10, 'material' => 'Vải canvas + Cói', 'weight' => 420,
                'sizes' => '35,36,37,38,39,40,41',
                'size_stocks' => json_encode(['35'=>6,'36'=>8,'37'=>10,'38'=>8,'39'=>4,'40'=>2,'41'=>2]),
                'colors' => 'Nude,Trắng',
                'color_stocks' => json_encode(['Nude'=>25,'Trắng'=>15]),
                'variants' => json_encode(['Nude'=>['35'=>4,'36'=>5,'37'=>6,'38'=>5,'39'=>3,'40'=>1,'41'=>1],'Trắng'=>['35'=>2,'36'=>3,'37'=>4,'38'=>3,'39'=>1,'40'=>1,'41'=>1]], JSON_UNESCAPED_UNICODE),
                'origin' => 'Việt Nam', 'discount_code' => 'SALE10', 'classification' => 'Khuyến mãi',
                'image' => 'https://images.unsplash.com/photo-1575537302964-96cd47c06b1b?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'name' => 'Giày Kitten Heel Công Sở',
                'category_id' => $catIds['Kitten Heel'],
                'description' => 'Giày gót thấp 4cm kiểu dáng thanh lịch, phù hợp mặc công sở hàng ngày.',
                'price' => 550000, 'original_price' => 550000, 'stock' => 35,
                'heel_height' => 4, 'material' => 'Da thật mềm', 'weight' => 290,
                'sizes' => '35,36,37,38,39,40',
                'size_stocks' => json_encode(['35'=>5,'36'=>7,'37'=>10,'38'=>8,'39'=>3,'40'=>2]),
                'colors' => 'Đen,Nude,Hồng',
                'color_stocks' => json_encode(['Đen'=>15,'Nude'=>12,'Hồng'=>8]),
                'variants' => json_encode(['Đen'=>['35'=>2,'36'=>3,'37'=>4,'38'=>3,'39'=>2,'40'=>1],'Nude'=>['35'=>2,'36'=>2,'37'=>4,'38'=>3,'39'=>1,'40'=>0],'Hồng'=>['35'=>1,'36'=>2,'37'=>2,'38'=>2,'39'=>0,'40'=>1]], JSON_UNESCAPED_UNICODE),
                'origin' => 'Nhật Bản', 'discount_code' => null, 'classification' => 'Nổi bật',
                'image' => 'https://images.unsplash.com/photo-1596568359553-a56de6970068?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'name' => 'Sandal Gót Vuông Quai Ngang',
                'category_id' => $catIds['Sandal Cao Gót'],
                'description' => 'Sandal gót vuông 7cm với quai ngang đơn giản, dễ phối đồ, chất liệu da bóng sang trọng.',
                'price' => 720000, 'original_price' => 950000, 'stock' => 20,
                'heel_height' => 7, 'material' => 'Da bóng', 'weight' => 340,
                'sizes' => '35,36,37,38,39',
                'size_stocks' => json_encode(['35'=>3,'36'=>5,'37'=>6,'38'=>4,'39'=>2]),
                'colors' => 'Đen,Trắng,Đỏ',
                'color_stocks' => json_encode(['Đen'=>8,'Trắng'=>8,'Đỏ'=>4]),
                'variants' => json_encode(['Đen'=>['35'=>1,'36'=>2,'37'=>3,'38'=>1,'39'=>1],'Trắng'=>['35'=>1,'36'=>2,'37'=>2,'38'=>2,'39'=>1],'Đỏ'=>['35'=>1,'36'=>1,'37'=>1,'38'=>1,'39'=>0]], JSON_UNESCAPED_UNICODE),
                'origin' => 'Hàn Quốc', 'discount_code' => 'VIPGIFT', 'classification' => 'Bán chạy',
                'image' => 'https://images.unsplash.com/photo-1535043934128-cf0b28d52f95?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'name' => 'Giày Cao Gót Mũi Tròn Nhung',
                'category_id' => $catIds['Cao Gót Mũi Nhọn'],
                'description' => 'Giày cao gót mũi tròn chất nhung mềm mại, gót nhọn 8cm, phong cách vintage thanh lịch.',
                'price' => 920000, 'original_price' => 1350000, 'stock' => 12,
                'heel_height' => 8, 'material' => 'Nhung', 'weight' => 350,
                'sizes' => '35,36,37,38',
                'size_stocks' => json_encode(['35'=>2,'36'=>4,'37'=>4,'38'=>2]),
                'colors' => 'Hồng,Đen,Đỏ',
                'color_stocks' => json_encode(['Hồng'=>5,'Đen'=>4,'Đỏ'=>3]),
                'variants' => json_encode(['Hồng'=>['35'=>1,'36'=>2,'37'=>1,'38'=>1],'Đen'=>['35'=>1,'36'=>1,'37'=>1,'38'=>1],'Đỏ'=>['35'=>0,'36'=>1,'37'=>2,'38'=>0]], JSON_UNESCAPED_UNICODE),
                'origin' => 'Pháp (France)', 'discount_code' => 'LUXURY10', 'classification' => 'Cao cấp',
                'image' => 'https://images.unsplash.com/photo-1515347619252-60a4bf4fff4f?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'name' => 'Boot Cổ Ngắn Gót Nhọn',
                'category_id' => $catIds['Boot Cao Gót'],
                'description' => 'Boot cổ ngắn phong cách Hàn Quốc, gót nhọn 8cm, khoá kéo bên hông.',
                'price' => 980000, 'original_price' => 1280000, 'stock' => 0,
                'heel_height' => 8, 'material' => 'Da mịn', 'weight' => 520,
                'sizes' => '36,37,38,39',
                'size_stocks' => json_encode(['36'=>0,'37'=>0,'38'=>0,'39'=>0]),
                'colors' => 'Đen,Nâu,Bạc',
                'color_stocks' => json_encode(['Đen'=>0,'Nâu'=>0,'Bạc'=>0]),
                'variants' => json_encode(['Đen'=>['36'=>0,'37'=>0,'38'=>0,'39'=>0],'Nâu'=>['36'=>0,'37'=>0,'38'=>0,'39'=>0],'Bạc'=>['36'=>0,'37'=>0,'38'=>0,'39'=>0]], JSON_UNESCAPED_UNICODE),
                'origin' => 'Hàn Quốc', 'discount_code' => 'CLEARANCE', 'classification' => 'Khuyến mãi',
                'image' => 'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?w=800&auto=format&fit=crop&q=80',
                'status' => 'inactive',
            ],
            [
                'name' => 'Giày Cao Gót Trong Suốt PVC',
                'category_id' => $catIds['Sandal Cao Gót'],
                'description' => 'Giày cao gót chất liệu PVC trong suốt cá tính, gót nhọn 10cm.',
                'price' => 580000, 'original_price' => 780000, 'stock' => 18,
                'heel_height' => 10, 'material' => 'PVC trong suốt', 'weight' => 300,
                'sizes' => '35,36,37,38,39',
                'size_stocks' => json_encode(['35'=>3,'36'=>5,'37'=>5,'38'=>3,'39'=>2]),
                'colors' => 'Trắng,Hồng',
                'color_stocks' => json_encode(['Trắng'=>10,'Hồng'=>8]),
                'variants' => json_encode(['Trắng'=>['35'=>2,'36'=>3,'37'=>3,'38'=>1,'39'=>1],'Hồng'=>['35'=>1,'36'=>2,'37'=>2,'38'=>2,'39'=>1]], JSON_UNESCAPED_UNICODE),
                'origin' => 'Quảng Châu (Trung Quốc)', 'discount_code' => 'TREND15', 'classification' => 'Hàng mới',
                'image' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
            [
                'name' => 'Giày Đế Xuồng Cói Thêu Hoa',
                'category_id' => $catIds['Wedge (Đế Xuồng)'],
                'description' => 'Giày đế xuồng cói thêu hoa đầy màu sắc, cao 8cm, chất liệu vải canvas kết hợp cói.',
                'price' => 420000, 'original_price' => 580000, 'stock' => 50,
                'heel_height' => 8, 'material' => 'Vải canvas + Cói thêu', 'weight' => 400,
                'sizes' => '35,36,37,38,39,40',
                'size_stocks' => json_encode(['35'=>8,'36'=>12,'37'=>15,'38'=>10,'39'=>3,'40'=>2]),
                'colors' => 'Nude,Đỏ,Hồng',
                'color_stocks' => json_encode(['Nude'=>25,'Đỏ'=>15,'Hồng'=>10]),
                'variants' => json_encode(['Nude'=>['35'=>4,'36'=>6,'37'=>8,'38'=>5,'39'=>1,'40'=>1],'Đỏ'=>['35'=>2,'36'=>4,'37'=>4,'38'=>3,'39'=>1,'40'=>1],'Hồng'=>['35'=>2,'36'=>2,'37'=>3,'38'=>2,'39'=>1,'40'=>0]], JSON_UNESCAPED_UNICODE),
                'origin' => 'Việt Nam', 'discount_code' => 'FLOWER10', 'classification' => 'Nổi bật',
                'image' => 'https://images.unsplash.com/photo-1560343090-f0409e92791a?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert(array_merge($product, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $this->command->info('✅ Đã seed 10 sản phẩm với giá gốc, thông số kỹ thuật, và ma trận biến thể!');
    }
}
