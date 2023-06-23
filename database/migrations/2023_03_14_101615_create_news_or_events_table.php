<?php

use App\Models\NewsOrEvents\NewsOrEventType;
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
        Schema::create('news_or_events', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(NewsOrEventType::class)->constrained('news_or_event_types')->onUpdate('cascade')->onDelete('cascade');
            $table->text('image');
            $table->text('images');
            $table->text('data');
            $table->boolean('status')->default(false);
            $table->json('tags')->nullable();
            $table->longText('text');
            $table->longText('title');
            $table->bigInteger('viewers');
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
        Schema::dropIfExists('news_or_events');
    }
};
