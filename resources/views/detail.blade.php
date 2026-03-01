@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600 flex items-center transition font-medium">
           <i class="fa fa-arrow-left mr-2"></i> Quay lại trang chủ
        </a>
    </div>

    <div class="flex items-center space-x-2 text-sm text-gray-400 mb-3">
        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-bold text-xs uppercase">{{ $article->category->name }}</span>
        <span>•</span>
        <span>{{ $article->created_at->format('d/m/Y') }}</span>
        <span>•</span>
        <span><i class="fa fa-eye"></i> {{ $article->view_count }} lượt xem</span>
    </div>

    <h1 class="text-3xl md:text-5xl font-extrabold mb-8 leading-tight text-gray-900">{{ $article->title }}</h1>
    
    @if($article->thumbnail)
        <div class="rounded-3xl overflow-hidden shadow-2xl mb-10">
            <img src="{{ asset('storage/' . $article->thumbnail) }}" 
                alt="{{ $article->title }}" 
                class="w-full h-[450px] object-cover">
        </div>
    @endif

    @if($article->ai_summary)
    <div class="my-10">
        <button onclick="toggleAiSummary()" 
                class="group flex items-center gap-3 bg-gradient-to-r from-indigo-600 to-blue-600 text-white px-6 py-3 rounded-2xl shadow-lg hover:shadow-indigo-200 transition-all active:scale-95 text-sm font-bold">
            <div class="w-6 h-6 bg-white/20 rounded-lg flex items-center justify-center">
                <i class="fa fa-robot text-xs"></i>
            </div>
            <span id="btn-text">Xem tóm tắt bởi AI</span>
            <i id="summary-chevron" class="fa fa-chevron-down ml-2 transition-transform duration-300"></i>
        </button>

        <div id="ai-summary-content" class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
            <div class="mt-4 bg-gradient-to-br from-indigo-50 to-blue-50 border-l-4 border-indigo-500 p-6 rounded-r-2xl shadow-inner">
                <p class="text-indigo-900 leading-relaxed italic font-medium">
                    <i class="fa fa-quote-left opacity-20 mr-2"></i>
                    {{ $article->ai_summary }}
                </p>
            </div>
        </div>
    </div>
    @endif

    <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed mb-12">
        {!! $article->content !!}
    </div>

    @include('partials.chatbot', ['article' => $article])
</div>

<script>
    // Hàm Ẩn/Hiện Tóm tắt AI
    function toggleAiSummary() {
        const content = document.getElementById('ai-summary-content');
        const chevron = document.getElementById('summary-chevron');
        const btnText = document.getElementById('btn-text');

        if (content.style.maxHeight && content.style.maxHeight !== "0px") {
            // Đang mở -> Đóng lại
            content.style.maxHeight = "0px";
            chevron.style.transform = "rotate(0deg)";
            btnText.innerText = "Xem tóm tắt bởi AI";
        } else {
            // Đang đóng -> Mở ra
            content.style.maxHeight = content.scrollHeight + "px";
            chevron.style.transform = "rotate(180deg)";
            btnText.innerText = "Đóng tóm tắt";
        }
    }
</script>

<style>
    /* Tối ưu typography cho bài viết */
    .prose p { margin-bottom: 1.5rem; line-height: 1.8; }
    .prose img { border-radius: 1.5rem; margin: 2rem 0; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
</style>
@endsection