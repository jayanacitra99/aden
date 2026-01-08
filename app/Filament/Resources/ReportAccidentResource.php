<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportAccidentResource\Pages;
use App\Filament\Resources\ReportAccidentResource\RelationManagers;
use App\Models\ReportAccident;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportAccidentResource extends Resource
{
    protected static ?string $model = ReportAccident::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';
    protected static ?string $navigationGroup = 'Monthly Reports';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Report Info')->columns(2)->schema([
                    Forms\Components\Select::make('site_id')->relationship('site', 'name')->required(),
                    Forms\Components\DatePicker::make('report_month')->required(),
                ]),

                Forms\Components\Section::make('8. Accident Statistics')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('near_miss')->numeric()->default(0),
                        Forms\Components\TextInput::make('first_aid_cases')->label('First Aid Cases')->numeric()->default(0),
                        Forms\Components\TextInput::make('environmental_incident')->label('Env. Incident')->numeric()->default(0),
                        Forms\Components\TextInput::make('mti')->label('MTI')->numeric()->default(0),
                        Forms\Components\TextInput::make('lti')->label('LTI')->numeric()->default(0),
                        Forms\Components\TextInput::make('rwi')->label('RWI')->numeric()->default(0),
                        Forms\Components\TextInput::make('hlv')->label('HLV')->numeric()->default(0),
                        Forms\Components\TextInput::make('vehicle_accident')->numeric()->default(0),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('report_month')->date('M Y'),

                // Critical Incidents (Red if > 0)
                Tables\Columns\TextColumn::make('lti')->label('LTI')
                    ->numeric()->sortable()->color(fn ($state) => $state > 0 ? 'danger' : 'gray'),
                Tables\Columns\TextColumn::make('mti')->label('MTI')
                    ->numeric()->sortable()->color(fn ($state) => $state > 0 ? 'danger' : 'gray'),
                Tables\Columns\TextColumn::make('rwi')->label('RWI')
                    ->numeric()->color(fn ($state) => $state > 0 ? 'danger' : 'gray'),
                Tables\Columns\TextColumn::make('hlv')->label('HLV')
                    ->numeric()->color(fn ($state) => $state > 0 ? 'danger' : 'gray'),

                // Other Incidents
                Tables\Columns\TextColumn::make('near_miss')->label('Near Miss')->numeric(),
                Tables\Columns\TextColumn::make('first_aid_cases')->label('First Aid')->numeric(),
                Tables\Columns\TextColumn::make('environmental_incident')->label('Env Inc')->numeric(),
                Tables\Columns\TextColumn::make('vehicle_accident')->label('Veh Acc')->numeric(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReportAccidents::route('/'),
            'create' => Pages\CreateReportAccident::route('/create'),
            'edit' => Pages\EditReportAccident::route('/{record}/edit'),
        ];
    }
}
