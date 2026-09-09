<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('education', function(Blueprint $table) {
            $table->id();

            $table->string('institution');

            $table->string('qualification');

            $table->string('field_of_study')->nullable();

            $table->text('description')->nullable();

            $table->date('start_date')->nullable();

            $table->date('end_date')->nullable();

            $table->boolean('is_current')->default(false);

            $table->unsignedInteger('display_order')->default(0);

            $table->boolean('is_published')->default(true);

            $table->timestamps();

 }); }
 public function down(): void { Schema::dropIfExists('education'); }
};
