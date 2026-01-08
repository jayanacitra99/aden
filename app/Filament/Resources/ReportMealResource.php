<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportMealResource\Pages;
use App\Models\ReportMeal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportMealResource extends Resource
{
    protected static ?string $model = ReportMeal::class;

    // Icon and Navigation Grouping
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
                Tables\Columns\TextColumn::make('site.name')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'), // "fixed()" removed

                Tables\Columns\TextColumn::make('report_month')
                    ->date('M Y')
                    ->sortable(),

                // Section 1: POB & Totals
                Tables\Columns\TextColumn::make('pob_count')->label('POB')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('total_served')->label('Total Served')->numeric()->weight('bold'),

                // Meal Breakdown (Toggleable)
                Tables\Columns\TextColumn::make('total_breakfast')->label('Bkfast')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('total_lunch')->label('Lunch')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('total_dinner')->label('Dinner')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('total_pack_meal_supper')->label('Supper/Pack')->numeric()->toggleable(),

                // Inspections & Contamination
                Tables\Columns\TextColumn::make('pack_meal_inspection')->label('Insp.')->numeric(),
                Tables\Columns\TextColumn::make('insect_contamination')
                    ->label('Insect Cases')
                    ->numeric()
                    ->color(fn ($state) => $state > 0 ? 'danger' : 'gray'),
                Tables\Columns\TextColumn::make('object_contamination')
                    ->label('Object Cases')
                    ->numeric()
                    ->color(fn ($state) => $state > 0 ? 'danger' : 'gray'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('report_month', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReportMeals::route('/'),
            'create' => Pages\CreateReportMeal::route('/create'),
            'edit' => Pages\EditReportMeal::route('/{record}/edit'),
        ];
    }
}
