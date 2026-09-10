<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->json('meta')->nullable()->after('process_steps');         // [{label, value}]
            $table->json('capabilities')->nullable()->after('meta');          // [{title, description}]
            $table->string('about_title')->nullable()->after('capabilities');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['meta', 'capabilities', 'about_title']);
        });
    }
};
