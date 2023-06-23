<?php

use App\Enums\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->unique();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('oauth_provider')->nullable();
            $table->string('oauth_id')->nullable();
            $table->timestamp('last_online_at')->nullable();
            $table->rememberToken();
            $table->smallInteger('status')->default(StatusEnum::ACTIVE->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
