<?php

use App\Models\Userdata\ExpertOrVolunteerPageType;
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
        Schema::create('banner_expert_or_volunteer_pages', function (Blueprint $table) {
            $table->id();
            $table->text('image')->nullable();
            $table->text('video')->nullable();
            $table->text('title_uz')->nullable();
            $table->text('title_oz')->nullable();
            $table->text('title_ru')->nullable();
            $table->text('title_en')->nullable();
            $table->text('text_uz')->nullable();
            $table->text('text_oz')->nullable();
            $table->text('text_ru')->nullable();
            $table->text('text_en')->nullable();
            $table->foreignIdFor(ExpertOrVolunteerPageType::class, 'type')
                ->nullable()
                ->constrained('expert_or_volunteer_page_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('banner_expert_or_volunteer_pages');
    }
};
