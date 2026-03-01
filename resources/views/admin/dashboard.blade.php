@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    <div class="w-64 bg-gray-900 text-white flex-shrink-0 hidden md:block">
        <div class="p-6 border-b border-gray-800">
            <h2 class="text-xl font-bold text-blue-400 uppercase tracking-wider">VTC SmartNews</h2>
        </div>
        <nav class="mt-4 px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 bg-blue-600 text-white rounded-lg transition shadow-lg shadow-blue-900/20">
                <i class="fa fa-home mr-3 w-5 text-center"></i> Trang chủ
            </a>
            <a href="{{ route('admin.articles') }}" class="flex items-center p-3 hover:bg-gray-800 rounded-lg transition text-gray-400 hover:text-white group">
                <i class="fa fa-newspaper mr-3 w-5 text-center group-hover:text-blue-400"></i> Quản lý bài báo
            </a>
            <a href="{{ route('admin.users') }}" class="flex items-center p-3 hover:bg-gray-800 rounded-lg transition text-gray-400 hover:text-white group">
                <i class="fa fa-users mr-3 w-5 text-center group-hover:text-blue-400"></i> Quản lý người dùng
            </a>
            <div class="pt-4 pb-2 text-xs font-semibold text-gray-500 uppercase px-3">Hệ thống</div>
            <a href="{{ route('admin.chats') }}" class="flex items-center p-3 hover:bg-gray-800 rounded-lg transition text-gray-400 hover:text-white group">
                <i class="fa fa-robot mr-3 w-5 text-center group-hover:text-blue-400"></i> Lịch sử Chat AI
            </a>
        </nav>
    </div>

    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center border-b border-gray-200">
            <div class="flex items-center">
                <button class="md:hidden mr-4 text-gray-600"><i class="fa fa-bars"></i></button>
                <h1 class="text-xl font-bold text-gray-800">Tổng quan quản trị</h1>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-green-500 flex items-center justify-end">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span> Đang hoạt động
                    </p>
                </div>
            </div>
        </header>

        <main class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center">
                        <div class="p-4 bg-blue-50 text-blue-600 rounded-xl mr-4 text-2xl">
                            <i class="fa fa-file-alt"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase tracking-tight">Tổng bài viết</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalArticles) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center">
                        <div class="p-4 bg-green-50 text-green-600 rounded-xl mr-4 text-2xl">
                            <i class="fa fa-users"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase tracking-tight">Người dùng</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalUsers) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center">
                    <div class="p-4 bg-purple-50 text-purple-600 rounded-xl mr-4 text-2xl">
                        <i class="fa fa-eye"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium uppercase tracking-tight">Lượt xem tin</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalViews) }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center">
                    <div class="p-4 bg-yellow-50 text-yellow-600 rounded-xl mr-4 text-2xl">
                        <i class="fa fa-robot"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium uppercase tracking-tight">Lượt chat AI</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalChats) }}</h3>
                    </div>
                </div>
            </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 flex items-center">
                        <i class="fa fa-clock mr-2 text-blue-500"></i> Bài báo vừa đăng
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    @if($latestArticles->count() > 0)
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-xs uppercase text-gray-400 font-semibold border-b">
                                    <th class="px-6 py-4">Tiêu đề bài viết</th>
                                    <th class="px-6 py-4">Tác giả</th>
                                    <th class="px-6 py-4">Ngày xuất bản</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-gray-700">
                                @foreach($latestArticles as $article)
                                    <tr class="hover:bg-gray-50/80 transition">
                                        <td class="px-6 py-4 font-medium text-gray-900 truncate max-w-md">
                                            {{ $article->title }}
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-[10px] font-bold">
                                                    {{ substr($article->user->name ?? 'A', 0, 1) }}
                                                </div>
                                                <span class="text-gray-700">{{ $article->user->name ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $article->created_at->format('H:i - d/m/Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-12 text-center">
                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" class="w-16 h-16 mx-auto opacity-20 mb-4" alt="No data">
                            <p class="text-gray-400 italic">Hệ thống chưa ghi nhận bài viết nào.</p>
                            <a href="#" class="mt-4 inline-block text-sm text-blue-600 font-bold hover:underline">+ Đăng bài viết đầu tiên</a>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection