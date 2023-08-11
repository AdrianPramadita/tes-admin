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
        Schema::create('im_store_master', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string('store_code')->unique();
            $table->string('store_desc')->nullable();
            $table->integer('store_group')->nullable();
            $table->string('address')->nullable();
            $table->integer('province_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('sub_distric_id')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('pic')->nullable();
            $table->string('active_flag')->nullable();

            $table->integer('created_by')->nullable();            
            $table->integer('updated_by')->nullable();            
            $table->integer('deleted_by')->nullable();

            $table->timestamp("created_at");
            $table->timestamp("updated_at")->nullable();
            $table->timestamp("deleted_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('im_store_master');
    }
};
