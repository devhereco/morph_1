<?php

namespace App\Filament\Resources\PostResource\RelationManagers;

use App\Models\PostComment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\RichEditor::make('content')
                    ->required()
                    ->minLength(10)
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        $deleteActionVisibleAgreement = function (PostComment $comment) {
            // Get the domain from the APP_URL environment variable
            $domainToCheck = preg_replace('#^https?://#', '', config('app.url'));
            if (Str::endsWith(Auth::user()->email, '@' . $domainToCheck))
                return true;

            if ($comment->user_id === Auth::id())
                return true;

            return false;
        };

        return $table
            ->recordTitleAttribute('content')
            ->columns([
                Tables\Columns\TextColumn::make('content')
                    ->markdown()
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn (PostComment $comment) => $comment->user_id === Auth::id()),
                Tables\Actions\DeleteAction::make()
                    ->visible($deleteActionVisibleAgreement)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
