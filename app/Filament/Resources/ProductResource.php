<?php

namespace App\Filament\Resources;

use App\Enums\ProductStatusEnum;
use App\Enums\RolesEnum;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ProductImages;
use App\Filament\Resources\ProductResource\Pages\ProductVariationTypes;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-m-queue-list';


    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::End;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Grid::make()
                ->schema([
                        TextInput::make('title')
                        ->required()
                        ->live(onBlur:true)
                        ->afterStateUpdated(
                            function(string $operation, $state, callable $set){
                                $set("slug", Str::slug($state));
                            }
                        ),

                        TextInput::make('slug')
                            ->required(),

                        Select::make('department_id')
                            ->relationship('department', 'name')
                            ->label(__('Department'))
                            ->preload()
                            ->searchable()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set) {
                                $set('category_id', null);
                            }),

                        Select::make('category_id')
                            ->relationship(
                                'category',
                                'name',
                                function (Builder $query, callable $get) {
                                    $departmentId = $get('department_id');
                                    if($departmentId) {
                                        $query->where('department_id', $departmentId);
                                    }
                                })
                            ->label(__('Category'))
                            ->preload()
                            ->searchable()
                            ->required(),
                ]),

            RichEditor::make('description')
                ->required()
                ->toolbarButtons([
                    'blockquote',
                    'bold',
                    'bulletList',
                    'h2',
                    'h3',
                    'italic',
                    'link',
                    'orderedList',
                    'redo',
                    'strike',
                    'underline',
                    'undo',
                    'table',
                ])
                ->columnSpan(2),
            TextInput::make('price')
                ->required()
                ->numeric(),
            TextInput::make('quantity')
                ->integer(),
            Select::make('status')
                    ->options(ProductStatusEnum::labels())
                    ->default(ProductStatusEnum::Draft->value)
                    ->required(),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('images')
                    ->collection('images')
                    ->limit(1)
                    ->conversion('thumb')
                    ->label(__('Image')),
                    // ->circular()
                    // ->size(50)
                    // ->default('https://via.placeholder.com/150'),

                TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->words(10),

                TextColumn::make('status')
                ->badge()
                ->colors(ProductStatusEnum::colors()),

                TextColumn::make('department.name'),
                TextColumn::make('category.name'),
                TextColumn::make('created_at')
                ->dateTime(),
                TextColumn::make('quantity')
                ->sortable()
                ->searchable(),


            ])
            ->filters([
                SelectFilter::make('status')
                ->options(ProductStatusEnum::labels()),
                SelectFilter::make('department_id')
                ->relationship('department', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'images' => Pages\ProductImages::route('/{record}/images'),
            'variation-types' => Pages\ProductVariationTypes::route('/{record}/variation-types'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array {
        return $page->generateNavigationItems([
            //right side sub navigation
                EditProduct::class,
                ProductImages::class,
                ProductVariationTypes::class,
        ]);
    }

    public static function canViewAny(): bool {
        $user = Filament::auth()->user();
        return $user && $user->hasRole(RolesEnum::Vendor);
    }
}
