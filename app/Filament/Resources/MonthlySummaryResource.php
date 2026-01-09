<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MonthlySummaryResource\Pages;
use App\Filament\Resources\MonthlySummaryResource\RelationManagers;
use App\Models\MonthlySummary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MonthlySummaryResource extends Resource
{
    protected static ?string $model = MonthlySummary::class;

    protected static ?string $navigationLabel = 'Monthly Summary';

    protected static ?string $pluralModelLabel = 'Monthly Summaries';

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('report_month')
                    ->label('Month')
                    ->date('F Y')
                    ->sortable(),

                // Meals
                Tables\Columns\ColumnGroup::make('On Site', [
                    Tables\Columns\TextColumn::make('pob_count')
                        ->label('POB')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make()),
                    Tables\Columns\TextColumn::make('total_breakfast')
                        ->label('Breakfast')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('total_lunch')
                        ->label('Lunch')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('total_dinner')
                        ->label('Dinner')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('total_pack_meal_supper')
                        ->label('Pack Meal/Supper')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('total_meals')
                        ->label('Total Meals')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make()),
                    Tables\Columns\TextColumn::make('pack_meal_inspection')
                        ->label('Meal Inspection')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('insect_contamination')
                        ->label('Insect Contam.')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('object_contamination')
                        ->label('Object Contam.')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                ]),

                // Services
                Tables\Columns\ColumnGroup::make('Services', [
                    Tables\Columns\TextColumn::make('cat_audit_score')
                        ->label('CAT Audit')
                        ->numeric(2)
                        ->summarize(Tables\Columns\Summarizers\Average::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('client_satisfaction_score')
                        ->label('Client Sat.')
                        ->numeric(2)
                        ->summarize(Tables\Columns\Summarizers\Average::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('number_nc')
                        ->label('Total NCs')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make()),
                    Tables\Columns\TextColumn::make('tiac_detected')
                        ->label('Total TIAC')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make()),
                    Tables\Columns\TextColumn::make('haccp_audit_score')
                        ->label('HACCP Audit')
                        ->numeric(2)
                        ->summarize(Tables\Columns\Summarizers\Average::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('cln_audit_score')
                        ->label('CLN Audit')
                        ->numeric(2)
                        ->summarize(Tables\Columns\Summarizers\Average::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('lau_audit_score')
                        ->label('LAU Audit')
                        ->numeric(2)
                        ->summarize(Tables\Columns\Summarizers\Average::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('storage_audit_score')
                        ->label('Storage Audit')
                        ->numeric(2)
                        ->summarize(Tables\Columns\Summarizers\Average::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('storage_inspections')
                        ->label('Storage Insp.')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                ]),

                // Accidents
                Tables\Columns\ColumnGroup::make('Accidents', [
                    Tables\Columns\TextColumn::make('near_miss')
                        ->label('Near Miss')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make()),
                    Tables\Columns\TextColumn::make('first_aid_cases')
                        ->label('First Aid')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('environmental_incident')
                        ->label('Env. Incident')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('mti')
                        ->label('MTI')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('lti')
                        ->label('LTI')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('rwi')
                        ->label('RWI')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('hlv')
                        ->label('HLV')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('vehicle_accident')
                        ->label('Veh. Accident')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('total_accidents')
                        ->label('Total Accidents')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make()),
                ]),

                // Meetings
                Tables\Columns\ColumnGroup::make('Meetings', [
                    Tables\Columns\TextColumn::make('safety_meetings')
                        ->label('Safety Meet.')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('management_meeting')
                        ->label('Mgmt Meet.')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('management_customer_meeting')
                        ->label('Cust Meet.')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('external_inspection')
                        ->label('Ext. Insp.')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('total_meetings')
                        ->label('Total Meetings')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make()),
                ]),

                // Vehicles
                Tables\Columns\ColumnGroup::make('Vehicles', [
                    Tables\Columns\TextColumn::make('vehicle_count')
                        ->label('Vehicles')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('total_mileage_km')
                        ->label('Mileage (km)')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make()),
                    Tables\Columns\TextColumn::make('vehicle_inspections')
                        ->label('Veh. Insp.')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('fuel_usage_ltr')
                        ->label('Fuel (ltr)')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('fuel_consumption_ratio')
                        ->label('Fuel Ratio')
                        ->numeric(2)
                        ->summarize(Tables\Columns\Summarizers\Average::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('internal_audit_score')
                        ->label('Veh. Audit')
                        ->numeric(2)
                        ->summarize(Tables\Columns\Summarizers\Average::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                ]),

                // Medical
                Tables\Columns\ColumnGroup::make('Medical', [
                    Tables\Columns\TextColumn::make('consultation')
                        ->label('Consultations')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make()),
                ]),

                // Waste
                Tables\Columns\ColumnGroup::make('Waste', [
                    Tables\Columns\TextColumn::make('organic')
                        ->label('Organic')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('cooking_oil')
                        ->label('Cook. Oil')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('wood_timber')
                        ->label('Wood')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('carton_paper')
                        ->label('Carton')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('metal_steel')
                        ->label('Metal')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('plastic')
                        ->label('Plastic')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('glass')
                        ->label('Glass')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('other_waste')
                        ->label('Other Waste')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('total_waste')
                        ->label('Total Waste')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make()),
                ]),

                // Others
                Tables\Columns\ColumnGroup::make('Others', [
                    Tables\Columns\TextColumn::make('lpg_12kg')
                        ->label('LPG 12kg')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make()),
                    Tables\Columns\TextColumn::make('lpg_50kg')
                        ->label('LPG 50kg')
                        ->numeric()
                        ->summarize(Tables\Columns\Summarizers\Sum::make()),
                    Tables\Columns\TextColumn::make('esg')
                        ->label('ESG')
                        ->numeric(2)
                        ->summarize(Tables\Columns\Summarizers\Average::make())
                        ->toggleable(isToggledHiddenByDefault: true),
                ]),
            ])
            ->defaultSort('report_month', 'desc')
            ->groups([
                Tables\Grouping\Group::make('country')
                    ->label('Country')
                    ->collapsible(),
                Tables\Grouping\Group::make('report_month')
                    ->label('Month')
                    ->date('F Y')
                    ->collapsible(),
            ])
            ->columnToggleFormWidth('4xl')
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        // Start from a clean query on the model
        $query = MonthlySummary::query();

        // Subquery for meals
        $mealsQuery = \App\Models\ReportMeal::query()
            ->join('sites', 'report_meals.site_id', '=', 'sites.id')
            ->selectRaw('
                sites.country,
                report_month,
                SUM(pob_count) as pob_count,
                SUM(total_breakfast) as total_breakfast,
                SUM(total_lunch) as total_lunch,
                SUM(total_dinner) as total_dinner,
                SUM(total_pack_meal_supper) as total_pack_meal_supper,
                SUM(total_breakfast + total_lunch + total_dinner + total_pack_meal_supper) as total_meals,
                SUM(pack_meal_inspection) as pack_meal_inspection,
                SUM(insect_contamination) as insect_contamination,
                SUM(object_contamination) as object_contamination
            ')
            ->groupBy('sites.country', 'report_month');

        // Subquery for services
        $servicesQuery = \App\Models\ReportService::query()
            ->join('sites', 'report_services.site_id', '=', 'sites.id')
            ->selectRaw('
                sites.country,
                report_month,
                AVG(cat_audit_score) as cat_audit_score,
                AVG(client_satisfaction_score) as client_satisfaction_score,
                SUM(number_nc) as number_nc,
                SUM(tiac_detected) as tiac_detected,
                AVG(haccp_audit_score) as haccp_audit_score,
                AVG(cln_audit_score) as cln_audit_score,
                AVG(lau_audit_score) as lau_audit_score,
                AVG(storage_audit_score) as storage_audit_score,
                SUM(storage_inspections) as storage_inspections
            ')
            ->groupBy('sites.country', 'report_month');

        // Subquery for accidents
        $accidentsQuery = \App\Models\ReportAccident::query()
            ->join('sites', 'report_accidents.site_id', '=', 'sites.id')
            ->selectRaw('
                sites.country,
                report_month,
                SUM(near_miss) as near_miss,
                SUM(first_aid_cases) as first_aid_cases,
                SUM(environmental_incident) as environmental_incident,
                SUM(mti) as mti,
                SUM(lti) as lti,
                SUM(rwi) as rwi,
                SUM(hlv) as hlv,
                SUM(vehicle_accident) as vehicle_accident,
                SUM(near_miss + first_aid_cases + environmental_incident + mti + lti + rwi + hlv + vehicle_accident) as total_accidents
            ')
            ->groupBy('sites.country', 'report_month');

        // Subquery for meetings
        $meetingsQuery = \App\Models\ReportMeeting::query()
            ->join('sites', 'report_meetings.site_id', '=', 'sites.id')
            ->selectRaw('
                sites.country,
                report_month,
                SUM(safety_meetings) as safety_meetings,
                SUM(management_meeting) as management_meeting,
                SUM(management_customer_meeting) as management_customer_meeting,
                SUM(external_inspection) as external_inspection,
                SUM(safety_meetings + management_meeting + management_customer_meeting + external_inspection) as total_meetings
            ')
            ->groupBy('sites.country', 'report_month');

        // Subquery for vehicles
        $vehiclesQuery = \App\Models\ReportVehicle::query()
            ->join('sites', 'report_vehicles.site_id', '=', 'sites.id')
            ->selectRaw('
                sites.country,
                report_month,
                SUM(vehicle_count) as vehicle_count,
                SUM(total_mileage_km) as total_mileage_km,
                SUM(vehicle_inspections) as vehicle_inspections,
                SUM(fuel_usage_ltr) as fuel_usage_ltr,
                AVG(fuel_consumption_ratio) as fuel_consumption_ratio,
                AVG(internal_audit_score) as internal_audit_score
            ')
            ->groupBy('sites.country', 'report_month');

        // Subquery for medical
        $medicalQuery = \App\Models\ReportMedical::query()
            ->join('sites', 'report_medical.site_id', '=', 'sites.id')
            ->selectRaw('sites.country, report_month, SUM(consultation) as consultation')
            ->groupBy('sites.country', 'report_month');

        // Subquery for waste
        $wasteQuery = \App\Models\ReportWaste::query()
            ->join('sites', 'report_waste.site_id', '=', 'sites.id')
            ->selectRaw('
                sites.country,
                report_month,
                SUM(organic) as organic,
                SUM(cooking_oil) as cooking_oil,
                SUM(wood_timber) as wood_timber,
                SUM(carton_paper) as carton_paper,
                SUM(metal_steel) as metal_steel,
                SUM(plastic) as plastic,
                SUM(glass) as glass,
                SUM(other) as other_waste,
                SUM(total) as total_waste
            ')
            ->groupBy('sites.country', 'report_month');

        // Subquery for others
        $othersQuery = \App\Models\ReportOther::query()
            ->join('sites', 'report_others.site_id', '=', 'sites.id')
            ->selectRaw('
                sites.country,
                report_month,
                SUM(lpg_12kg) as lpg_12kg,
                SUM(lpg_50kg) as lpg_50kg,
                AVG(esg) as esg
            ')
            ->groupBy('sites.country', 'report_month');

        // Get all unique country-month pairs across all report tables
        $allMonthsQuery = \App\Models\ReportMeal::query()->join('sites', 'report_meals.site_id', '=', 'sites.id')->select('sites.country', 'report_month')
            ->union(\App\Models\ReportAccident::query()->join('sites', 'report_accidents.site_id', '=', 'sites.id')->select('sites.country', 'report_month'))
            ->union(\App\Models\ReportMeeting::query()->join('sites', 'report_meetings.site_id', '=', 'sites.id')->select('sites.country', 'report_month'))
            ->union(\App\Models\ReportVehicle::query()->join('sites', 'report_vehicles.site_id', '=', 'sites.id')->select('sites.country', 'report_month'))
            ->union(\App\Models\ReportWaste::query()->join('sites', 'report_waste.site_id', '=', 'sites.id')->select('sites.country', 'report_month'))
            ->union(\App\Models\ReportService::query()->join('sites', 'report_services.site_id', '=', 'sites.id')->select('sites.country', 'report_month'))
            ->union(\App\Models\ReportMedical::query()->join('sites', 'report_medical.site_id', '=', 'sites.id')->select('sites.country', 'report_month'))
            ->union(\App\Models\ReportOther::query()->join('sites', 'report_others.site_id', '=', 'sites.id')->select('sites.country', 'report_month'));

        $query->fromSub($allMonthsQuery, 'all_months')
            ->leftJoinSub($mealsQuery, 'meals', function ($join) {
                $join->on('all_months.report_month', '=', 'meals.report_month')
                    ->on('all_months.country', '=', 'meals.country');
            })
            ->leftJoinSub($servicesQuery, 'services', function ($join) {
                $join->on('all_months.report_month', '=', 'services.report_month')
                    ->on('all_months.country', '=', 'services.country');
            })
            ->leftJoinSub($accidentsQuery, 'accidents', function ($join) {
                $join->on('all_months.report_month', '=', 'accidents.report_month')
                    ->on('all_months.country', '=', 'accidents.country');
            })
            ->leftJoinSub($meetingsQuery, 'meetings', function ($join) {
                $join->on('all_months.report_month', '=', 'meetings.report_month')
                    ->on('all_months.country', '=', 'meetings.country');
            })
            ->leftJoinSub($vehiclesQuery, 'vehicles', function ($join) {
                $join->on('all_months.report_month', '=', 'vehicles.report_month')
                    ->on('all_months.country', '=', 'vehicles.country');
            })
            ->leftJoinSub($medicalQuery, 'medical', function ($join) {
                $join->on('all_months.report_month', '=', 'medical.report_month')
                    ->on('all_months.country', '=', 'medical.country');
            })
            ->leftJoinSub($wasteQuery, 'waste', function ($join) {
                $join->on('all_months.report_month', '=', 'waste.report_month')
                    ->on('all_months.country', '=', 'waste.country');
            })
            ->leftJoinSub($othersQuery, 'others', function ($join) {
                $join->on('all_months.report_month', '=', 'others.report_month')
                    ->on('all_months.country', '=', 'others.country');
            })
            ->select([
                'all_months.country',
                'all_months.report_month',
            ])
            ->selectRaw("CONCAT(all_months.country, '_', all_months.report_month) as id")
            // Meals
            ->selectRaw('COALESCE(meals.pob_count, 0) as pob_count')
            ->selectRaw('COALESCE(meals.total_breakfast, 0) as total_breakfast')
            ->selectRaw('COALESCE(meals.total_lunch, 0) as total_lunch')
            ->selectRaw('COALESCE(meals.total_dinner, 0) as total_dinner')
            ->selectRaw('COALESCE(meals.total_pack_meal_supper, 0) as total_pack_meal_supper')
            ->selectRaw('COALESCE(meals.total_meals, 0) as total_meals')
            ->selectRaw('COALESCE(meals.pack_meal_inspection, 0) as pack_meal_inspection')
            ->selectRaw('COALESCE(meals.insect_contamination, 0) as insect_contamination')
            ->selectRaw('COALESCE(meals.object_contamination, 0) as object_contamination')
            // Services
            ->selectRaw('COALESCE(services.cat_audit_score, 0) as cat_audit_score')
            ->selectRaw('COALESCE(services.client_satisfaction_score, 0) as client_satisfaction_score')
            ->selectRaw('COALESCE(services.number_nc, 0) as number_nc')
            ->selectRaw('COALESCE(services.tiac_detected, 0) as tiac_detected')
            ->selectRaw('COALESCE(services.haccp_audit_score, 0) as haccp_audit_score')
            ->selectRaw('COALESCE(services.cln_audit_score, 0) as cln_audit_score')
            ->selectRaw('COALESCE(services.lau_audit_score, 0) as lau_audit_score')
            ->selectRaw('COALESCE(services.storage_audit_score, 0) as storage_audit_score')
            ->selectRaw('COALESCE(services.storage_inspections, 0) as storage_inspections')
            // Accidents
            ->selectRaw('COALESCE(accidents.near_miss, 0) as near_miss')
            ->selectRaw('COALESCE(accidents.first_aid_cases, 0) as first_aid_cases')
            ->selectRaw('COALESCE(accidents.environmental_incident, 0) as environmental_incident')
            ->selectRaw('COALESCE(accidents.mti, 0) as mti')
            ->selectRaw('COALESCE(accidents.lti, 0) as lti')
            ->selectRaw('COALESCE(accidents.rwi, 0) as rwi')
            ->selectRaw('COALESCE(accidents.hlv, 0) as hlv')
            ->selectRaw('COALESCE(accidents.vehicle_accident, 0) as vehicle_accident')
            ->selectRaw('COALESCE(accidents.total_accidents, 0) as total_accidents')
            // Meetings
            ->selectRaw('COALESCE(meetings.safety_meetings, 0) as safety_meetings')
            ->selectRaw('COALESCE(meetings.management_meeting, 0) as management_meeting')
            ->selectRaw('COALESCE(meetings.management_customer_meeting, 0) as management_customer_meeting')
            ->selectRaw('COALESCE(meetings.external_inspection, 0) as external_inspection')
            ->selectRaw('COALESCE(meetings.total_meetings, 0) as total_meetings')
            // Vehicles
            ->selectRaw('COALESCE(vehicles.vehicle_count, 0) as vehicle_count')
            ->selectRaw('COALESCE(vehicles.total_mileage_km, 0) as total_mileage_km')
            ->selectRaw('COALESCE(vehicles.vehicle_inspections, 0) as vehicle_inspections')
            ->selectRaw('COALESCE(vehicles.fuel_usage_ltr, 0) as fuel_usage_ltr')
            ->selectRaw('COALESCE(vehicles.fuel_consumption_ratio, 0) as fuel_consumption_ratio')
            ->selectRaw('COALESCE(vehicles.internal_audit_score, 0) as internal_audit_score')
            // Medical
            ->selectRaw('COALESCE(medical.consultation, 0) as consultation')
            // Waste
            ->selectRaw('COALESCE(waste.organic, 0) as organic')
            ->selectRaw('COALESCE(waste.cooking_oil, 0) as cooking_oil')
            ->selectRaw('COALESCE(waste.wood_timber, 0) as wood_timber')
            ->selectRaw('COALESCE(waste.carton_paper, 0) as carton_paper')
            ->selectRaw('COALESCE(waste.metal_steel, 0) as metal_steel')
            ->selectRaw('COALESCE(waste.plastic, 0) as plastic')
            ->selectRaw('COALESCE(waste.glass, 0) as glass')
            ->selectRaw('COALESCE(waste.other_waste, 0) as other_waste')
            ->selectRaw('COALESCE(waste.total_waste, 0) as total_waste')
            // Others
            ->selectRaw('COALESCE(others.lpg_12kg, 0) as lpg_12kg')
            ->selectRaw('COALESCE(others.lpg_50kg, 0) as lpg_50kg')
            ->selectRaw('COALESCE(others.esg, 0) as esg');

        return $query;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMonthlySummaries::route('/'),
        ];
    }
}
