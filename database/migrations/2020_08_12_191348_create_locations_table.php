<?php

use Illuminate\Database\{
    Migrations\Migration,
    Schema\Blueprint
};
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateLocationsTable
 */
class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();

            $table->string('target_type');

            $table->integer('target_id');

            $table->decimal('lat', 10, 7);

            $table->decimal('lng', 10, 7);

            $table->timestamps();

            $table->softDeletes();

            $table->index([
                'target_type',
                'target_id',
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
        Schema::dropIfExists('locations');
    }
}
