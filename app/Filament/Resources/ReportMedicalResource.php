<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportMedicalResource\Pages;
use App\Filament\Resources\ReportMedicalResource\RelationManagers;
use App\Models\ReportMedical;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportMedicalResource extends Resource
{
    protected static ?string $model = ReportMedical::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $navigationGroup = 'Monthly Reports';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Report Info')->columns(2)->schema([
                    Forms\Components\Select::make('site_id')->relationship('site', 'name')->required(),
                    Forms\Components\DatePicker::make('report_month')->required(),
                ]),

                Forms\Components\Section::make('12. Medical')
                    ->schema([
                        Forms\Components\TextInput::make('consultation')->label('Consultations')->numeric()->default(0),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('report_month')->date('M Y'),

                Tables\Columns\TextColumn::make('consultation')
                    ->label('Total Consultations')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListReportMedicals::route('/'),
            'create' => Pages\CreateReportMedical::route('/create'),
            'edit' => Pages\EditReportMedical::route('/{record}/edit'),
        ];
    }
}
