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
        Schema::create('kurang', function (Blueprint $table) {
            $table->id();
            $table->string('size');
            $table->integer('total');
            $table->unsignedBigInteger('id_daily_pengajuan');
            $table->foreign('id_daily_pengajuan')->references('id')->on('daily_pengajuan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurang');
    }
};
