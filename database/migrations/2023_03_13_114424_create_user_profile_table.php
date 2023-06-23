<?php

use App\Enums\FamilyStatusEnum;
use App\Enums\GenderEnum;
use App\Models\Public\Location;
use App\Models\Public\LocationCity;
use App\Models\Public\National;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_profile', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('first_name', 100);
            $table->string('second_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->string('national_address')->nullable();
            $table->foreignIdFor(Location::class, 'international_location_id')->nullable()->constrained('public.locations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(Location::class,'international_address_id')->nullable()->constrained('public.locations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(National::class)->nullable()->constrained('nationals')->onDelete('cascade')->onUpdate('cascade');
            $table->date('birth_date')->nullable();
            $table->smallInteger('gender')->nullable()->default(GenderEnum::OTHER->value);
            $table->string('academic_degree', 255)->nullable();
            $table->string('phone_number', 255)->nullable();
            $table->string('scientific_title', 255)->nullable();
            $table->string('job_position', 255)->nullable();
            $table->smallInteger('work_experience')->nullable();
            $table->text('additional_info')->nullable();
            $table->text('achievements')->nullable();
            $table->smallInteger('family_status')->nullable()->default(FamilyStatusEnum::SINGLE->value);
            $table->text('hobbies')->nullable();
            $table->text('interests')->nullable();
            $table->text('opinions_about_uzbekistan')->nullable();
            $table->text('suggestions_and_recommendations')->nullable();
            $table->string('timezone', 20)->nullable();
            $table->string('language', 10)->nullable();
            $table->string('avatar_url', 255)->default('users/default.png');
            $table->string('passport_file', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profile');
    }
};
