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
        Schema::create('appeal_emp_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('comm_app_id');
            $table->string('comment_details');
            $table->string('emp_name');
            $table->bigInteger('comm_status_id')->nullable();
            $table->timestamps();

            $table->foreign('comm_app_id')->references('app_id')->on('appeals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appeal_emp_comments');
    }
};
