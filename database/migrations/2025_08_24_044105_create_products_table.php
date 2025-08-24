<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('society_id')->constrained('societies')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // seller
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->decimal('price', 12, 2)->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->enum('condition', ['new', 'like_new', 'used', 'refurbished', 'other'])->default('used');
            $table->boolean('is_negotiable')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('featured_until')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
