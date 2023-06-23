<?php

use App\Models\AboutUzbekistan\AboutUzbekistanPageMenu;
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
        Schema::create('page_menu_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AboutUzbekistanPageMenu::class, 'about_uzbekistan_page_menu_id')->constrained('about_uzbekistan_page_menus')->onDelete('restrict');
            $table->text('title');
            $table->longText('text');
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
        Schema::dropIfExists('page_menu_contents');
    }
};
