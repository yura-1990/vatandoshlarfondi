<?php

use App\Models\Public\Location;
use App\Models\User;
use App\Models\Userdata\CompatriotExpert;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_employment_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(CompatriotExpert::class)->constrained('compatriot_experts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('company', 255);
            $table->string('position', 255);
            $table->foreignIdFor(Location::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->text('city')->nullable();
            $table->boolean('status')->default(false);
            $table->date('start_date')->nullable();
            $table->date('finish_date')->nullable();
            $table->string('specialization', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_employment_info');
    }
};
