@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <h2 class="text-2xl font-black border-l-4 border-blue-600 pl-4 uppercase tracking-tight text-gray-800">
            Tin mới nhất
        </h2>
        
        <form action="{{ route('home') }}" method="GET" class="relative w-full md:w-80 group">
            @if(request('category_id'))
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Tìm kiếm tin tức..." 
                   class="w-full pl-11 pr-4 py-2.5 border border-gray-200 rounded-full focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none shadow-sm transition-all">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                <i class="fa fa-search"></i>
            </span>
        </form>
    </div>

    <div class="flex flex-wrap gap-2 mb-10">
        <a href="{{ route('home') }}" 
           class="px-5 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-all border {{ !request('category_id') ? 'bg-blue-600 text-white border-blue-600 shadow-lg shadow-blue-200' : 'bg-white text-gray-500 border-gray-200 hover:border-blue-400 hover:text-blue-600' }}">
           Tất cả
        </a>
        @foreach($categories as $category)
            <a href="{{ route('home', ['category_id' => $category->id] + request()->except('category_id', 'page')) }}" 
               class="px-5 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-all border {{ request('category_id') == $category->id ? 'bg-blue-600 text-white border-blue-600 shadow-lg shadow-blue-200' : 'bg-white text-gray-500 border-gray-200 hover:border-blue-400 hover:text-blue-600' }}">
               {{ $category->name }}
            </a>
        @endforeach
    </div>

    @if($articles->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-100">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-50 rounded-full mb-4">
                <i class="fa fa-newspaper text-3xl text-gray-200"></i>
            </div>
            <p class="text-gray-500 font-medium">Không tìm thấy bài viết nào phù hợp với yêu cầu của bạn.</p>
            <a href="{{ route('home') }}" class="text-blue-600 font-bold mt-4 inline-block hover:underline italic">Làm mới danh sách</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($articles as $article)
                <article class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="relative aspect-[16/10] overflow-hidden">
                        <img src="{{ asset('storage/' . $article->thumbnail) }}" 
                             alt="{{ $article->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-4 left-4">
                            <span class="bg-blue-600/90 backdrop-blur-sm text-white text-[10px] font-black uppercase px-3 py-1 rounded-lg shadow-lg">
                                {{ $article->category->name }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            <span><i class="fa fa-calendar-alt mr-1"></i> {{ $article->created_at->format('d/m/Y') }}</span>
                            <span><i class="fa fa-eye mr-1"></i> {{ number_format($article->view_count ?? 0) }}</span>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-900 leading-tight line-clamp-2 h-14 group-hover:text-blue-600 transition-colors">
                            <a href="{{ route('article.detail', $article->id) }}">
                                {{ $article->title }}
                            </a>
                        </h3>
                        
                        <p class="text-gray-500 text-sm mt-3 line-clamp-3 leading-relaxed">
                            {{ Str::limit(strip_tags($article->content), 120) }}
                        </p>

                        <div class="mt-6 pt-5 border-t border-gray-50 flex items-center justify-between">
                            <span class="text-xs font-medium text-gray-400 italic">
                                Bởi {{ $article->user->name ?? 'Admin' }}
                            </span>
                            <a href="{{ route('article.detail', $article->id) }}" class="text-blue-600 font-black text-xs uppercase tracking-widest flex items-center gap-1 group/btn transition-all">
                                Đọc tiếp 
                                <i class="fa fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-16 flex justify-center custom-pagination">
            {{ $articles->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<style>
    /* Tùy chỉnh giao diện phân trang Tailwind */
    .custom-pagination nav {
        @apply shadow-sm rounded-xl p-2 bg-white border border-gray-100;
    }
    .custom-pagination nav svg {
        width: 1.25rem;
        height: 1.25rem;
    }
    /* Ẩn dòng chữ "Showing X to Y of Z results" của Laravel */
    .custom-pagination nav div:first-child p {
        display: none !important;
    }

    /* Đảm bảo các nút số trang luôn nằm ở giữa */
    .custom-pagination nav > div:last-child {
        width: 100%;
        display: flex;
        justify-content: center;
    }
</style>
@endsection