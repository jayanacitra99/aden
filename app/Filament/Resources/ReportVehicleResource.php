<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportVehicleResource\Pages;
use App\Models\ReportVehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportVehicleResource extends Resource
{
    protected static ?string $model = ReportVehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Monthly Reports';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Report Info')->columns(2)->schema([
                    Forms\Components\Select::make('site_id')->relationship('site', 'name')->required(),
                    Forms\Components\DatePicker::make('report_month')->required(),
                ]),

                Forms\Components\Section::make('11. Vehicles')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('vehicle_count')->label('Number of Vehicles')->numeric(),
                        Forms\Components\TextInput::make('vehicle_inspections')->numeric(),
                        Forms\Components\TextInput::make('total_mileage_km')->label('Total Mileage (KMs)')->numeric()->suffix('km'),
                        Forms\Components\TextInput::make('fuel_usage_ltr')->label('Fuel Usage (Ltr)')->numeric()->suffix('L'),
                        Forms\Components\TextInput::make('fuel_consumption_ratio')->label('Fuel Consumption (ltr/100km)')->numeric(),
                        Forms\Components\TextInput::make('internal_audit_score')->label('Internal Audit Score (%)')->numeric()->suffix('%'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('report_month')->date('M Y'),

                Tables\Columns\TextColumn::make('vehicle_count')->label('Qty')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('total_mileage_km')->label('Mileage (km)')->numeric(),
                Tables\Columns\TextColumn::make('vehicle_inspections')->label('Insp.')->numeric(),
                Tables\Columns\TextColumn::make('fuel_usage_ltr')->label('Fuel (L)')->numeric(),
                Tables\Columns\TextColumn::make('fuel_consumption_ratio')->label('L/100km')->numeric(),
                Tables\Columns\TextColumn::make('internal_audit_score')->label('Audit %')->numeric(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReportVehicles::route('/'),
            'create' => Pages\CreateReportVehicle::route('/create'),
            'edit' => Pages\EditReportVehicle::route('/{record}/edit'),
        ];
    }
}
