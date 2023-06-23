<?php

use App\Models\Public\Location;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Location::class)->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('name', 255);
            $table->string('flag', 255)->nullable();
            $table->string('code', 10)->nullable();
            $table->string('b_title', 255)->nullable();
            $table->text('b_description')->nullable();
            $table->text('b_image')->nullable();
            $table->string('locale', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
