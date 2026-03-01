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
    Schema::create('users', function (Blueprint $table) {
        $table->id(); 
        $table->string('name');
        $table->string('username', 50)->unique(); // Tên đăng nhập
        $table->string('password'); // Sẽ lưu dưới dạng Hash
        $table->string('phone', 15)->nullable();
        $table->text('address')->nullable();
        $table->rememberToken(); // Cần thiết cho tính năng "Ghi nhớ đăng nhập"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
