<?php

namespace App\Filament\User\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class MyProfile extends Page implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];
    public ?User $user = null;
    protected string $view = 'filament.user.pages.my-profile';
    protected static ?string $navigationLabel = 'My Profile';
    protected static ?int $navigationSort = 2;
    public function mount(): void {
        $user = Auth::user();

        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'image' => $user->image,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->label('Name')
                ->required()
                ->maxLength(255)
                ->dehydrated(true),
            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(255)
                ->dehydrated(true),
            TextInput::make('phone')
                ->label('Phone Number')
                ->numeric()
                ->required(fn () => (bool) Auth::user()->phone)
                ->disabled(fn () => !Auth::user()->phone)
                ->placeholder(fn () => Auth::user()->phone ? null : "This user doesn't have any number")
                ->helperText(fn () => !Auth::user()->phone ? 'Contact admin to update your phone number' : null)
                ->maxLength(255)
                ->dehydrated(true),
            // TextInput::make('password')
            //     ->label('New Password')
            //     ->password()
            //     ->minLength(8)
            //     ->maxLength(255)
            //     ->dehydrated(fn ($state) => filled($state))
            //     ->rule('confirmed')
            //     ->helperText('Leave blank to keep current password.'),
             FileUpload::make('image')
                ->label('Upload new profile picture')
                ->directory('profile-photos')
                ->visibility('public')
                ->image()
                ->imageEditor()
                ->dehydrated(true)

        ];
    }

    protected function getFormModel()
    {
        return Auth::user();
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema($this->getFormSchema())
            ->model($this->getFormModel())
            ->statePath('data')
            ->operation('edit');
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        // dd($data);

        // Only update password if it's provided
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $this->getFormModel()->update($data);

        // session()->flash('status', 'Profile updated successfully!');
        Notification::make()
            ->success()
            ->title('Profile updated successfully!')
            ->send();
    }
}
