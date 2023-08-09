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
        Schema::create('products', function (Blueprint $table) {
            $table->id();            
            $table->integer('category_id');
            $table->integer('section_id'); 
            $table->string('product_name');
            $table->string('product_code');
            $table->string('product_color');
            $table->string('main_image');
            $table->text('description');
            $table->string('wash_care');
            $table->string('fabric');
            $table->string('pattern');
            $table->string('sleeve');
            $table->string('fit');
            $table->string('occasion');
            $table->float('product_price');
            $table->float('product_discount');
            $table->float('product_weight');
            $table->string('product_video');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords');
            $table->enum('is_featured', ['No', 'Yes']);
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
