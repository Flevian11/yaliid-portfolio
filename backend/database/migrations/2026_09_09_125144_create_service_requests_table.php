<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('service_requests', function(Blueprint $table) {
            $table->id();

            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();

            $table->string('reference')->unique();

            $table->string('name');

            $table->string('email');

            $table->string('phone')->nullable();

            $table->string('company')->nullable();

            $table->longText('description');

            $table->decimal('budget',14,2)->nullable();

            $table->date('preferred_deadline')->nullable();

            $table->string('status')->default('new');

            $table->string('priority')->default('normal');

            $table->text('admin_notes')->nullable();

            $table->timestamps();

            $table->index(['status','created_at']);

 }); }
 public function down(): void { Schema::dropIfExists('service_requests'); }
};
