<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $AbilityToEdit = function (Post $post) {
            if (isset($post->user_id)) {
                // Get the domain from the APP_URL environment variable
                $domainToCheck = preg_replace('#^https?://#', '', config('app.url'));
                if (Str::endsWith(Auth::user()->email, '@' . $domainToCheck)) {
                    if ($post->user_id === Auth::id())
                        return false;
                    return true;
                }

                if ($post->user_id === Auth::id())
                    return false;
            }

            return false;
        };

        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\RichEditor::make('content')
                            ->required()
                            ->minLength(10)
                            ->maxLength(255)
                            ->disabled($AbilityToEdit)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        $deleteActionVisibleAgreement = function (Post $post) {
            // Get the domain from the APP_URL environment variable
            $domainToCheck = preg_replace('#^https?://#', '', config('app.url'));
            if (Str::endsWith(Auth::user()->email, '@' . $domainToCheck))
                return true;

            if ($post->user_id === Auth::id())
                return true;

            return false;
        };

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('content')
                    ->markdown()
                    ->searchable()
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->visible($deleteActionVisibleAgreement),
                Tables\Actions\EditAction::make()
                    ->visible(fn (Post $post) => $post->user_id === Auth::id()),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CommentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
