<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreatePlacemarksTable.
 */
class CreatePlacemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placemarks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id');

            $table->tinyInteger('type');

            $table->string('title');

            $table->text('description')->nullable();

            $table->timestamps();

            $table->softDeletes();

            $table->index([
                'user_id',
                'type',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('placemarks');
    }
}
