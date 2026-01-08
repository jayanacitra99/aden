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
            if (!Schema::hasColumn('capa_tickets', 'risk_type')) {
                $table->string('risk_type')->nullable()->after('comment');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('capa_tickets', function (Blueprint $table) {
            if (Schema::hasColumn('capa_tickets', 'risk_type')) {
                $table->dropColumn('risk_type');
            }
        });
    }
};
