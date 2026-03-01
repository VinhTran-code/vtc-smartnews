<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('chat_sessions', function (Blueprint $table) {
        $table->id();
        // Ràng buộc người dùng và bài viết
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('article_id')->constrained('articles')->onDelete('cascade');
        
        $table->text('question'); // Câu hỏi của user
        $table->text('answer');   // Câu trả lời của AI
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_sessions');
    }
};
