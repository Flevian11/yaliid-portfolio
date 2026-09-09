<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('project_media', function(Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')->constrained()->cascadeOnDelete();

            $table->string('file_path');

            $table->string('file_name');

            $table->string('mime_type')->nullable();

            $table->unsignedBigInteger('file_size')->nullable();

            $table->string('alt_text')->nullable();

            $table->string('caption')->nullable();

            $table->boolean('is_featured')->default(false);

            $table->unsignedInteger('display_order')->default(0);

            $table->timestamps();

 }); }
 public function down(): void { Schema::dropIfExists('project_media'); }
};
