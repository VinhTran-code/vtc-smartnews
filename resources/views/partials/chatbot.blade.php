<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Hiệu ứng gõ chữ (Typing Dots) */
    .typing-indicator span {
        width: 8px; height: 8px; background: #3b82f6; border-radius: 50%;
        display: inline-block; animation: bounce 1.4s infinite ease-in-out both;
    }
    .typing-indicator span:nth-child(1) { animation-delay: -0.32s; }
    .typing-indicator span:nth-child(2) { animation-delay: -0.16s; }
    @keyframes bounce { 0%, 80%, 100% { transform: scale(0); } 40% { transform: scale(1); } }

    /* Style cho nội dung Markdown */
    .ai-response-text p { margin-bottom: 0.75rem; }
    .ai-response-text ul { list-style-type: disc; margin-left: 1.25rem; margin-bottom: 0.75rem; }
    .ai-response-text strong { color: #1e40af; }
</style>

<div class="fixed bottom-6 right-6 flex flex-col items-end z-50">
    <div id="chat-window" class="hidden w-80 md:w-[450px] bg-white shadow-2xl rounded-2xl border border-gray-100 flex flex-col mb-4 overflow-hidden transition-all duration-300">
        <div class="bg-blue-600 p-4 text-white flex justify-between items-center shadow-lg">
            <div class="flex items-center gap-2">
                <i class="fa fa-robot animate-bounce"></i>
                <span class="font-bold">Trợ lý VTC SmartNews</span>
            </div>
            <button onclick="toggleChat()" class="text-2xl hover:rotate-90 transition-transform">&times;</button>
        </div>

        <div id="chat-content" class="h-[450px] p-4 overflow-y-auto bg-gray-50 flex flex-col gap-4 text-sm scroll-smooth">
            <div class="self-start bg-white p-3 rounded-2xl rounded-tl-none border border-gray-100 shadow-sm max-w-[85%] text-gray-700">
                Chào bạn! Tôi đã sẵn sàng thảo luận về bài báo <strong>"{{ $article->title }}"</strong> hoặc bất cứ chủ đề nào bạn quan tâm.
            </div>
        </div>

        <form id="chat-form" class="p-4 bg-white border-t flex gap-2">
            <input type="text" id="user-input" placeholder="Nhập câu hỏi của bạn..." 
                   class="flex-1 bg-gray-100 border-none rounded-xl px-4 py-2 outline-none focus:ring-2 focus:ring-blue-500 transition">
            <button type="submit" id="submit-btn" class="bg-blue-600 text-white w-10 h-10 rounded-xl flex items-center justify-center hover:bg-blue-700 transition active:scale-90">
                <i class="fa fa-paper-plane"></i>
            </button>
        </form>
    </div>

    <button onclick="toggleChat()" class="bg-blue-600 text-white w-14 h-14 rounded-full shadow-2xl flex items-center justify-center text-2xl hover:scale-110 transition active:scale-95">
        <i class="fa fa-comment-dots"></i>
    </button>
</div>

<script>
function toggleChat() {
    const window = document.getElementById('chat-window');
    window.classList.toggle('hidden');
}

document.getElementById('chat-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const input = document.getElementById('user-input');
    const question = input.value.trim();
    const chatContent = document.getElementById('chat-content');
    
    if(!question) return;

    // 1. Hiển thị tin nhắn người dùng
    chatContent.innerHTML += `
        <div class="self-end bg-blue-600 text-white p-3 rounded-2xl rounded-tr-none max-w-[85%] shadow-md animate-fade-in">
            ${question}
        </div>
    `;
    input.value = '';
    chatContent.scrollTop = chatContent.scrollHeight;

    // 2. Hiển thị trạng thái đang trả lời
    const typingId = 'typing-' + Date.now();
    chatContent.innerHTML += `
        <div id="${typingId}" class="self-start bg-white p-4 rounded-2xl rounded-tl-none border border-gray-100 shadow-sm">
            <div class="typing-indicator"><span></span><span></span><span></span></div>
        </div>
    `;
    chatContent.scrollTop = chatContent.scrollHeight;

    try {
        const response = await fetch("{{ route('chat.send') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({ question: question, article_id: "{{ $article->id }}" })
        });
        
        const data = await response.json();
        document.getElementById(typingId).remove();

        // 3. Hiệu ứng hiện chữ lần lượt (Typewriter Effect)
        appendAiResponse(data.answer);

    } catch (error) {
        document.getElementById(typingId).remove();
        chatContent.innerHTML += `<div class="text-center text-red-500 text-xs">Lỗi kết nối. Vui lòng thử lại.</div>`;
    }
});

// Hàm tạo hiệu ứng hiện chữ lần lượt chuyên nghiệp
function appendAiResponse(fullText) {
    const chatContent = document.getElementById('chat-content');
    const msgId = 'ai-' + Date.now();
    
    chatContent.innerHTML += `
        <div class="self-start bg-white p-4 rounded-2xl rounded-tl-none border border-gray-100 shadow-sm max-w-[90%] ai-response-text">
            <div class="text-[10px] text-blue-500 font-bold mb-1 tracking-widest uppercase">SmartNews AI</div>
            <div id="${msgId}" class="leading-relaxed text-gray-800"></div>
        </div>
    `;

    const container = document.getElementById(msgId);
    let words = fullText.split(' ');
    let i = 0;

    function typeWord() {
        if (i < words.length) {
            // Lấy chuỗi hiện tại, render qua Markdown để giữ định dạng
            const currentText = words.slice(0, i + 1).join(' ');
            container.innerHTML = marked.parse(currentText);
            i++;
            chatContent.scrollTop = chatContent.scrollHeight;
            setTimeout(typeWord, 30); // Tốc độ hiện chữ (30ms mỗi từ)
        }
    }
    typeWord();
}
</script>