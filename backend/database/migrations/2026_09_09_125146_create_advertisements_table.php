<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('advertisements', function(Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->text('description')->nullable();

            $table->string('image_path');

            $table->string('destination_url')->nullable();

            $table->string('position')->default('home');

            $table->timestamp('start_at')->nullable();

            $table->timestamp('end_at')->nullable();

            $table->boolean('is_active')->default(true);

            $table->unsignedInteger('display_order')->default(0);

            $table->timestamps();

            $table->index(['position','is_active']);

 }); }
 public function down(): void { Schema::dropIfExists('advertisements'); }
};
