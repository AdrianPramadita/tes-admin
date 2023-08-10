<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('status')->nullable();
            $table->integer('role_access')->nullable();
            $table->string('job_title')->nullable();
            $table->string('department')->nullable();
            $table->string('organization')->nullable();
            $table->string('address')->nullable();
            
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
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
