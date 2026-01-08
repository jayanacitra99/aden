<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportMeetingResource\Pages;
use App\Filament\Resources\ReportMeetingResource\RelationManagers;
use App\Models\ReportMeeting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportMeetingResource extends Resource
{
    protected static ?string $model = ReportMeeting::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Monthly Reports';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Report Info')->columns(2)->schema([
                    Forms\Components\Select::make('site_id')->relationship('site', 'name')->required(),
                    Forms\Components\DatePicker::make('report_month')->required(),
                ]),

                Forms\Components\Section::make('10. Meetings & Inspections')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('safety_meetings')->numeric()->default(0),
                        Forms\Components\TextInput::make('management_meeting')->numeric()->default(0),
                        Forms\Components\TextInput::make('management_customer_meeting')
                            ->label('Mgmt & Customer Meeting')
                            ->numeric()->default(0),
                        Forms\Components\TextInput::make('external_inspection')->numeric()->default(0),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('report_month')->date('M Y'),

                Tables\Columns\TextColumn::make('safety_meetings')->label('Safety Mtg')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('management_meeting')->label('Mgmt Mtg')->numeric(),
                Tables\Columns\TextColumn::make('management_customer_meeting')->label('Cust Mtg')->numeric(),
                Tables\Columns\TextColumn::make('external_inspection')->label('Ext Insp')->numeric(),
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
            'index' => Pages\ListReportMeetings::route('/'),
            'create' => Pages\CreateReportMeeting::route('/create'),
            'edit' => Pages\EditReportMeeting::route('/{record}/edit'),
        ];
    }
}
