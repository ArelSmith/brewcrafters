<?php

namespace App\Filament\User\Pages;

use App\Filament\User\Widgets\UserTransactionsOverview;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use App\Models\User;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Page
{
    public ?User $user = null;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Home;
    protected string $view = 'filament.user.pages.dashboard';

    protected static ?string $title = 'Dashboard';


    public function mount() {
        $this->user = Auth::user();
    }

    public function getHeading(): string
    {
        return 'Hello, ' . $this->user->name;
    }

    public function getSubHeading(): string {
        $quotes = [
            "Coffee is a language in itself.",
            "Life happens, coffee helps.",
            "Orchestrate your mornings to the tune of coffee.",
            "Coffee first, schemes later.",
            "Adventure in life is good, consistency in coffee even better.",
        ];

        return $quotes[array_rand($quotes)];
    }

    public function getHeaderWidgets(): array {
        return [
            UserTransactionsOverview::class,
        ];
    }
}
