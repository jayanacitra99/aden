<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportServicesResource\Pages;
use App\Filament\Resources\ReportServicesResource\RelationManagers;
use App\Models\ReportService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportServicesResource extends Resource
{
    protected static ?string $model = ReportService::class;

    protected static ?string $navigationIcon = 'heroicon-o-cake';
    protected static ?string $navigationGroup = 'Monthly Reports';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Report Info')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('site_id')
                            ->relationship('site', 'name')
                            ->required()
                            ->searchable(),
                        Forms\Components\DatePicker::make('report_month')
                            ->required(),
                    ]),

                Forms\Components\Section::make('1. On Site Data')
                    ->description('POB, Meals Served, and Contamination')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('pob_count')
                            ->label('POB (Aden + Client + Visitors)')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('total_served')
                            ->label('Total Meals Served')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('pack_meal_inspection')
                            ->label('Pack Meal Inspection')
                            ->numeric()
                            ->default(0),
                    ]),

                Forms\Components\Section::make('Meal Breakdown')
                    ->columns(4)
                    ->schema([
                        Forms\Components\TextInput::make('total_breakfast')->numeric()->default(0),
                        Forms\Components\TextInput::make('total_lunch')->numeric()->default(0),
                        Forms\Components\TextInput::make('total_dinner')->numeric()->default(0),
                        Forms\Components\TextInput::make('total_pack_meal_supper')
                            ->label('Total Pack Meal / Supper')
                            ->numeric()
                            ->default(0),
                    ]),

                Forms\Components\Section::make('Contamination Cases')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('insect_contamination')
                            ->label('Cases: Insects')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('object_contamination')
                            ->label('Cases: Objects')
                            ->numeric()
                            ->default(0),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site.name')->sortable()->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('report_month')->date('M Y'),

                // Catering Section
                Tables\Columns\TextColumn::make('cat_audit_score')->label('CAT Audit')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('client_satisfaction_score')->label('Client Sat %')->numeric(),
                Tables\Columns\TextColumn::make('number_nc')->label('NCR')->numeric()
                    ->color(fn ($state) => $state > 0 ? 'danger' : 'success'),
                Tables\Columns\TextColumn::make('tiac_detected')->label('TIAC')->numeric()
                    ->color(fn ($state) => $state > 0 ? 'danger' : 'success'),
                Tables\Columns\TextColumn::make('haccp_audit_score')->label('HACCP')->numeric()->toggleable(),

                // Other Services
                Tables\Columns\TextColumn::make('cln_audit_score')->label('Cleaning')->numeric(),
                Tables\Columns\TextColumn::make('lau_audit_score')->label('Laundry')->numeric(),
                Tables\Columns\TextColumn::make('storage_audit_score')->label('Storage')->numeric(),
                Tables\Columns\TextColumn::make('storage_inspections')->label('Strg Insp')->numeric(),
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
            'index' => Pages\ListReportServices::route('/'),
            'create' => Pages\CreateReportServices::route('/create'),
            'edit' => Pages\EditReportServices::route('/{record}/edit'),
        ];
    }
}
