<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surf_vessels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->json('coordinates')
                ->default(new Expression('(JSON_ARRAY())'))
                ->nullable();
            $table->integer('heading');
            $table->float('speed');
            $table->string('destination');
            $table->dateTime('eta');
            $table->string('status');
            $table->date('last_inspection');
            $table->integer('fuel_level');
            $table->float('wind_speed');
            $table->float('wave_height');
            $table->float('temperature');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surf_vessels');
    }
};
