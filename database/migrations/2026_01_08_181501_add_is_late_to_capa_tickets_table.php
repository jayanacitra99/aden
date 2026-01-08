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
        Schema::table('capa_tickets', function (Blueprint $table) {
            $table->boolean('is_late')->default(false)->after('realization_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('capa_tickets', function (Blueprint $table) {
            $table->dropColumn('is_late');
        });
    }
};
