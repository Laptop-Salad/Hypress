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
        Schema::create('subsea_assets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->json('coordinates');
            $table->integer('depth');
            $table->string('health');
            $table->float('pressure');
            $table->float('temperature');
            $table->integer('flow_rate');
            $table->date('last_inspection');
            $table->date('next_maintenance');
            $table->integer('open_anomaly_count');
            $table->integer('workpacks_at_site_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subsea_assets');
    }
};
