<?php

use App\Models\Messenger\Notification;
use App\Models\User;
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
        Schema::create('notification_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(Notification::class)->nullable()->constrained('notifications')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('is_read')->default(false);
            $table->unique(['user_id', 'notification_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meeting_offers');
    }
};
