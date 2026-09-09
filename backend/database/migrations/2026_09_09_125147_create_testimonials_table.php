<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('testimonials', function(Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->string('organization')->nullable();

            $table->string('position')->nullable();

            $table->text('content');

            $table->string('photo')->nullable();

            $table->unsignedTinyInteger('rating')->nullable();

            $table->boolean('is_featured')->default(false);

            $table->boolean('is_published')->default(true);

            $table->unsignedInteger('display_order')->default(0);

            $table->timestamps();

 }); }
 public function down(): void { Schema::dropIfExists('testimonials'); }
};
