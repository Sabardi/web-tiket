<?php

namespace App\Filament\Resources\BookingTransactionResource\Pages;

use App\Filament\Resources\BookingTransactionResource;
use App\Filament\Resources\BookingTransactionResource\Widgets\BookingTransactionsStats;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookingTransactions extends ListRecords
{
    protected static string $resource = BookingTransactionResource::class;

    // Use the correct plural form for the method name
    protected function getHeaderWidgets(): array
    {
        return [
            BookingTransactionsStats::class,
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
