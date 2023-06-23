<?php

use App\Models\EMagazine\EMagazine;
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
        Schema::create('about_e_magazines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(EMagazine::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->text('images');
            $table->text('short_title');
            $table->text('title');
            $table->bigInteger('pages');
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
        Schema::dropIfExists('about_e_magazines');
    }
};
