<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportWasteResource\Pages;
use App\Filament\Resources\ReportWasteResource\RelationManagers;
use App\Models\ReportWaste;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportWasteResource extends Resource
{
    protected static ?string $model = ReportWaste::class;

    protected static ?string $navigationIcon = 'heroicon-o-trash';
    protected static ?string $navigationGroup = 'Monthly Reports';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Report Info')->columns(2)->schema([
                    Forms\Components\Select::make('site_id')->relationship('site', 'name')->required(),
                    Forms\Components\DatePicker::make('report_month')->required(),
                ]),

                Forms\Components\Section::make('14. Waste (KG)')
                    ->description('All values in Kilograms')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('organic')->numeric()->default(0)->suffix('kg'),
                        Forms\Components\TextInput::make('cooking_oil')->numeric()->default(0)->suffix('kg'),
                        Forms\Components\TextInput::make('wood_timber')->numeric()->default(0)->suffix('kg'),
                        Forms\Components\TextInput::make('carton_paper')->numeric()->default(0)->suffix('kg'),
                        Forms\Components\TextInput::make('metal_steel')->numeric()->default(0)->suffix('kg'),
                        Forms\Components\TextInput::make('plastic')->numeric()->default(0)->suffix('kg'),
                        Forms\Components\TextInput::make('glass')->numeric()->default(0)->suffix('kg'),
                        Forms\Components\TextInput::make('other')->numeric()->default(0)->suffix('kg'),

                        Forms\Components\TextInput::make('total')
                            ->label('TOTAL')
                            ->numeric()
                            ->default(0)
                            ->suffix('kg')
                            ->columnSpanFull()
                            ->extraInputAttributes(['class' => 'font-bold bg-gray-100']),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site.name')->sortable()->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('report_month')->date('M Y'),

                // Total is most important
                Tables\Columns\TextColumn::make('total')->label('Total (kg)')->weight('bold')->sortable(),

                // Breakdown (All Toggleable)
                Tables\Columns\TextColumn::make('organic')->label('Organic')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('cooking_oil')->label('Oil')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('wood_timber')->label('Wood')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('carton_paper')->label('Paper')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('metal_steel')->label('Metal')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('plastic')->label('Plastic')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('glass')->label('Glass')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('other')->label('Other')->numeric()->toggleable(),
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
            'index' => Pages\ListReportWastes::route('/'),
            'create' => Pages\CreateReportWaste::route('/create'),
            'edit' => Pages\EditReportWaste::route('/{record}/edit'),
        ];
    }
}
