<?php

namespace App\Filament\Resources\BookingTransactionResource\Widgets;

use App\Models\BookingTransaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingTransactionsStats extends BaseWidget
{
    protected function getStats(): array
    {
        $totalTransaction = BookingTransaction::count();
        $approvedTransaction = BookingTransaction::where('is_paid', true)->count();
        $totalRevenue = BookingTransaction::where('is_paid', true)->sum('total_amount');
        return [
            Stat::make('Total Transaction', $totalTransaction)
                ->description('all transaction')
                ->descriptionIcon('heroicon-o-currency-dollar'),
            Stat::make('Approved Transaction', $approvedTransaction)
                ->description('all approved transaction')
                ->descriptionIcon('heroicon-o-check-circle'),
            Stat::make('Total Revenue', 'IDR' . $totalRevenue)
                ->description('revenue from approved transaction')
                // ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
        ];
    }
}
