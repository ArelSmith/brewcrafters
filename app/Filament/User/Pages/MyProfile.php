<?php

namespace App\Filament\User\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use BackedEnum;
use UnitEnum;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Model;

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
                    ->avatar()
                    ->maxSize(1024)
                    ->directory('profile-photos')
                    ->preserveFilenames()
                    ->columnSpanFull()
                ])
                ->columns(1),
            Section::make('Profile Information')
                ->description('Update your account\'s profile information and email address.')
                ->aside()
                ->schema([TextInput::make('name')->label('Name')->required()->maxLength(255)->dehydrated(true)->columnSpanFull()])
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

    public static function table(Table $table): Table
    {
        return $table->columns([
            ImageColumn::make('image')->label('Profile')->circular(), // makes it round
        ]);
    }
}
