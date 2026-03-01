@extends('layouts.app') 

@section('content')
<style>
    .onboard-hero {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        padding: 80px 0;
        color: white;
    }
    .feature-card {
        transition: transform 0.3s ease;
        border: 1px solid #e5e7eb;
    }
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
</style>

<div class="onboard-container">
    <div class="onboard-hero text-center mb-16">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-5xl font-extrabold mb-6">Chào mừng bạn đến với SmartNews AI</h1>
            <p class="text-xl opacity-90 leading-relaxed">
                Trải nghiệm thế hệ đọc tin tức mới: Thông minh hơn, nhanh hơn và hoàn toàn miễn phí khi tham gia cộng đồng của chúng tôi.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 pb-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="bg-white p-8 rounded-2xl feature-card text-center">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl">
                    <i class="fas fa-newspaper"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Tin tức chọn lọc</h3>
                <p class="text-gray-600 text-sm">Cập nhật những tin tức nóng hổi từ VTC News và các nguồn uy tín hàng đầu.</p>
            </div>

            <div class="bg-white p-8 rounded-2xl feature-card text-center">
                <div class="w-16 h-16 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl">
                    <i class="fas fa-robot"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Trợ lý Gemini AI</h3>
                <p class="text-gray-600 text-sm">Hỏi đáp, tóm tắt và phân tích chiều sâu bài báo ngay lập tức bằng trí tuệ nhân tạo.</p>
            </div>

            <div class="bg-white p-8 rounded-2xl feature-card text-center">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Cá nhân hóa</h3>
                <p class="text-gray-600 text-sm">Lưu lại lịch sử đọc và nhận các gợi ý tin tức phù hợp với sở thích cá nhân của bạn.</p>
            </div>
        </div>

        <div class="bg-gray-100 rounded-3xl p-12 text-center">
            <h2 class="text-3xl font-bold mb-6">Bạn đã sẵn sàng khám phá?</h2>
            <p class="text-gray-600 mb-10 max-w-2xl mx-auto">
                Vui lòng đăng nhập để có thể đọc chi tiết các bài báo và sử dụng hệ thống Trợ lý AI thông minh của chúng tôi.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-10 py-4 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg">
                    Đăng nhập ngay
                </a>
                <a href="{{ route('register') }}" class="bg-white text-blue-600 border-2 border-blue-600 px-10 py-4 rounded-xl font-bold hover:bg-blue-50 transition">
                    Tạo tài khoản mới
                </a>
            </div>
        </div>
    </div>
</div>
@endsection