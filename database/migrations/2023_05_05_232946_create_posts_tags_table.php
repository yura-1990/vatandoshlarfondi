<?php

use App\Models\AboutUzbekistan\City;
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
        Schema::create('posts_tags', function (Blueprint $table) {
            $table->foreignId('post_id')->nullable()->constrained('posts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('community_event_id')->nullable()->constrained('community_events')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('post_tag_id')->constrained('post_tags')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts_tags');
    }
};
