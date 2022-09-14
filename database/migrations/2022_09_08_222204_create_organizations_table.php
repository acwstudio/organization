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
        Schema::create('organizations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('organization_type_id');
            $table->string('name');
            $table->string('abbreviation');
            $table->text('description');
            $table->string('site');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('slug');
            $table->string('plaque_image');
            $table->string('preview_image');
            $table->string('base_image');
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
        Schema::dropIfExists('organizations');
    }
};
