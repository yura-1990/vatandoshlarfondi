<?php

use App\Models\OnlineCourse\CourseCertificate;
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
        Schema::create('course_certificate_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CourseCertificate::class, 'certificate_id')->constrained('course_certificates')->onDelete('restrict');
            $table->string('name', 255);
            $table->string('path', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_certificate_attachments');
    }
};
