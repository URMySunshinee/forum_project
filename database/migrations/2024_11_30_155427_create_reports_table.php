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
    Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('reporter_id'); // Người báo cáo
        $table->unsignedBigInteger('reported_id'); // ID của nội dung bị báo cáo
        $table->string('reported_type'); // Loại nội dung: Post, Thread
        $table->text('reason');
        $table->string('status')->default('pending'); // pending, reviewed, resolved
        $table->timestamps();

        $table->foreign('reporter_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
};
