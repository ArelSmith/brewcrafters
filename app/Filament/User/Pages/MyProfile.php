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
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;

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
            'country_code' => $user->country_code,
            'phone' => $user->phone,
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
                    Grid::make(3)
                        ->schema([
                            Select::make('country_code')
                                ->label('Code')
                                ->options([
                                    '+62' => '+62',
                                ])
                                ->default('+62')
                                ->searchable()
                                ->required()
                                ->columnSpan(1),

                            // Phone Number Field
                            TextInput::make('phone')
                                ->label('Phone Number')
                                ->placeholder('81234567890')
                                ->required()
                                ->regex('/^[0-9]{6,15}$/') // Only numbers, 6–15 digits
                                ->maxLength(15)
                                ->columnSpan(2),
                        ]),
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
                        ->requiredWith('new_password')
                        ->placeholder('Leave blank to keep current password'),
                    TextInput::make('new_password')
                        ->label('New Password')
                        ->password()
                        ->revealable()
                        ->dehydrated(true)
                        ->columnSpanFull()
                        ->minLength(8)
                        ->maxLength(255)
                        ->requiredWith('password')
                        ->placeholder('Leave blank to keep current password'),
                    TextInput::make('new_password_confirmation')
                        ->label('Confirm New Password')
                        ->password()
                        ->revealable()
                        ->dehydrated(true)
                        ->columnSpanFull()
                        ->same('new_password')
                        ->requiredWith('new_password')
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
                    // $data['phone'] = $data['country_code'] . $data['phone'];
                    // Log::info('Form Data: ', $data);
                    if(isset($data['password']) && isset($data['new_password']) && isset($data['new_password_confirmation']) && $data['new_password']) {
                        $hashedOldPassword = Auth::user()->password;
                        if(isset($data['password']) && Hash::check($data['password'], $hashedOldPassword)) {
                            if($data['new_password'] === $data['new_password_confirmation']) {
                                $data['password'] = Hash::make($data['new_password']);
                            } else {
                                Notification::make()
                                    ->danger()
                                    ->title('New password and confirmation do not match.')
                                    ->send();
                                return;
                            }
                        } else {
                            Notification::make()
                                ->danger()
                                ->title('Current password is incorrect.')
                                ->send();
                            return;
                        }
                    }
                    if (empty($data['password'])) {
                        unset($data['password']);
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
