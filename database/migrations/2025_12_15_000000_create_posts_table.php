<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->comment('Tiêu đề bài viết');
            $table->string('slug', 255)->unique()->comment('URL thân thiện');
            $table->longText('content')->comment('Nội dung bài viết');
            $table->text('excerpt')->nullable()->comment('Tóm tắt ngắn');
            $table->string('featured_image', 255)->nullable()->comment('Ảnh đại diện');
            $table->string('category', 100)->default('general')->comment('Danh mục: general, news, promotion, recipe');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->comment('Trạng thái: nháp, đã đăng, lưu trữ');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade')->comment('ID người tạo (admin)');
            $table->integer('views')->default(0)->comment('Số lượt xem');
            $table->boolean('is_featured')->default(0)->comment('Bài viết nổi bật: 0=không, 1=có');
            $table->string('meta_title', 255)->nullable()->comment('SEO title');
            $table->text('meta_description')->nullable()->comment('SEO description');
            $table->timestamp('published_at')->nullable()->comment('Thời gian đăng bài');
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('category');
            $table->index('is_featured');
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}

