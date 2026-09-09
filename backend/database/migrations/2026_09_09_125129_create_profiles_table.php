<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('profiles', function(Blueprint $table) {
            $table->id();

            $table->string('full_name');

            $table->string('professional_title');

            $table->string('tagline')->nullable();

            $table->text('bio')->nullable();

            $table->text('professional_summary')->nullable();

            $table->string('profile_photo')->nullable();

            $table->string('hero_image')->nullable();

            $table->string('email');

            $table->string('phone')->nullable();

            $table->string('location')->nullable();

            $table->string('availability_status')->nullable();

            $table->text('availability_text')->nullable();

            $table->string('cv_file')->nullable();

            $table->timestamp('cv_updated_at')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

 }); }
 public function down(): void { Schema::dropIfExists('profiles'); }
};
