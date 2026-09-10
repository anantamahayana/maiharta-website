<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category'); // e.g. "Apps Development", "Website Development", "UI/UX Design"
            $table->string('client_type')->nullable(); // e.g. "Instansi Pemerintahan"
            $table->string('short_description');
            $table->text('description');
            $table->text('challenge')->nullable();
            $table->text('solution')->nullable();
            $table->text('tech_summary')->nullable();
            $table->json('outcome_stats')->nullable(); // [{value, label}]
            $table->string('cover_image')->nullable();
            $table->json('gallery')->nullable(); // additional image paths
            $table->string('external_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
