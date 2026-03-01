<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatSession;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Gemini; 

class ChatController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'article_id' => 'required|integer|exists:articles,id'
        ]);

        try {
            $article = Article::findOrFail($request->article_id); 
            
           $prompt = "Bạn là Trợ lý Thông minh của VTC SmartNews. " .
                    "Dựa trên nội dung bài báo: '" . strip_tags($article->content) . "'. " .
                    "HƯỚNG DẪN TRẢ LỜI: " .
                    "1. Ưu tiên giải đáp dựa trên thông tin bài báo nếu người dùng hỏi về nó. " .
                    "2. Nếu người dùng hỏi các vấn đề ngoài lề, hãy trả lời bằng kiến thức rộng lớn của bạn nhưng vẫn giữ phong cách lịch sự, chuyên nghiệp. " .
                    "3. Luôn sử dụng định dạng Markdown (in đậm, danh sách) để văn bản dễ đọc. " .
                    "4. Trả lời bằng ngôn ngữ của người dùng (tiếng Việt). " .
                    "CÂU HỎI: " . $request->question;

            // Khởi tạo Client từ Factory để tránh lỗi Facade
            $client = \Gemini::factory()
                ->withApiKey(env('GEMINI_API_KEY'))
                ->make();

            // Gọi model Gemini 2.0 Flash-Lite từ .env
            // Dùng generativeModel để kiểm soát chính xác tên model gửi đi
            $modelName = env('GEMINI_MODEL', 'gemini-2.5-flash-lite');
            $result = $client->generativeModel($modelName)->generateContent($prompt);
            
            $aiAnswer = $result->text();

            $chat = ChatSession::create([
                'user_id' => Auth::id() ?: 1,
                'article_id' => $request->article_id,
                'question' => $request->question,
                'answer' => $aiAnswer,
            ]);

            return response()->json($chat);

        } catch (\Exception $e) {
            return response()->json([
                'answer' => 'Lỗi kết nối Gemini Lite: ' . $e->getMessage()
            ], 500);
        }
    }
    public function summarize(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        try {
            $client = \Gemini::factory()
                ->withApiKey(env('GEMINI_API_KEY'))
                ->make();

            // Sử dụng model từ .env
            $modelName = env('GEMINI_MODEL', 'gemini-2.5-flash-lite');
            
            $prompt = "Hãy tóm tắt nội dung bài báo sau đây một cách ngắn gọn, súc tích trong khoảng 2-3 câu. " .
                    "Lưu ý: Chỉ trả về nội dung tóm tắt, không thêm các câu dẫn giải khác. " .
                    "Nội dung: " . strip_tags($request->content);

            $result = $client->generativeModel($modelName)->generateContent($prompt);
            
            return response()->json([
                'summary' => $result->text()
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}