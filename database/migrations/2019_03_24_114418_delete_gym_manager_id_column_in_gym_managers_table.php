<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteGymManagerIdColumnInGymManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gym_managers', function (Blueprint $table) {
            $table->dropForeign('gym_managers_gym_manager_id_foreign');
            $table->dropColumn('gym_manager_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gym_managers', function (Blueprint $table) {
            //
        });
    }
}
