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
        Schema::create('personnels', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('per_role')->default(0);
            $table->string('per_nom');
            $table->string('per_prenom');
            $table->string('per_tel');
            $table->string('per_pic')->nullable();
            $table->enum('per_sexe',['H','F']);
            $table->string('per_email')->unique();
            $table->string('per_password');
            $table->boolean('per_status')->default(0);
            $table->unsignedInteger('package_id');
            $table->unsignedInteger('coach_id')->nullable();
            $table->foreign('package_id')
                ->references('id')
                ->on('packages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('coach_id')
                ->references('id')
                ->on('coaches')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnels');
    }
};
