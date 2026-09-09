<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('skills', function(Blueprint $table) {
            $table->id();

            $table->foreignId('skill_category_id')->constrained()->cascadeOnDelete();

            $table->string('name');

            $table->text('description')->nullable();

            $table->unsignedTinyInteger('proficiency')->nullable();

            $table->unsignedInteger('display_order')->default(0);

            $table->boolean('is_featured')->default(false);

            $table->boolean('is_published')->default(true);

            $table->timestamps();

            $table->index(['skill_category_id','is_published']);

 }); }
 public function down(): void { Schema::dropIfExists('skills'); }
};
