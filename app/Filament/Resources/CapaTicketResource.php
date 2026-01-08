<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CapaTicketResource\Pages;
use App\Models\CapaTicket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CapaTicketResource extends Resource
{
    protected static ?string $model = CapaTicket::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'CAPA Tickets';
    protected static ?string $navigationGroup = 'Operations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Finding Details')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('site_id')
                            ->relationship('site', 'name')
                            ->required(),
                        Forms\Components\DatePicker::make('finding_date')
                            ->required(),
                        Forms\Components\TextInput::make('area')
                            ->placeholder('e.g. Kitchen - Cold Storage'),
                        Forms\Components\Select::make('risk_rank')
                            ->options([
                                'Low Risk' => 'Low Risk',
                                'Moderate Risk' => 'Moderate Risk',
                                'Elevated Risk' => 'Elevated Risk',
                                'Extreme Risk' => 'Extreme Risk',
                            ])
                            ->required(),
                        Forms\Components\Select::make('risk_type')
                            ->options([
                                'Risk of cross-contamination' => 'Risk of cross-contamination',
                                'Risk of electrocution' => 'Risk of electrocution',
                                'Other' => 'Other',
                            ]),
                        Forms\Components\Textarea::make('comment')
                            ->label('Finding Description')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Evidence & Action')
                    ->columns(2)
                    ->schema([
                        Forms\Components\FileUpload::make('photo_before_path')
                            ->label('Photo Before')
                            ->image()
                            ->directory('capa-photos'),
                        Forms\Components\FileUpload::make('photo_after_path')
                            ->label('Photo After')
                            ->image()
                            ->directory('capa-photos'),
                        Forms\Components\Select::make('pic_name')
                            ->label('Person In Charge')
                            ->options([
                                'Maintenance' => 'Maintenance',
                                'Client' => 'Client',
                                'Cook - Head/SPV' => 'Cook - Head/SPV',
                                'Service - SPV' => 'Service - SPV',
                            ]),
                        Forms\Components\Textarea::make('proposed_solution')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Status')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'OPEN' => 'Open',
                                'ON PROGRESS' => 'On Progress',
                                'CLOSED' => 'Closed',
                            ])
                            ->default('OPEN')
                            ->required(),
                        Forms\Components\DatePicker::make('due_date'),
                        Forms\Components\DatePicker::make('realization_date'),
                        Forms\Components\Toggle::make('is_late')
                            ->label('Is Late?')
                            ->onColor('danger')
                            ->offColor('success'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo_before_path')
                    ->label('Photo')
                    ->circular(),
                Tables\Columns\TextColumn::make('site.name')->sortable(),
                Tables\Columns\TextColumn::make('finding_date')->date()->sortable(),
                Tables\Columns\TextColumn::make('controlled_by')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('area')->searchable(),
                Tables\Columns\TextColumn::make('risk_type')->searchable(),
                Tables\Columns\TextColumn::make('risk_rank')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Extreme Risk' => 'danger',
                        'Elevated Risk' => 'warning',
                        'Moderate Risk' => 'warning',
                        'Low Risk' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('comment')
                    ->label('Finding')
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('pic_name')->label('PIC')->toggleable(),
                Tables\Columns\TextColumn::make('proposed_solution')->limit(50)->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OPEN' => 'danger',
                        'ON PROGRESS' => 'warning',
                        'CLOSED' => 'success',
                    }),
                Tables\Columns\TextColumn::make('given_days')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('due_date')->date()->sortable(),
                Tables\Columns\TextColumn::make('realization_date')->date()->toggleable(),
                Tables\Columns\ImageColumn::make('photo_after_path')
                    ->label('Photo After')
                    ->circular()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_late')
                    ->label('Late')
                    ->boolean()
                    ->trueIcon('heroicon-o-x-circle')
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueColor('danger')
                    ->falseColor('success'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'OPEN' => 'Open',
                        'ON PROGRESS' => 'On Progress',
                        'CLOSED' => 'Closed',
                    ]),
                Tables\Filters\SelectFilter::make('site')
                    ->relationship('site', 'name'),
                Tables\Filters\TernaryFilter::make('is_late')
                    ->label('Late Status')
                    ->placeholder('All')
                    ->trueLabel('Late')
                    ->falseLabel('On Time'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCapaTickets::route('/'),
            'create' => Pages\CreateCapaTicket::route('/create'),
            'edit' => Pages\EditCapaTicket::route('/{record}/edit'),
        ];
    }
}
