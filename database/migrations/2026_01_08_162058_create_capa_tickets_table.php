<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('capa_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');

            // Finding Details
            $table->date('finding_date');
            $table->string('controlled_by')->nullable(); // e.g. QHSE
            $table->string('area')->nullable(); // e.g. BKM - Packmeal
            $table->text('comment'); // The finding description
            $table->string('risk_type')->nullable(); // e.g. Risk of cross-contamination
            $table->string('risk_rank')->default('Moderate Risk');

            // Evidence & Action
            $table->string('photo_before_path')->nullable();
            $table->string('pic_name')->nullable(); // Person In Charge
            $table->text('proposed_solution')->nullable();

            // Timeline
            $table->integer('given_days')->default(7);
            $table->date('due_date')->nullable();
            $table->date('realization_date')->nullable();
            $table->string('photo_after_path')->nullable();

            // Status
            $table->enum('status', ['OPEN', 'ON PROGRESS', 'CLOSED'])->default('OPEN');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('capa_tickets');
    }
};
