<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SmartNewsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo dữ liệu mẫu cho bảng Users (Có mã hóa mật khẩu)
        $userId = DB::table('users')->insertGetId([
            'name' => 'Độc giả Demo',
            'username' => 'docgia2026',
            'password' => Hash::make('123456'), // Mật khẩu đã được Hash
            'phone' => '0987654321',
            'address' => 'Hà Nội, Việt Nam',
            'created_at' => now(),
        ]);

        // 2. Tạo dữ liệu mẫu cho bảng Categories
        $categories = [
            ['name' => 'Công nghệ', 'slug' => 'cong-nghe'],
            ['name' => 'Xã hội', 'slug' => 'xa-hoi'],
            ['name' => 'Kinh tế', 'slug' => 'kinh-te'],
        ];

        foreach ($categories as $cat) {
            $catId = DB::table('categories')->insertGetId(array_merge($cat, ['created_at' => now()]));

            // 3. Tạo dữ liệu mẫu cho bảng Articles ứng với từng Category
            $articleId = DB::table('articles')->insertGetId([
                'category_id' => $catId,
                'title' => 'VTC News ứng dụng AI vào quy trình sản xuất tin tức ' . $cat['name'],
                'content' => 'Đây là nội dung chi tiết bài báo về việc áp dụng Trí tuệ nhân tạo để tối ưu hóa tòa soạn số tại VTC News...',
                'ai_summary' => '• Tòa soạn số đang dịch chuyển mạnh mẽ sang AI. ' . "\n" . '• Giúp tăng tốc độ xuất bản tin tức. ' . "\n" . '• Hỗ trợ độc giả tóm tắt nội dung nhanh.',
                'thumbnail' => 'https://picsum.photos/800/400?random=' . rand(1, 100),
                'view_count' => rand(100, 1000),
                'created_at' => now(),
            ]);

            // 4. Tạo dữ liệu mẫu cho bảng Chat Sessions (Lịch sử hỏi đáp AI)
            DB::table('chat_sessions')->insert([
                'user_id' => $userId,
                'article_id' => $articleId,
                'question' => 'Bài báo này đề cập đến công nghệ AI nào?',
                'answer' => 'Bài báo đề cập đến việc sử dụng các mô hình ngôn ngữ lớn để tóm tắt văn bản và hỗ trợ biên tập viên.',
                'created_at' => now(),
            ]);
        }
    }
}