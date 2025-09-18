<?php

namespace App\Filament\User\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;

class MyProfile extends Page implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];
    protected string $view = 'filament.user.pages.my-profile';
    protected static ?string $navigationLabel = 'My Profile';
    protected static ?int $navigationSort = 2;

    public function mount(): void {
        $user = Auth::user();

        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->label('Name')
                ->required()
                ->maxLength(255),
            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(255),
            TextInput::make('phone')
                ->label('Phone Number')
                ->numeric()
                ->required()
                ->disabled(fn () => !Auth::user()->phone)
                ->placeholder(fn () => Auth::user()->phone ? null : "This user doesn't have any number")
                ->helperText(fn () => !Auth::user()->phone ? 'Contact admin to update your phone number' : null)
                ->maxLength(255),
            TextInput::make('password')
                ->label('New Password')
                ->password()
                ->minLength(8)
                ->maxLength(255)
                ->dehydrated(fn ($state) => filled($state))
                ->rule('confirmed')
                ->helperText('Leave blank to keep current password.'),
        ];
    }

    public function form(Schema $form): Schema
    {
        return $form->schema($this->getFormSchema())->model(Auth::user())->statePath('data');
    }

}
