<?php

use App\Models\EMagazine\Month;
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
        Schema::create('e_magazines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Month::class)->constrained('months')->onUpdate('cascade')->onDelete('cascade');
            $table->text('thumbnail');
            $table->text('start_data_edition');
            $table->text('title');
            $table->text('short_content');
            $table->text('images');
            $table->text('text');
            $table->text('pdf');
            $table->bigInteger('pages');
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
        Schema::dropIfExists('e_magazines');
    }
};
