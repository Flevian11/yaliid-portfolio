<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('experiences', function(Blueprint $table) {
            $table->id();

            $table->string('organization');

            $table->string('position');

            $table->string('employment_type')->nullable();

            $table->string('location')->nullable();

            $table->date('start_date')->nullable();

            $table->date('end_date')->nullable();

            $table->boolean('is_current')->default(false);

            $table->string('summary')->nullable();

            $table->text('description')->nullable();

            $table->unsignedInteger('display_order')->default(0);

            $table->boolean('is_published')->default(true);

            $table->timestamps();

            $table->index(['is_published','display_order']);

 }); }
 public function down(): void { Schema::dropIfExists('experiences'); }
};
