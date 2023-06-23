<?php

use App\Enums\CompatriotTypeEnum;
use App\Enums\StatusEnum;
use App\Models\User;
use App\Models\Userdata\UserEducation;
use App\Models\Userdata\UserEmploymentInfo;
use App\Models\Userdata\UserProfile;
use App\Models\Userdata\UserVolunteerOrExpertActivity;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('compatriot_experts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('restrict');
            $table->foreignIdFor(UserProfile::class)->nullable()->constrained('user_profile')->onDelete('restrict');
            $table->string('academic_degree', 255)->nullable();
            $table->string('scientific_title', 255)->nullable();
            $table->json('main_science_directions')->nullable();
            $table->string('topic_of_scientific_article', 255)->nullable();
            $table->date('scientific_article_created_at')->nullable();
            $table->string('article_published_journal_name', 255)->nullable();
            $table->string('article_url', 255)->nullable();
            $table->string('article_file', 255)->nullable();
            $table->text('images')->nullable();
            $table->text('suggestions')->nullable();
            $table->text('additional_information')->nullable();
            $table->integer('type')->nullable();
            $table->boolean('verified')->nullable();
            $table->smallInteger('status')->default(StatusEnum::ACTIVE->value);
            $table->string('cv_file', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compatriot_experts');
    }
};
