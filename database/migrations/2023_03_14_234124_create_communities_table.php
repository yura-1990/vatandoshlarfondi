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
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('title');
            $table->text('description');
            $table->string('logo', 255);
            $table->string('document', 255);
            $table->string('director', 255);
            $table->text('director_img');
            $table->date('director_date');
            $table->string('work', 255);
            $table->date('created_date');
            $table->integer('members');
            $table->string('achievement', 255);
            $table->foreignId('region_id')->constrained('locations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('locations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('phone', 20);
            $table->string('email', 50);
            $table->text('address');
            $table->string('site', 255);
            $table->smallInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communities');
    }
};
