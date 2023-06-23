<?php

use App\Enums\EducationLocationTypeEnum;
use App\Models\User;
use App\Models\Userdata\CompatriotExpert;
use App\Models\Userdata\Specialization;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(CompatriotExpert::class)->constrained('compatriot_experts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('institution', 255);
            $table->string('level', 255)->comment('education level');
            $table->string('faculty', 255);
            $table->foreignIdFor(Specialization::class)->nullable()->constrained('specializations')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('type')->default(EducationLocationTypeEnum::UZBEKISTAN->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_educations');
    }
};
