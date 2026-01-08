<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportOtherResource\Pages;
use App\Filament\Resources\ReportOtherResource\RelationManagers;
use App\Models\ReportOther;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportOtherResource extends Resource
{
    protected static ?string $model = ReportOther::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Monthly Reports';
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Report Info')->columns(2)->schema([
                    Forms\Components\Select::make('site_id')->relationship('site', 'name')->required(),
                    Forms\Components\DatePicker::make('report_month')->required(),
                ]),

                Forms\Components\Section::make('Other Data')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('lpg_12kg')->label('LPG 12 Kg')->numeric()->default(0),
                        Forms\Components\TextInput::make('lpg_50kg')->label('LPG 50 Kg')->numeric()->default(0),
                        Forms\Components\TextInput::make('esg')->label('ESG Score')->numeric()->default(0),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('report_month')->date('M Y'),

                Tables\Columns\TextColumn::make('lpg_12kg')->label('LPG 12kg')->numeric(),
                Tables\Columns\TextColumn::make('lpg_50kg')->label('LPG 50kg')->numeric(),
                Tables\Columns\TextColumn::make('esg')->label('ESG Score')->numeric()->sortable(),
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
            'index' => Pages\ListReportOthers::route('/'),
            'create' => Pages\CreateReportOther::route('/create'),
            'edit' => Pages\EditReportOther::route('/{record}/edit'),
        ];
    }
}
