<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutes', function (Blueprint $table) {
            $table->id();
            $table->integer('board_id');
            $table->integer('district_id');
            $table->integer('thana_id');
            $table->string('name')->unique();
            $table->string('slug');
            $table->string('address');
            $table->string('email')->unique();
            $table->string('code');
            $table->boolean('status')->default(false);
            $table->boolean('permission')->default(0);
            $table->timestamp('countDown');
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
        Schema::dropIfExists('institutes');
    }
}
