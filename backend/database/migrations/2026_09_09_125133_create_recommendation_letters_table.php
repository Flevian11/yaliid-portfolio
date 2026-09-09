<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('recommendation_letters', function(Blueprint $table) {
            $table->id();

            $table->foreignId('experience_id')->nullable()->constrained()->nullOnDelete();

            $table->string('title');

            $table->string('issuer_name')->nullable();

            $table->string('issuer_position')->nullable();

            $table->string('issuer_organization')->nullable();

            $table->date('issue_date')->nullable();

            $table->string('file_path');

            $table->string('file_name');

            $table->string('mime_type')->nullable();

            $table->unsignedBigInteger('file_size')->nullable();

            $table->text('description')->nullable();

            $table->boolean('is_published')->default(true);

            $table->timestamps();

 }); }
 public function down(): void { Schema::dropIfExists('recommendation_letters'); }
};
