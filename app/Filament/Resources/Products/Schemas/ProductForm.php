<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\ProductCategory;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Str;

use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->required()
                ->label('Product Name')
                ->lazy()
                ->afterStateUpdated(function ($state, $set) {
                    $set('slug', Str::slug($state));
                }),
            TextInput::make('slug')->disabled()->dehydrated(),
            TextInput::make('price')->required()->numeric()->default(0),
            TextInput::make('stock')
                ->required()
                ->numeric()
                ->minValue(0)
                ->default(0)
                ->lazy()
                ->afterStateUpdated(function ($state, $set) {
                    if ($state <= 0) {
                        $set('status', 'inactive');
                    } else {
                        $set('status', 'active');
                    }
                }),
            Select::make('parent_id')
                ->required()
                ->label('Parent Category')
                ->options(ProductCategory::whereNull('parent_id')->pluck('name', 'id'))
                ->searchable(),
            Select::make('children_id')
                ->required()
                ->label('Children Category')
                ->options(function (callable $get) {
                    $parentId = $get('parent_id');
                    if (!$parentId) {
                        return [];
                    }

                    return ProductCategory::where('parent_id', $parentId)->pluck('name', 'id');
                })
                ->searchable(),
            Select::make('status')
                ->disabled()
                ->dehydrated()
                ->options(['active' => 'Ready', 'inactive' => 'Sold Out']),
            Textarea::make('description')->required()->columnSpan(2),
        ]);
    }
}
