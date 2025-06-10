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
        Schema::table('activities', function (Blueprint $table) {
            $table->integer('sms_count')->nullable();
            $table->integer('log_sms_count')->nullable();
            $table->integer('daily_count')->nullable();
            $table->integer('log_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn([
                'sms_count',
                'log_sms_count',
                'daily_count',
                'log_count'
            ]);
        });
    }
};
