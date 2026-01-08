<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // We will create data for 10 different sites
        $sites = [
            'Berau Coal', 'Adaro MetCoal', 'Buma Site', 'Pama Persada',
            'Kaltim Prima', 'Freeport Lowland', 'Freeport Highland',
            'Vale Indonesia', 'Amman Mineral', 'Wedasoft Nickel'
        ];

        $reportMonth = Carbon::create(2025, 1, 1);

        foreach ($sites as $index => $siteName) {
            // 1. Create Site
            $siteId = DB::table('sites')->insertGetId([
                'name' => $siteName,
                'code' => strtoupper(substr($siteName, 0, 3)) . '-' . ($index + 101),
                'country' => 'Indonesia',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ==========================================
            // 2. SEED REPORT TABLES (Randomized realistic data)
            // ==========================================

            // Table 1: Meals
            $pob = rand(2000, 15000); // Random POB between 2k and 15k
            DB::table('report_meals')->insert([
                'site_id' => $siteId,
                'report_month' => $reportMonth,
                'pob_count' => $pob,
                'total_breakfast' => $pob * 0.8,
                'total_lunch' => $pob * 0.95,
                'total_dinner' => $pob * 0.9,
                'total_pack_meal_supper' => rand(500, 2000),
                'pack_meal_inspection' => rand(50, 150),
                'insect_contamination' => rand(0, 2),
                'object_contamination' => rand(0, 1),
                'created_at' => now(), 'updated_at' => now()
            ]);

            // Table 2: Services
            DB::table('report_services')->insert([
                'site_id' => $siteId,
                'report_month' => $reportMonth,
                'cat_audit_score' => rand(80, 100) / 10, // 8.0 to 10.0
                'client_satisfaction_score' => rand(85, 100),
                'number_nc' => rand(0, 5),
                'tiac_detected' => 0,
                'haccp_audit_score' => rand(90, 100),
                'cln_audit_score' => rand(90, 100),
                'lau_audit_score' => rand(88, 100),
                'storage_audit_score' => rand(92, 100),
                'storage_inspections' => rand(10, 30),
                'created_at' => now(), 'updated_at' => now()
            ]);

            // Table 3: Accidents (Mostly 0, occasional 1)
            DB::table('report_accidents')->insert([
                'site_id' => $siteId,
                'report_month' => $reportMonth,
                'near_miss' => rand(0, 3),
                'first_aid_cases' => rand(0, 2),
                'environmental_incident' => 0,
                'mti' => rand(0, 1),
                'lti' => 0,
                'rwi' => 0,
                'hlv' => rand(0, 5),
                'vehicle_accident' => rand(0, 1),
                'created_at' => now(), 'updated_at' => now()
            ]);

            // Table 4: Meetings
            DB::table('report_meetings')->insert([
                'site_id' => $siteId,
                'report_month' => $reportMonth,
                'safety_meetings' => rand(10, 30),
                'management_meeting' => rand(4, 12),
                'management_customer_meeting' => rand(2, 8),
                'external_inspection' => rand(0, 2),
                'created_at' => now(), 'updated_at' => now()
            ]);

            // Table 5: Vehicles
            $vehicles = rand(10, 50);
            $mileage = $vehicles * rand(1000, 3000);
            $fuel = $mileage / rand(8, 12); // Rough calculation

            DB::table('report_vehicles')->insert([
                'site_id' => $siteId,
                'report_month' => $reportMonth,
                'vehicle_count' => $vehicles,
                'total_mileage_km' => $mileage,
                'vehicle_inspections' => $vehicles * 2,
                'fuel_usage_ltr' => $fuel,
                'fuel_consumption_ratio' => ($fuel / $mileage) * 100,
                'internal_audit_score' => rand(90, 100),
                'created_at' => now(), 'updated_at' => now()
            ]);

            // Table 6: Medical
            DB::table('report_medical')->insert([
                'site_id' => $siteId,
                'report_month' => $reportMonth,
                'consultation' => rand(5, 50),
                'created_at' => now(), 'updated_at' => now()
            ]);

            // Table 7: Waste
            $organic = rand(1000, 5000);
            $plastic = rand(100, 500);
            $oil = rand(500, 1500);

            DB::table('report_waste')->insert([
                'site_id' => $siteId,
                'report_month' => $reportMonth,
                'organic' => $organic,
                'cooking_oil' => $oil,
                'wood_timber' => rand(0, 100),
                'carton_paper' => rand(50, 200),
                'metal_steel' => rand(0, 50),
                'plastic' => $plastic,
                'glass' => rand(0, 20),
                'other' => rand(0, 10),
                'total' => $organic + $plastic + $oil + 200, // Sum + margin
                'created_at' => now(), 'updated_at' => now()
            ]);

            // Table 8: Others
            DB::table('report_others')->insert([
                'site_id' => $siteId,
                'report_month' => $reportMonth,
                'lpg_12kg' => rand(50, 200),
                'lpg_50kg' => rand(20, 100),
                'esg' => rand(80, 100),
                'created_at' => now(), 'updated_at' => now()
            ]);

            // 3. SEED CAPA TICKETS (Random 1-3 tickets per site)
            $ticketCount = rand(1, 3);
            for ($i = 0; $i < $ticketCount; $i++) {
                // Only seed tickets if the table exists
                if (DB::getSchemaBuilder()->hasTable('capa_tickets')) {
                    DB::table('capa_tickets')->insert([
                        'site_id' => $siteId,
                        'finding_date' => Carbon::now()->subDays(rand(1, 30)),
                        'controlled_by' => 'QHSE',
                        'area' => ['Kitchen', 'Storage', 'Dining Hall', 'Loading Bay'][rand(0,3)],
                        'comment' => 'Sample finding #' . rand(1000, 9999) . ' - ' . Str::random(20),
                        'risk_type' => ['Risk of cross-contamination', 'Risk of electrocution', 'Other'][rand(0,2)],
                        'risk_rank' => ['Low Risk', 'Moderate Risk', 'Elevated Risk'][rand(0,2)],
                        'pic_name' => ['Maintenance', 'Client', 'Cook - Head/SPV', 'Service - SPV'][rand(0,3)],
                        'status' => ['OPEN', 'ON PROGRESS', 'CLOSED'][rand(0,2)],
                        'is_late' => (bool)rand(0, 1),
                        'created_at' => now(), 'updated_at' => now()
                    ]);
                }
            }
        }
    }
}
