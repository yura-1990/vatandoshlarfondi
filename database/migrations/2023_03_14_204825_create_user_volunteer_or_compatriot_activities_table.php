<?php

use App\Enums\CompatriotTypeEnum;
use App\Models\User;
use App\Models\Userdata\CompatriotExpert;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_volunteer_or_compatriot_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('cascade');
            $table->text('title');
            $table->longText('description');
            $table->integer('type')->default(CompatriotTypeEnum::VOLUNTEER->value);
            $table->jsonb('images')->nullable();
            $table->bigInteger('viewers')->default(0);
            $table->foreignIdFor(CompatriotExpert::class)->nullable()->constrained('compatriot_experts')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_volunteer_or_compatriot_activities');
    }
};
