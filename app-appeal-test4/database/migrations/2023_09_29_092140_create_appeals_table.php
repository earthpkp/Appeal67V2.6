<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appeals', function (Blueprint $table) {
            $table->id('app_id');
            $table->string('app_doc')->nullable();
            $table->string('app_gender')->nullable();
            $table->string('app_fname')->nullable();
            $table->string('app_lname')->nullable();
            $table->string('app_cardID')->nullable();
            $table->string('app_email')->nullable();
            $table->string('app_tel')->nullable();
            $table->string('app_typedetail')->nullable();
            $table->string('app_headdetail')->nullable();
            $table->string('app_detail', 2500)->nullable();
            $table->bigInteger('status_id')->default('1');
            $table->bigInteger('dep_id')->default('1');
            $table->bigInteger('app_active')->default('0');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appeals');
    }
};