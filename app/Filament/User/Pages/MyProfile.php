<?php

namespace App\Filament\User\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use BackedEnum;
use UnitEnum;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\Action;

class MyProfile extends Page implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];
    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserCircle;
    protected static string|UnitEnum|null $navigationGroup = 'Settings';
    protected static ?string $title = 'Edit Profile';
    protected static ?string $navigationLabel = 'My Profile';
    protected static ?int $navigationSort = 1;
    protected string $view = 'filament.user.pages.my-profile';

    public function mount(): void
    {
        $user = Auth::user();

        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
            'image' => $user->image,
        ]);
    }

    public function schema(Schema $schema): Schema
    {
        return $schema->components($this->getFormSchema())->statePath('data');
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Profile Picture')
                ->description('Update your profile picture.')
                ->aside()
                ->schema([
                    FileUpload::make('image')
                        ->label('Profile Picture')
                        ->image()
                        ->imageEditor()
                        ->imageEditorAspectRatios(['1:1'])
                        ->avatar()
                        ->maxSize(1024)
                        ->default('https://www.gravatar.com/avatar/' . md5(strtolower(trim(Auth::user()->email))) . '?s=200&d=mp')
                        ->directory('profile-photos')
                        ->preserveFilenames()
                        ->columnSpanFull(),
                ])
                ->columns(1),
            Section::make('Profile Information')
                ->description('Update your account\'s profile information and email address.')
                ->aside()
                ->schema([
                    TextInput::make('name')->label('Name')->required()->maxLength(255)->dehydrated(true)->columnSpanFull(), 
                    TextInput::make('email')->label('Email')->required()->maxLength(255)->dehydrated(true)->columnSpanFull(), 
                    TextInput::make('phone')->label('Phone Number')->maxLength(255)->dehydrated(true)->placeholder('Add your number here!')->columnSpanFull()
                ])
                ->columns(2),
            Section::make('Change Password')
                ->description('Ensure your account is using a long, random password to stay secure.')
                ->aside()
                ->schema([
                    TextInput::make('password')
                        ->label('Current Password')
                        ->password()
                        ->revealable()
                        ->dehydrated(true)
                        ->columnSpanFull()
                        ->placeholder('Leave blank to keep current password'),
                    TextInput::make('new_password')
                        ->label('New Password')
                        ->password()
                        ->revealable()
                        ->dehydrated(true)
                        ->columnSpanFull()
                        ->minLength(8)
                        ->maxLength(255)
                        ->placeholder('Leave blank to keep current password'),
                    TextInput::make('new_password_confirmation')
                        ->label('Confirm New Password')
                        ->password()
                        ->revealable()
                        ->dehydrated(true)
                        ->columnSpanFull()
                        ->same('new_password')
                        ->placeholder('Leave blank to keep current password'),
                ])
                ->columns(2),
        ];
    }

    protected function getFormModel(): Model|string|null
    {
        return Auth::user();
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save')
                ->button()
                ->color('primary')
                ->action(function () {
                    $data = $this->form->getState();

                    if (empty($data['password'])) {
                        unset($data['password']);
                    }

                    if(empty($data['new_password'])) {
                        unset($data['new_password']);
                    } else {
                        $hashedOldPassword = Auth::user()->password;
                        if(Hash::check($data['new_password'], $hashedOldPassword)) {
                            Notification::make()
                                ->danger()
                                ->title('The new password cannot be the same as the current password.')
                                ->send();
                            return;
                        } else {
                            if($data['new_password'] !== $data['new_password_confirmation']) {
                                Notification::make()
                                    ->danger()
                                    ->title('The new password and confirmation do not match.')
                                    ->send();
                                return;
                            } else {
                                $data['password'] = Hash::make($data['new_password']);
                                unset($data['new_password']);
                                unset($data['new_password_confirmation']);
                            }
                        }
                    }
                    $this->getFormModel()->update($data);


                    Notification::make()
                        ->success()
                        ->title('Profile updated successfully!')
                        ->send();
                })
                // ->requiresConfirmation()
                // ->modalHeading('Save Changes'),
        ];
    }
}
