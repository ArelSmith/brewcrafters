<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Models\BlogCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(fn() => Auth::user()->id),
                TextInput::make('title')
                    ->required()
                    ->lazy()
                    ->afterStateUpdated(function($state, $set) {
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated(),
                Select::make('category_id')
                    ->required()
                    ->label('Category')
                    ->relationship('category', 'name'),
                FileUpload::make('thumbnail')
                    ->required()
                    ->maxWidth(800)
                    ->columnSpan(2)
                    ->image(),
                RichEditor::make('body')
                    ->required()
                    ->columnSpan(2),
            ]);
    }
}
