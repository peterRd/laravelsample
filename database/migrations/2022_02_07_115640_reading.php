<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Reading extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('readings', function (Blueprint $table) {
            $table->id()->unique();
            $table->float('depth', 8, 2, true)->default(0);
            $table->float('dip')->unsigned()->default(0);
            $table->float('azimuth')->unsigned()->default(0);
            $table->boolean('invalid')->nullable(false)->default(true);
            $table->unsignedBigInteger('instrument_id')
                ->foreign('instrument_id')
                ->references('id')
                ->on('instruments');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('readings');
    }
}
