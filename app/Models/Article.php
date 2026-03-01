<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    protected $fillable = ['category_id', 'user_id','title', 'content', 'ai_summary', 'thumbnail', 'view_count'];

    // Bài báo thuộc về một danh mục
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        // Giả sử cột khóa ngoại trong bảng articles của bạn là user_id
        return $this->belongsTo(User::class, 'user_id');
    }

    // Một bài báo có thể có nhiều phiên chat
    public function chatSessions(): HasMany
    {
        return $this->hasMany(ChatSession::class);
    }
}