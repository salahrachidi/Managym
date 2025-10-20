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
        Schema::create('machine_muscles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('machine_id');
            $table->unsignedInteger('muscle_id');
            $table->foreign('machine_id')
                    ->references('id')
                    ->on('machines')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('muscle_id')
                    ->references('id')
                    ->on('muscles')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machine_muscles');
    }
};
