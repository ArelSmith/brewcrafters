<?php

namespace App\Filament\User\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserTransactionsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("Your total transactions", auth()->user()->transactions()->count()),
            Stat::make('Your total posts', auth()->user()->posts()->count()),
        ];
    }
}
