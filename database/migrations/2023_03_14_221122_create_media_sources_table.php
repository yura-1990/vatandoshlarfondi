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
        Schema::create('media_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_id')->constrained('media')->onDelete('cascade')->onUpdate('cascade');
            $table->string('source');
            $table->string('source_type', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_sources');
    }
};
