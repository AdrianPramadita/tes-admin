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
        Schema::create('im_store_group', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string('store_group_code')->unique();
            $table->string('store_group_desc')->nullable();
            $table->string('status')->nullable();

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
        Schema::dropIfExists('im_store_group');
    }
};
