<?php

namespace App\Filament\User\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;

class MyProfile extends Page implements HasForms
{
    use InteractsWithForms;
    protected string $view = 'filament.user.pages.my-profile';
    protected static ?string $navigationLabel = 'My Profile';
    protected static ?int $navigationSort = 2;

    public function mount(): void {
        $user = Auth::user();

        // dd($user);

        $this->form->fill([
            'name'=> $user->name,
            'email'=> $user->email,
            'phone'=> $user->phone,
            'password'=> '',
            'image' => $user->image,
        ]);
    }

    protected function getFormSchema(): array {
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
                ->label('Phone')
                ->tel()
                ->maxLength(20),
            TextInput::make('password')
                ->label('Password')
                ->password()
                ->minLength(8)
                ->maxLength(255)
                ->dehydrated(fn ($state) => filled($state))
                ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                ->helperText('Leave blank to keep current password.'),
        ];
    }


    protected function save(): void {
        $data = $this->form->getState();

        $user = Auth::user();
        $user->name = $data['name'] ?? $user->name;
        $user->email = $data['email'] ?? $user->email;
        $user->phone = $data['phone'] ?? $user->phone;
        if(!empty($data['image'])) {
            $user->image = $data['image'];
        }
        $user->save();

        $this->notify('success', 'Profile updated successfully.');
    }
}
