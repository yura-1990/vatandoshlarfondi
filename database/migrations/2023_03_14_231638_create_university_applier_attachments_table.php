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
        Schema::create('university_applier_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_application_id')->constrained('university_appliers')->onUpdate('cascade')->onDelete('cascade');
            $table->string('attachment_type', 20);
            $table->string('path', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('university_applier_attachments');
    }
};
