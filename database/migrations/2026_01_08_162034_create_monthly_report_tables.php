<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // 1. MEALS REPORT (From Image 1)
        Schema::create('report_meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->date('report_month');

            // On Site
            $table->integer('pob_count')->default(0)->comment('POB (ADEN + Client + Visitors)');
            $table->integer('total_breakfast')->default(0);
            $table->integer('total_lunch')->default(0);
            $table->integer('total_dinner')->default(0);
            $table->integer('total_pack_meal_supper')->default(0)->comment('Total Pack Meal / Supper');
            $table->integer('pack_meal_inspection')->default(0);
            $table->integer('insect_contamination')->default(0)->comment('Cases of meal contaminated by insects');
            $table->integer('object_contamination')->default(0)->comment('Cases of meal contaminated by objects');

            $table->timestamps();
            $table->unique(['site_id', 'report_month']);
        });

        Schema::create('report_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->date('report_month');

            // Catering
            $table->decimal('cat_audit_score', 5, 2)->default(0)->comment('Monthly CAT Audit Score');
            $table->decimal('client_satisfaction_score', 5, 2)->default(0);
            $table->integer('number_nc')->default(0);
            $table->integer('tiac_detected')->default(0);
            $table->decimal('haccp_audit_score', 5, 2)->default(0)->comment('Monthly HACCP Audit Score');

            // Housekeeping
            $table->decimal('cln_audit_score', 5, 2)->default(0)->comment('Monthly CLN Audit Score');

            // Laundry
            $table->decimal('lau_audit_score', 5, 2)->default(0)->comment('Monthly LAU Audit Score');

            // Storage
            $table->decimal('storage_audit_score', 5, 2)->default(0)->comment('Monthly Audit Score');
            $table->integer('storage_inspections')->default(0)->comment('Number of Inspection');

            $table->timestamps();
            $table->unique(['site_id', 'report_month']);
        });

        Schema::create('report_accidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->date('report_month');

            $table->integer('near_miss')->default(0);
            $table->integer('first_aid_cases')->default(0);
            $table->integer('environmental_incident')->default(0);
            $table->integer('mti')->default(0)->comment('Medical Treatment Incident');
            $table->integer('lti')->default(0)->comment('Lost Time Incident');
            $table->integer('rwi')->default(0)->comment('Restricted Work Incident');
            $table->integer('hlv')->default(0)->comment('High Learning Value Incident');
            $table->integer('vehicle_accident')->default(0);

            $table->timestamps();
            $table->unique(['site_id', 'report_month']);
        });

        Schema::create('report_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->date('report_month');

            $table->integer('safety_meetings')->default(0);
            $table->integer('management_meeting')->default(0);
            $table->integer('management_customer_meeting')->default(0);
            $table->integer('external_inspection')->default(0);

            $table->timestamps();
            $table->unique(['site_id', 'report_month']);
        });

        Schema::create('report_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->date('report_month');

            $table->integer('vehicle_count')->default(0)->comment('Number of vehicles');
            $table->decimal('total_mileage_km', 10, 2)->default(0)->comment('Total mileage driven (KMs)');
            $table->integer('vehicle_inspections')->default(0);
            $table->decimal('fuel_usage_ltr', 10, 2)->default(0);
            $table->decimal('fuel_consumption_ratio', 8, 2)->default(0)->comment('Fuel Consumption (ltr/100km)');
            $table->decimal('internal_audit_score', 5, 2)->default(0)->comment('Internal Audit Score (%)');

            $table->timestamps();
            $table->unique(['site_id', 'report_month']);
        });

        Schema::create('report_medical', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->date('report_month');

            $table->integer('consultation')->default(0);

            $table->timestamps();
            $table->unique(['site_id', 'report_month']);
        });

        Schema::create('report_waste', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->date('report_month');

            $table->decimal('organic', 10, 2)->default(0);
            $table->decimal('cooking_oil', 10, 2)->default(0);
            $table->decimal('wood_timber', 10, 2)->default(0);
            $table->decimal('carton_paper', 10, 2)->default(0);
            $table->decimal('metal_steel', 10, 2)->default(0);
            $table->decimal('plastic', 10, 2)->default(0);
            $table->decimal('glass', 10, 2)->default(0);
            $table->decimal('other', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            $table->timestamps();
            $table->unique(['site_id', 'report_month']);
        });

        Schema::create('report_others', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->date('report_month');

            $table->integer('lpg_12kg')->default(0)->comment('Number of 12kg LPG cylinders');
            $table->integer('lpg_50kg')->default(0)->comment('Number of 50kg LPG cylinders');
            $table->decimal('esg', 8, 2)->default(0)->comment('Environmental Sustainability Grade');

            $table->timestamps();
            $table->unique(['site_id', 'report_month']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('report_meals');
        Schema::dropIfExists('report_services');
        Schema::dropIfExists('report_accidents');
        Schema::dropIfExists('report_meetings');
        Schema::dropIfExists('report_vehicles');
        Schema::dropIfExists('report_medical');
        Schema::dropIfExists('report_waste');
        Schema::dropIfExists('report_others');
    }
};
