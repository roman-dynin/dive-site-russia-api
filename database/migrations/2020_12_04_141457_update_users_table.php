<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class UpdateUsersTable.
 */
class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nickname')->nullable()->change();

            $table->string('phone')->nullable();

            $table->string('password')->nullable();

            $table->index([
                'phone',
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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nickname')->change();

            $table->dropColumn('phone');

            $table->dropColumn('password');

            $table->dropIndex([
                'phone',
            ]);
        });
    }
}
