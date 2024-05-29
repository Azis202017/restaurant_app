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
        Schema::create('reseps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('judul_resep');
            $table->string('foto_resep');
            $table->integer('lama_memasak');
            $table->text('cara_memasak');
            $table->string('status')->default('draft');
            $table->foreign('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade')->references('id');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseps');
    }
};
