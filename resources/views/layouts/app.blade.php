<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smart News Hub - VTC News AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-900">
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-blue-600">VTC <span class="text-gray-800">SmartNews</span></a>

            <div class="flex items-center space-x-4">
                @auth
                {{-- Nút vào Dashboard chỉ dành cho Admin --}}
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-purple-600 font-bold hover:text-purple-700">
                            <i class="fa fa-user-shield mr-1"></i> Quản trị
                        </a>
                    @endif
                    <div class="flex items-center space-x-3">
                        <span class="text-gray-700 text-sm">Chào, 
                            <a href="{{ route('profile') }}" class="hover:underline">
                                <strong class="text-blue-600">{{ Auth::user()->name }}</strong>
                            </a>
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium flex items-center">
                                <i class="fa fa-sign-out-alt mr-1"></i> Đăng xuất
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 text-sm font-medium">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium transition shadow-sm">
                        Đăng ký
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white pt-12 pb-8 mt-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-8">
                <div>
                    <h3 class="text-xl font-bold mb-4 text-blue-400">Smart News Hub</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Dự án thực tập tích hợp Trí tuệ nhân tạo (AI) giúp tối ưu hóa trải nghiệm đọc tin tức và tương tác thông minh cho độc giả VTC News.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4 uppercase tracking-wider">Sinh viên thực hiện</h3>
                    <ul class="text-gray-400 text-sm space-y-3">
                        <li><i class="fa fa-user-graduate mr-2 text-blue-500"></i> Họ tên: <strong>Trần Ngọc Vinh</strong></li>
                        <li><i class="fa fa-id-card mr-2 text-blue-500"></i> MSV: 2251172558</li>
                        <li><i class="fa fa-phone mr-2 text-blue-500"></i> Hotline: 0347706432</li>
                        <li>
                            <i class="fa fa-envelope mr-2 text-blue-500"></i> 
                            Email: Vinhbin1611@gmail.com
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4 uppercase tracking-wider">Kết nối với tôi</h3>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/vinhtran1611" target="_blank" class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition shadow-lg">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://github.com/VinhTran-code" target="_blank" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-black transition shadow-lg">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                    
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center text-gray-500 text-xs">
                <p>&copy; 2026 Smart News Hub | Thiết kế và Phát triển bởi VinG</p>
            </div>
        </div>
    </footer>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Kiểm tra thông báo thành công từ session
            @if(session('success'))
                Swal.fire({
                    title: 'Thành công!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonColor: '#2563eb', // Màu xanh chủ đạo của hệ thống
                    confirmButtonText: 'Đóng'
                });
            @endif

            // Kiểm tra thông báo lỗi từ session (nếu có)
            @if(session('error'))
                Swal.fire({
                    title: 'Lỗi!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'Thử lại'
                });
            @endif
        });
    </script>

</body>
</html>