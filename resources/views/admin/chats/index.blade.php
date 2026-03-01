@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6 border border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Lịch sử chat AI</h1>
                        <p class="text-sm text-gray-500 font-medium">Theo dõi chi tiết câu hỏi của người dùng và phản hồi của hệ thống</p>
                    </div>
                </div>

                <form action="{{ route('admin.chats') }}" method="GET" class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Tìm người dùng hoặc nội dung..." 
                        class="w-full md:w-80 pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    <i class="fa fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500"></i>
                </form>
            </div>
        </div>

        <div class="space-y-4">
            @forelse($chats as $chat)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:border-blue-300 transition-colors">
                <div class="bg-gray-50/50 px-6 py-3 border-b border-gray-100 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Phiên #{{ $chat->id }}</span>
                        <span class="text-gray-300">|</span>
                        <span class="text-xs font-semibold text-blue-600">
                            <i class="fa fa-newspaper mr-1"></i> {{ $chat->article->title }}
                        </span>
                    </div>
                    <span class="text-xs text-gray-400">{{ $chat->created_at->format('H:i - d/m/Y') }}</span>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                        <div class="lg:col-span-5 border-r border-gray-50 pr-6">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold shadow-lg shadow-blue-200 flex-shrink-0 uppercase">
                                    {{ substr($chat->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 leading-none mb-1">{{ $chat->user->name }}</h4>
                                    <p class="text-[11px] text-gray-400 font-medium">{{ $chat->user->email }}</p>
                                </div>
                            </div>
                            
                            <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-100 relative">
                                <div class="absolute -top-2 left-4 px-2 bg-blue-600 text-[9px] font-black text-white uppercase rounded shadow-sm">Câu hỏi của bạn</div>
                                <p class="text-sm text-gray-800 leading-relaxed font-medium">
                                    "{{ $chat->question }}"
                                </p>
                            </div>
                        </div>

                        <div class="lg:col-span-7 flex flex-col">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-[10px]">
                                    <i class="fa fa-robot"></i>
                                </div>
                                <span class="text-[10px] font-black text-indigo-900 uppercase tracking-wider">AI Phản hồi</span>
                            </div>

                            <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-inner relative overflow-hidden group">
                                <div class="text-sm text-gray-600 leading-relaxed space-y-2 line-clamp-4 transition-all duration-300" id="content-{{ $chat->id }}">
                                    {!! nl2br(e($chat->answer)) !!}
                                </div>
                                
                                <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between items-center">
                                    <button onclick="toggleExpand({{ $chat->id }})" id="btn-{{ $chat->id }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 transition">
                                        <span>Xem chi tiết nội dung</span>
                                        <i class="fa fa-chevron-down text-[10px] transition-transform duration-300"></i>
                                    </button>
                                    
                                    <span class="text-[10px] text-gray-400 font-medium italic">
                                        Đã trả lời {{ $chat->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-3xl p-20 text-center border-2 border-dashed border-gray-100">
                <i class="fa fa-comment-slash text-6xl text-gray-100 mb-4"></i>
                <p class="text-gray-400 font-medium italic">Không tìm thấy dữ liệu hội thoại nào.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $chats->links() }}
        </div>
    </div>
</div>

<script>
function toggleExpand(id) {
    const content = document.getElementById('content-' + id);
    const btn = document.getElementById('btn-' + id);
    const icon = btn.querySelector('i');
    const span = btn.querySelector('span');

    if (content.classList.contains('line-clamp-4')) {
        content.classList.remove('line-clamp-4');
        icon.style.transform = 'rotate(180deg)';
        span.innerText = 'Thu gọn nội dung';
    } else {
        content.classList.add('line-clamp-4');
        icon.style.transform = 'rotate(0deg)';
        span.innerText = 'Xem chi tiết nội dung';
    }
}
</script>

<style>
    .line-clamp-4 {
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection