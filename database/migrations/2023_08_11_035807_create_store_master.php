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
        Schema::create('master_salesman', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('status')->nullable();
            $table->string('job_title')->nullable();
            $table->integer('store_id')->nullable();
            
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
        Schema::dropIfExists('master_salesman');
    }
};
