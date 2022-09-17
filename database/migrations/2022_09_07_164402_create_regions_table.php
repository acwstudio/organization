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
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('federal_district_id');
            $table->string('name');
            $table->text('description');
            $table->string('slug');
            $table->boolean('active');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('federal_district_id')->references('id')->on('federal_districts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }
};
