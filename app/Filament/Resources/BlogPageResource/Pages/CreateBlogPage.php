<?php

namespace App\Filament\Resources\BlogPageResource\Pages;

use App\Filament\Resources\BlogPageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogPage extends CreateRecord
{
    protected static string $resource = BlogPageResource::class;
}
