<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->decimal('consultant_fee', 10, 2)->after('end_time')->nullable();
            $table->decimal('platform_fee', 10, 2)->after('consultant_fee')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn(['consultant_fee', 'platform_fee']);
        });
    }
};
