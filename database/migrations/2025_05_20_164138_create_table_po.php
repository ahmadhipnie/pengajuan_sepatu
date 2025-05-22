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
        Schema::create('po', function (Blueprint $table) {
            $table->id();
            $table->string('no_po');
            $table->enum('wide', ['M', 'W', 'XW']);
            $table->string('size_run');
            $table->string('colour_way');
            $table->string('style');
            $table->string('market');
            $table->string('qty_original');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_po');
    }
};
