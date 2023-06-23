<?php

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
        Schema::create('compatriot_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('restrict');
            $table->string('name_uz');
            $table->string('name_oz');
            $table->string('name_ru');
            $table->string('name_en');
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compatriot_menus');
    }
};
