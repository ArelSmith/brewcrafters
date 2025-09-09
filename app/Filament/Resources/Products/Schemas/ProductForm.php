<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\ProductCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Log;
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
            Select::make('weight')
                ->options([
                    100 => '100g',
                    200 => '200g',
                    500 => '500g',
                    1000 => '1000g',
                ])
                ->placeholder('Select weight in grams (only for coffee)'),
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
                ->label('Category')
                ->options(ProductCategory::whereNull('parent_id')->pluck('name', 'id'))
                ->lazy()
                ->placeholder('Select category')
                ->searchable(),
            Select::make('child_id')
                ->required()
                ->label('Property 1')
                ->options(function ($get) {
                    $parentId = $get('parent_id');

                    return $parentId ? ProductCategory::where('parent_id', $parentId)->pluck('name', 'id') : [];
                })
                ->hidden(function($get) {
                    $parentId = $get('parent_id');
                    if(!$parentId) {
                        return true;
                    }
                })
                ->lazy()
                ->placeholder('Select property 1')
                ->searchable(),
            Select::make('child_2_id')
                ->required()
                ->label('Property 2')
                ->options(function ($get) {
                    $childId = $get('child_id');

                    return $childId ? ProductCategory::where('parent_id', $childId)->pluck('name', 'id') : [];
                })
                ->hidden(function($get) {
                    $childId = $get('child_id');
                    $query = ProductCategory::where('parent_id', $childId)->pluck('name', 'id');
                    if($query->count() == 0 || !$childId) {
                        return true;
                    }
                })
                ->lazy()
                ->placeholder('Select property 2')
                ->searchable(),
            Select::make('child_3_id')
                ->required()
                ->label('Property 3')
                ->options(function ($get) {
                    $childId = $get('child_2_id');

                    return $childId ? ProductCategory::where('parent_id', $childId)->pluck('name', 'id') : [];
                })
                ->hidden(function($get) {
                    $childId = $get('child_id');
                    $query = ProductCategory::where('parent_id', $childId)->pluck('name', 'id');
                    if($query->count() == 0 || !$childId) {
                        return true;
                    }
                })
                ->lazy()
                ->placeholder('Select property 3')
                ->searchable(),
            Select::make('status')
                ->disabled()
                ->dehydrated()
                ->options(['active' => 'Ready', 'inactive' => 'Sold Out']),
            FileUpload::make('image')
                ->required()
                ->label('Product Image')
                ->directory('product-images')
                ->disk('public')
                ->image()
                ->imageEditor()
                ->columnSpan(2),
            Textarea::make('description')->required()->columnSpan(2),
        ]);
    }
}
