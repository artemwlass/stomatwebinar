<?php

namespace App\Filament\Resources\AccountPageResource\Pages;

use App\Filament\Resources\AccountPageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAccountPage extends CreateRecord
{
    protected static string $resource = AccountPageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['header_links'] = $data['header_links'] ?: [
            ['label' => 'Найближчий вебінар', 'url' => '/'],
            ['label' => 'Купити все для ендо', 'url' => '/'],
            ['label' => 'Безкоштовні вебінари', 'url' => '/'],
            ['label' => 'Контакти', 'url' => '/'],
        ];

        return $data;
    }
}
