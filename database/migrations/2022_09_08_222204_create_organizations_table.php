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
            $table->uuid('parent_id')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('organization_type_id');
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
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('organization_type_id')->references('id')->on('organization_types');

        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropForeign('organizations_parent_id_foreign');
        });

        Schema::dropIfExists('organizations');
    }
};
