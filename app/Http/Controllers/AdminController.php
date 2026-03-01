<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\Category;
use App\Models\ChatSession;
class AdminController extends Controller
{
    // --- DASHBOARD ---
    public function dashboard()
    {
        // Lấy các chỉ số thống kê thực tế
        $totalUsers = User::count();
        $totalArticles = Article::count();
        $totalViews = Article::sum('view_count');
        $totalChats = ChatSession::count();
        
        // Giả sử bạn muốn lấy 5 bài viết mới nhất để hiển thị ở bảng dưới
       $latestArticles = Article::with('user') // Thêm with('user') ở đây
                        ->latest()
                        ->take(5)
                        ->get();

        // Truyền dữ liệu sang View
        return view('admin.dashboard', compact(
            'totalArticles', 
            'totalUsers', 
            'totalViews', 
            'totalChats', 
            'latestArticles'
        ));
    }

   //1. Hiển thị danh sách người dùng
    public function userIndex()
    {
        // Lấy danh sách user, phân trang 10 người mỗi trang
        $users = User::latest()->paginate(10); 
        
        return view('admin.users.index', compact('users'));
    }

    // 2. Xóa người dùng
    public function userDelete($id)
    {
        // Không cho phép Admin tự xóa chính mình
        if (Auth::id() == $id) {
            return back()->with('error', 'Bạn không thể tự xóa tài khoản của chính mình!');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Đã xóa người dùng thành công.');
    }

    // --- QUẢN LÝ BÀI BÁO ---
    public function articleIndex()
    {
       $articles = Article::latest()->paginate(15);
        return view('admin.articles.index', compact('articles'));
    }

    public function articleCreate()
    {
        return view('admin.articles.create');
    }

    public function articleStore(Request $request)
    {
        $request->validate([
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $article = new Article();
        $article->title = $request->title;
        $article->user_id = auth()->id();
        $article->category_id = $request->category_id;
        $article->content = $request->content;
        $article->ai_summary = $request->ai_summary; // Lưu tóm tắt AI nếu có
        $article->view_count = 0; // Mặc định khi mới đăng

        if ($request->hasFile('thumbnail')) {
            // 1. Lấy file từ máy khách gửi lên
            $file = $request->file('thumbnail');
            
            // 2. Tạo tên file duy nhất để không bị trùng (ví dụ: 17123456.jpg)
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // 3. Lưu vào thư mục 'public/articles' trong storage
            $path = $file->storeAs('articles', $fileName, 'public');
            
            // 4. Lưu đường dẫn này vào database (nó sẽ có dạng: articles/ten_anh.jpg)
            $article->thumbnail = $path;
        }

        $article->save();
        return redirect()->route('admin.articles')->with('success', 'Đăng bài thành column!');
    }
    // Hiển thị form chỉnh sửa
    public function articleEdit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    // Cập nhật dữ liệu vào Database
    public function articleUpdate(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $article = Article::findOrFail($id);
        $article->title = $request->title;
        $article->category_id = $request->category_id;
        $article->content = $request->content;
        $article->ai_summary = $request->ai_summary;

        if ($request->hasFile('thumbnail')) {
            // Xóa ảnh cũ nếu tồn tại để tiết kiệm bộ nhớ
            if ($article->thumbnail && file_exists(storage_path('app/public/' . $article->thumbnail))) {
                unlink(storage_path('app/public/' . $article->thumbnail));
            }
            $path = $request->file('thumbnail')->store('articles', 'public');
            $article->thumbnail = $path;
        }

        $article->save();
        return redirect()->route('admin.articles')->with('success', 'Cập nhật bài báo thành công!');
    }

    // Xóa bài báo
    public function articleDelete($id)
    {
        $article = Article::findOrFail($id);
        
        // Xóa file ảnh thumbnail vật lý
        if ($article->thumbnail && file_exists(storage_path('app/public/' . $article->thumbnail))) {
            unlink(storage_path('app/public/' . $article->thumbnail));
        }

        $article->delete();
        return redirect()->route('admin.articles')->with('success', 'Đã xóa bài báo thành công.');
    }
    public function chatHistory(Request $request)
    {
        $search = $request->input('search');

        $chats = \App\Models\ChatSession::with(['article', 'user'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('article', function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%");
                })
                ->orWhere('question', 'LIKE', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString(); // Giữ lại từ khóa tìm kiếm khi chuyển trang

        return view('admin.chats.index', compact('chats'));
    }
}
