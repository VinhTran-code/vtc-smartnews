@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    <div class="flex-1 p-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                        <i class="fa fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Quản lý bài báo</h1>
                    <p class="text-sm text-gray-500 font-medium">Danh sách các bài báo trên hệ thống</p>
                </div>
            </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.articles.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-lg shadow-blue-200 transition">
                        <i class="fa fa-plus mr-2"></i>Đăng bài mới
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 uppercase text-xs font-semibold text-gray-600">
                        <tr>
                            <th class="px-6 py-4 border-b">Ảnh bìa</th>
                            <th class="px-6 py-4 border-b">Thông tin bài viết</th>
                            <th class="px-6 py-4 border-b text-center">Lượt xem</th>
                            <th class="px-6 py-4 border-b text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($articles as $article)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4">
                                @if($article->thumbnail)
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" 
                                    alt="Thumbnail" 
                                    style="width: 100px; height: auto;">
                                @else
                                    <div class="w-24 h-14 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-xs italic">
                                        No image
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900 mb-1 leading-tight">{{ $article->title }}</div>
                                <div class="flex items-center text-xs text-gray-500 space-x-3">
                                    <span class="flex items-center">
                                        <i class="fa fa-tag mr-1 text-blue-400"></i> {{ $article->category->name ?? 'Chưa phân loại' }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fa fa-calendar-alt mr-1 text-gray-400"></i> {{ $article->created_at->format('d/m/Y') }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fa fa-eye mr-1"></i> {{ number_format($article->view_count) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center space-x-3 text-sm">
                                    <a href="{{ route('admin.articles.edit', $article->id) }}" class="text-blue-500 hover:text-blue-700 font-medium">Sửa</a>
                                    <form action="{{ route('admin.articles.delete', $article->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa bài báo này không?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium">
                                            <i class="fa fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">
                                <i class="fa fa-folder-open text-4xl mb-3 block opacity-20"></i>
                                Hệ thống chưa có bài viết nào.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection