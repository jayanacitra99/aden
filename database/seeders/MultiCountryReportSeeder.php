<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MultiCountryReportSeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            'Indonesia' => ['Jakarta Site', 'Bali Site'],
            'Vietnam' => ['Hanoi Site', 'Ho Chi Minh Site']
        ];

        // Last 5 months including current month
        $months = [];
        for ($i = 0; $i < 5; $i++) {
            $months[] = Carbon::now()->startOfMonth()->subMonths($i);
        }

        foreach ($countries as $countryName => $siteNames) {
            foreach ($siteNames as $siteName) {
                // 1. Create or Get Site
                $siteId = DB::table('sites')->updateOrInsert(
                    ['name' => $siteName, 'country' => $countryName],
                    [
                        'code' => strtoupper(substr($siteName, 0, 3)) . '-' . rand(100, 999),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

                // Get the ID if we just inserted or updated
                $siteId = DB::table('sites')->where('name', $siteName)->where('country', $countryName)->value('id');

                foreach ($months as $reportMonth) {
                    // Seed all 8 report tables for this site and month
                    $this->seedReports($siteId, $reportMonth);
                }
            }
        }
    }

    private function seedReports($siteId, $reportMonth)
    {
        // Table 1: Meals
        $pob = rand(1000, 10000);
        DB::table('report_meals')->updateOrInsert(
            ['site_id' => $siteId, 'report_month' => $reportMonth],
            [
                'pob_count' => $pob,
                'total_breakfast' => $pob * 0.8,
                'total_lunch' => $pob * 0.95,
                'total_dinner' => $pob * 0.9,
                'total_pack_meal_supper' => rand(100, 1000),
                'pack_meal_inspection' => rand(10, 50),
                'insect_contamination' => rand(0, 2),
                'object_contamination' => rand(0, 1),
                'created_at' => now(), 'updated_at' => now()
            ]
        );

        // Table 2: Services
        DB::table('report_services')->updateOrInsert(
            ['site_id' => $siteId, 'report_month' => $reportMonth],
            [
                'cat_audit_score' => rand(80, 100) / 10,
                'client_satisfaction_score' => rand(80, 100),
                'number_nc' => rand(0, 10),
                'tiac_detected' => rand(0, 2),
                'haccp_audit_score' => rand(80, 100),
                'cln_audit_score' => rand(80, 100),
                'lau_audit_score' => rand(80, 100),
                'storage_audit_score' => rand(80, 100),
                'storage_inspections' => rand(5, 20),
                'created_at' => now(), 'updated_at' => now()
            ]
        );

        // Table 3: Accidents
        DB::table('report_accidents')->updateOrInsert(
            ['site_id' => $siteId, 'report_month' => $reportMonth],
            [
                'near_miss' => rand(0, 5),
                'first_aid_cases' => rand(0, 3),
                'environmental_incident' => rand(0, 1),
                'mti' => rand(0, 2),
                'lti' => rand(0, 1),
                'rwi' => rand(0, 1),
                'hlv' => rand(0, 3),
                'vehicle_accident' => rand(0, 1),
                'created_at' => now(), 'updated_at' => now()
            ]
        );

        // Table 4: Meetings
        DB::table('report_meetings')->updateOrInsert(
            ['site_id' => $siteId, 'report_month' => $reportMonth],
            [
                'safety_meetings' => rand(4, 20),
                'management_meeting' => rand(1, 4),
                'management_customer_meeting' => rand(1, 4),
                'external_inspection' => rand(0, 2),
                'created_at' => now(), 'updated_at' => now()
            ]
        );

        // Table 5: Vehicles
        $vehicles = rand(5, 20);
        $mileage = $vehicles * rand(500, 2000);
        $fuel = $mileage / rand(7, 15);
        DB::table('report_vehicles')->updateOrInsert(
            ['site_id' => $siteId, 'report_month' => $reportMonth],
            [
                'vehicle_count' => $vehicles,
                'total_mileage_km' => $mileage,
                'vehicle_inspections' => rand(5, 15),
                'fuel_usage_ltr' => $fuel,
                'fuel_consumption_ratio' => ($mileage > 0) ? ($fuel / $mileage) * 100 : 0,
                'internal_audit_score' => rand(70, 100),
                'created_at' => now(), 'updated_at' => now()
            ]
        );

        // Table 6: Medical
        DB::table('report_medical')->updateOrInsert(
            ['site_id' => $siteId, 'report_month' => $reportMonth],
            [
                'consultation' => rand(0, 30),
                'created_at' => now(), 'updated_at' => now()
            ]
        );

        // Table 7: Waste
        $organic = rand(500, 3000);
        $plastic = rand(50, 500);
        $metal = rand(10, 100);
        $total = $organic + $plastic + $metal + rand(100, 500);
        DB::table('report_waste')->updateOrInsert(
            ['site_id' => $siteId, 'report_month' => $reportMonth],
            [
                'organic' => $organic,
                'cooking_oil' => rand(10, 100),
                'wood_timber' => rand(0, 50),
                'carton_paper' => rand(10, 100),
                'metal_steel' => $metal,
                'plastic' => $plastic,
                'glass' => rand(0, 20),
                'other' => rand(0, 50),
                'total' => $total,
                'created_at' => now(), 'updated_at' => now()
            ]
        );

        // Table 8: Others
        DB::table('report_others')->updateOrInsert(
            ['site_id' => $siteId, 'report_month' => $reportMonth],
            [
                'lpg_12kg' => rand(10, 50),
                'lpg_50kg' => rand(5, 20),
                'esg' => rand(60, 100),
                'created_at' => now(), 'updated_at' => now()
            ]
        );
    }
}
