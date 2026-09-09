<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('social_links', function(Blueprint $table) {
            $table->id();

            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();

            $table->string('platform');

            $table->string('label')->nullable();

            $table->string('url');

            $table->string('icon')->nullable();

            $table->unsignedInteger('display_order')->default(0);

            $table->boolean('is_visible')->default(true);

            $table->timestamps();

            $table->index(['profile_id','is_visible']);

 }); }
 public function down(): void { Schema::dropIfExists('social_links'); }
};
