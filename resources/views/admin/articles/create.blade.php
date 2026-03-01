@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-4 md:p-8">
    <div class="max-w-5xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Đăng bài báo mới</h1>
                <p class="text-gray-500 text-sm mt-1">Điền đầy đủ thông tin bên dưới để xuất bản nội dung mới.</p>
            </div>
            <a href="{{ route('admin.articles') }}" class="flex items-center gap-2 text-gray-500 hover:text-gray-800 font-medium transition-colors">
                <i class="fa fa-times-circle"></i> Hủy bỏ
            </a>
        </div>

        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tiêu đề bài báo</label>
                            <input type="text" name="title" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all placeholder:text-gray-400" placeholder="Nhập tiêu đề hấp dẫn..." required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nội dung bài viết</label>
                            <div class="rounded-xl overflow-hidden border border-gray-200">
                                <textarea name="content" id="editor"></textarea>
                            </div>
                        </div>

                        <div class="bg-blue-50/50 p-5 rounded-2xl border border-blue-100">
                            <div class="flex justify-between items-center mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-[10px] text-white">
                                        <i class="fa fa-robot"></i>
                                    </span>
                                    <label class="text-sm font-bold text-blue-900">Tóm tắt tự động bởi AI</label>
                                </div>
                                <button type="button" id="btn-ai-summarize" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all flex items-center gap-2 text-xs font-semibold shadow-md shadow-blue-200 active:scale-95">
                                    <i class="fa fa-magic"></i> Tạo tóm tắt
                                </button>
                            </div>
                            <textarea name="ai_summary" id="ai_summary" rows="3" 
                                class="w-full px-4 py-3 bg-white border border-blue-200 rounded-xl outline-none text-gray-600 text-sm resize-none" 
                                placeholder="Nhấn nút phía trên để AI tự động trích xuất nội dung..." readonly></textarea>
                            <p id="ai-status" class="text-[10px] mt-2 text-blue-400 font-medium italic"></p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Danh mục</label>
                            <select name="category_id" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 appearance-none bg-no-repeat bg-[right_1rem_center] bg-[length:1em_1em]" style="background-image: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 20 20%22%3E%3Cpath stroke=%22%236b7280%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%221.5%22 d=%22m6 8 4 4 4-4%22/%3E%3C/svg%3E')">
                                @foreach(\App\Models\Category::all() as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Thumbnail</label>
                            <div class="relative group border-2 border-dashed border-gray-200 rounded-2xl p-4 hover:border-blue-400 transition-all text-center">
                                <input type="file" name="thumbnail" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" id="thumbnail-input" accept="image/*">
                                <div id="thumbnail-placeholder">
                                    <i class="fa fa-cloud-upload-alt text-3xl text-gray-300 group-hover:text-blue-400 mb-2"></i>
                                    <p class="text-xs text-gray-500">Kéo thả hoặc nhấn để chọn ảnh</p>
                                </div>
                                <img id="thumbnail-preview" class="hidden w-full h-32 object-cover rounded-xl mx-auto shadow-sm">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-gray-900 text-white font-bold py-4 rounded-xl hover:bg-black transition-all shadow-xl shadow-gray-200 active:scale-[0.98]">
                            Xuất bản bài báo
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    // Khởi tạo CKEditor
    ClassicEditor.create(document.querySelector('#editor'))
        .then(newEditor => { window.editor = newEditor; })
        .catch(error => { console.error(error); });

    // Preview Thumbnail
    document.getElementById('thumbnail-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('thumbnail-placeholder').classList.add('hidden');
                const preview = document.getElementById('thumbnail-preview');
                preview.src = event.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    // AI Summarize Logic
    document.getElementById('btn-ai-summarize').addEventListener('click', async function() {
        const content = window.editor.getData();
        const btn = this;
        const status = document.getElementById('ai-status');
        const summaryArea = document.getElementById('ai_summary');

        if (!content.trim() || content === '<p>&nbsp;</p>') {
            alert('Vui lòng nhập nội dung bài viết trước khi yêu cầu AI tóm tắt!');
            return;
        }

        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang đọc...';
        status.innerText = "✨ Trí tuệ nhân tạo Gemini đang phân tích nội dung bài viết của bạn...";

        try {
            const response = await fetch("{{ route('chat.summarize') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({ content: content })
            });

            const data = await response.json();
            if (data.summary) {
                typeText(summaryArea, data.summary);
                status.innerText = "✅ Đã tóm tắt nội dung bài viết thành công.";
            } else { throw new Error(); }
        } catch (error) {
            status.innerText = "❌ Không thể kết nối với AI. Hãy thử lại.";
        } finally {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
            btn.innerHTML = '<i class="fa fa-magic"></i> Tạo tóm tắt';
        }
    });

    function typeText(element, text) {
        element.value = "";
        let i = 0;
        let interval = setInterval(() => {
            if (i < text.length) {
                element.value += text.charAt(i);
                i++;
                element.scrollTop = element.scrollHeight;
            } else { clearInterval(interval); }
        }, 15);
    }
</script>

<style>
    .ck-editor__editable { min-height: 400px; border: none !important; padding: 1rem !important; }
    .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) { border: none !important; }
    .ck.ck-toolbar { border: none !important; border-bottom: 1px solid #f3f4f6 !important; background: #fafafa !important; }
    #ai_summary[readonly] { cursor: default; }
</style>
@endsection