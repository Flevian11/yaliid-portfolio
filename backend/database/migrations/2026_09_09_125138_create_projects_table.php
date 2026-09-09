<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('projects', function(Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->string('slug')->unique();

            $table->string('short_description')->nullable();

            $table->longText('description')->nullable();

            $table->text('problem')->nullable();

            $table->text('solution')->nullable();

            $table->text('results')->nullable();

            $table->string('project_type')->nullable();

            $table->string('status')->nullable();

            $table->boolean('featured')->default(false);

            $table->string('github_url')->nullable();

            $table->string('live_url')->nullable();

            $table->date('start_date')->nullable();

            $table->date('end_date')->nullable();

            $table->unsignedInteger('display_order')->default(0);

            $table->boolean('is_published')->default(true);

            $table->timestamps();

            $table->index(['is_published','featured','display_order']);

 }); }
 public function down(): void { Schema::dropIfExists('projects'); }
};
