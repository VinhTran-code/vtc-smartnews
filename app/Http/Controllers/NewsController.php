<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $categories = \App\Models\Category::all();
        $query = Article::with('category');

        // Lọc theo danh mục nếu có
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // TÌM KIẾM: Kiểm tra nếu có từ khóa search
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                ->orWhere('content', 'LIKE', "%{$searchTerm}%");
            });
        }

        $articles = $query->latest()->paginate(6);
        return view('index', compact('articles', 'categories'));
    }

    public function show($id)
    {
        // Tìm bài viết theo ID, lấy kèm danh mục để hiển thị tên danh mục
        $article = Article::with('category')->findOrFail($id);

        // Tăng lượt xem mỗi khi có người click vào xem bài viết
        $article->increment('view_count');

        return view('detail', compact('article'));
    }
}