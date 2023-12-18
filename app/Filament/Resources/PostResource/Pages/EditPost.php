<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\PostComment;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
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

        return [
            Actions\DeleteAction::make()
                ->visible($deleteActionVisibleAgreement)
        ];
    }
}
