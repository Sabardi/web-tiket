<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingTransactionResource\Pages;
use App\Filament\Resources\BookingTransactionResource\RelationManagers;
use App\Models\BookingTransaction;
use App\Models\Ticket;
use Filament\Actions\Modal\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingTransactionResource extends Resource
{
    protected static ?string $model = BookingTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Customer';

    public static function getNavigationBadge(): ?string
    {
        return (string) BookingTransaction::where('is_paid', false)->count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Product & Price')
                        ->schema([
                            Select::make('ticket_id')
                                ->relationship('ticket', 'name')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->reactive()
                                ->label('Ticket')
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $ticket =  Ticket::find($state);
                                    $set('price', $ticket ? $ticket->price : 0);
                                }),

                            TextInput::make('total_participant')
                                ->required()
                                ->numeric()
                                ->prefix('peaple')
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    $price = $get('price');
                                    $subtotal = $price * $state;
                                    $totalPpn = $subtotal * 0.11;
                                    $totalAmount = $subtotal * $totalPpn;

                                    $set('total_amount', $totalAmount);
                                })
                                ->label('Total Participants'),

                            TextInput::make('total_amount')
                                ->required()
                                ->numeric()
                                ->prefix('IDR')
                                ->readOnly()
                                ->helperText('Harga sudah include ppn 11%')
                        ]),
                    Step::make('Costemer Information')
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('phone_number')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('email')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('booking_trx_id')
                                ->required()
                                ->maxLength(255),
                        ]),
                    Step::make('Payment Information')
                        ->schema([
                            ToggleButtons::make('is_paid')
                                ->label('Apakah sudah membayar')
                                ->boolean()
                                ->icons([
                                    true => 'heroicon-o-pencil',
                                    false => 'heroicon-o-clock',
                                ])
                                ->required(),

                            FileUpload::make('proof')
                                ->image()
                                ->label('Upload bukti pembayaran')
                                ->required(),

                            DatePicker::make('started_at')
                                ->required()
                                ->label('Start At'),
                        ]),
                ])
                    ->columnSpan('full')
                    ->columns(1)
                    ->skippable(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                ImageColumn::make('ticket.tumbnail'),

                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('booking_trx_id')
                    ->searchable(),

                IconColumn::make('is_paid')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->label('Terverifikasi'),


            ])
            ->filters([
                SelectFilter::make('ticket_id')
                    ->label('Ticket')
                    ->relationship('ticket', 'name'),
            ])
            ->actions([

                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->action(function (BookingTransaction $record) {
                        $record->is_paid = true;
                        $record->save();

                        Notification::make()
                            ->title('Ticket Approved')
                            ->success()
                            ->body('The Ticket has been approved.')
                            ->send();
                    })
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn(BookingTransaction $record) => !$record->is_paid),

                Tables\Actions\EditAction::make(),

                Tables\Actions\ViewAction::make(),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListBookingTransactions::route('/'),
            'create' => Pages\CreateBookingTransaction::route('/create'),
            'edit' => Pages\EditBookingTransaction::route('/{record}/edit'),
        ];
    }
}
