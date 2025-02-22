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
        Schema::create('subsea_pipelines', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->json('start_coordinates');
            $table->json('end_coordinates');
            $table->integer('end_depth');
            $table->integer('start_depth');
            $table->string('health');
            $table->integer('pressure');
            $table->float('temperature');
            $table->integer('flow_rate');
            $table->date('last_inspection');
            $table->date('next_maintenance');
            $table->integer('open_anomaly_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subsea_pipelines');
    }
};
