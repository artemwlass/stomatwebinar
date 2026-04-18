<?php

namespace App\Filament\Resources\AccountPageResource\Pages;

use App\Filament\Resources\AccountPageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAccountPage extends CreateRecord
{
    protected static string $resource = AccountPageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['dashboard_stats'] = $data['dashboard_stats'] ?: [
            ['label' => 'Текст', 'value' => '2000'],
            ['label' => 'Текст', 'value' => '350 +'],
            ['label' => 'Текст', 'value' => '15 000'],
        ];

        return $data;
    }
}
