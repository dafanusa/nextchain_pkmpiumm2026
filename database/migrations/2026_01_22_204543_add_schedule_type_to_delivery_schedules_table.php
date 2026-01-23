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
        Schema::table('delivery_schedules', function (Blueprint $table) {
            $table->string('schedule_type', 20)->default('scheduled')->after('delivery_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_schedules', function (Blueprint $table) {
            $table->dropColumn('schedule_type');
        });
    }
};
