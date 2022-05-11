<?php

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
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id')->nullable(false);
            $table->string('title')->nullable(false);
            $table->dateTime('datetime')->nullable(false);
            $table->text('memo');
            $table->enum('category', ['private', 'work']);
            $table->dateTime('ins_time')->nullable(false)->default('1900-01-01 00:00:00');
            $table->dateTime('upd_time')->nullable(false)->default('1900-01-01 00:00:00');
            $table->tinyInteger('flag')->nullable(false)->default(0);          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task');
    }
};
