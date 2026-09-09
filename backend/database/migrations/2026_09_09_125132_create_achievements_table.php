<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('achievements', function(Blueprint $table) {
            $table->id();

            $table->foreignId('experience_id')->nullable()->constrained()->nullOnDelete();

            $table->string('title');

            $table->text('description')->nullable();

            $table->unsignedInteger('display_order')->default(0);

            $table->boolean('is_published')->default(true);

            $table->timestamps();

 }); }
 public function down(): void { Schema::dropIfExists('achievements'); }
};
